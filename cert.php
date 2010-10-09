<?php

//-----------------------------------------------------------------------------------------------------------------------------------
//
// Filename   : cert.php                                                                                                            
// Version    : 1.0
// Date       : 3rd Jan 2009
//
// Decription : This script creates an PKCS12 encoded SSL Certificate which is file transfered to the script caller.
//
// Usage      : cert.php?foaf=http://foaf.me/jsmith&
//                       commonName=J Smith&
//                       emailAddress=jsmith@example.com&
//                       organizationName=My Company Ltd&
//                       organizationalUnitName=Technology Division&
//                       localityName=Newbury&
//				         stateOrProvinceName=Berkshire&
//                       countryName=GB&
//                       password=secret
//
//              All parameters except 'foaf' are optional. Some parameters if missing will default as per openssl.cnf 
//
// See Also   : Using PHP to create self-signed X.509 Client Certificates
//              http://foaf.me/Using_PHP_to_create_X.509_Client_Certificates.php
//
//-----------------------------------------------------------------------------------------------------------------------------------


// Returns a PKCS12 encoded SSL certificate
function create_identity_p12( 
	$countryName,  $stateOrProvinceName, $localityName, $organizationName, $organizationalUnitName, $commonName, $emailAddress,
	$foafLocation, $p12Password)
{
	// Create the DN array for the openssl function calls
	if ($countryName)
		$dn = array("countryName" => $countryName);

	if ($stateOrProvinceName)
	{	
		if ($dn)
			$dn = array_merge($dn, array("stateOrProvinceName" => $stateOrProvinceName));
		else
			$dn = array("stateOrProvinceName" => $stateOrProvinceName);
	}

	if ($localityName)
	{
		if ($dn)
			$dn = array_merge($dn, array("localityName" => $localityName));
		else
			$dn = array("localityName" => $localityName);
	}

	if ($organizationName)
	{
		if ($dn)
			$dn = array_merge($dn, array("organizationName" => $organizationName));
		else
			$dn = array("organizationName" => $organizationName);
	}

	if ($organizationalUnitName)
	{
		if ($dn)
			$dn = array_merge($dn, array("organizationalUnitName" => $organizationalUnitName));
		else
			$dn = array("organizationalUnitName" => $organizationalUnitName);
	}

	if ($commonName)
	{
		if ($dn)
			$dn = array_merge($dn, array("commonName" => $commonName));
		else
			$dn = array("commonName" => $commonName);
	}

	if ($emailAddress) 
	{
		if ($dn)
			$dn = array_merge($dn, array("emailAddress" => $emailAddress));
		else
			$dn = array("emailAddress" => $emailAddress);
	}

	// if the $dn array is NULL at this point set country name to the default of GB
	if (!$dn)
		$dn = array("countryName" => "GB");

	// Setup the contents of the subjectAltName
	if ($foafLocation)
		$SAN="URI:$foafLocation";

	if ($emailAddress) 
	{
		if ($SAN)
			$SAN.=",email:$emailAddress";
		else
			$SAN="email:$emailAddress";
	}

	// Export the subjectAltName to be picked up by the openssl.cnf file
	if ($SAN)
	{
		putenv("SAN=$SAN");
	}

	// Create the array to hold the configuration options for the openssl function calls
	// TODO - This should be more easily configured
	$config = array('config'=>'/ebs1/ssl/openssl.cnf');

	if ($SAN)
	{
		// TODO - This should be more easily configured
		$config = array_merge($config, array('x509_extensions' => 'usr_cert'));
	}

	// Generate a new private (and public) key pair
	$privkey = openssl_pkey_new($config);

	if ($privkey==FALSE) 
	{
		// Show any errors that occurred here
		while (($e = openssl_error_string()) !== false)
		{
			echo $e . "\n";
			print "<br><br>";
		}
	}

	// Generate a certificate signing request
	$csr = openssl_csr_new($dn, $privkey, $config);

	if (!$csr)
	{
		// Show any errors that occurred here
		while (($e = openssl_error_string()) !== false) 
		{
			echo $e . "\n";
			print "<br><br>";
		}
	}

	// You will usually want to create a self-signed certificate at this
	// point until your CA fulfills your request.
	// This creates a self-signed cert that is valid for 365 days
	$sscert = openssl_csr_sign($csr, null, $privkey, 365, $config);

	if ($sscert==FALSE) 
	{
		// Show any errors that occurred here
		while (($e = openssl_error_string()) !== false)
		{
			echo $e . "\n";
			print "<br><br>";
		}
	}

	if (openssl_pkcs12_export($sscert, $p12Out, $privkey, $p12Password)==FALSE)
	{
		// Show any errors that occurred here
		while (($e = openssl_error_string()) !== false) 
		{
			echo $e . "\n";
			print "<br><br>";
		}
	}

	return $p12Out;
}

// Send the p12 encoded SSL certificate as a file transfer
function download_identity_p12($p12, $foafLocation)
{
	// set headers
	header("Pragma: private");
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Cache-Control: private");
	header("Content-Description: File Transfer");
	header("Content-Type: application/x-pkcs12");
	
	$file = basename($foafLocation);

	header("Content-Disposition: attachment; filename=\"$file.p12\"");
	header("Content-Transfer-Encoding: binary");
	header("Content-Length: " . strlen($p12));

	print($p12);

	flush();
    if (connection_status()!=0) 
	{
		@fclose($file);
		die();
    }

}

//-----------------------------------------------------------------------------------------------------------------------------------
//
// Main
//
//-----------------------------------------------------------------------------------------------------------------------------------

// Print out the permitted script parameters
if ($_GET[help])
{
	print "cert.php?<br>";
	print "<ul>foaf=http://foaf.me/jsmith&<br><br>";
	print "commonName=J Smith&<br><br>";
	print "emailAddress=jsmith@example.com&<br><br>";
	print "organizationName=My Company Ltd&<br><br>";
	print "organizationalUnitName=Technology Division&<br><br>";
	print "localityName=Newbury&<br><br>";
	print "stateOrProvinceName=Berkshire&<br><br>";
	print "countryName=GB&<br><br>";
	print "password=secret<br></ul>";
	exit();
}

// Check if the foaf loaction is specified in the script call
$foafLocation = $_GET[foaf];
if (!$foafLocation)
{
	if (array_key_exists('foaf', $_GET))
		$query = $_SERVER[QUERY_STRING];
	else
		$query = ($_SERVER[QUERY_STRING]?$_SERVER[QUERY_STRING]."&":"") . "foaf=";

	print "Please specify the location of your foaf file. <a href='https://foaf.me/cert.php?" . $query . "'>https://foaf.me/cert.php?foaf=</a><font color='red'><b>http://foaf.me/nickname</b></font><br><br>The FOAF location is added to the SubjectAltName within the SSL Client Certificate<br>";

	exit();
}

// Check that script is called using the HTTPS protocol
if ($_SERVER[HTTPS] == NULL)
{
	print "Please use the following secure uri to download the Identity P12. <a href='https://foaf.me/cert.php?" . $_SERVER[QUERY_STRING] . "'>https://foaf.me/cert.php?" . $_SERVER[QUERY_STRING] . "</a><br>";

	exit();
}

// Get the rest of the script parameters
$countryName			= $_GET[countryName];
$stateOrProvinceName	= $_GET[stateOrProvinceName];
$localityName			= $_GET[localityName];
$organizationName		= $_GET[organizationName];
$organizationalUnitName = $_GET[organizationalUnitName];
$commonName				= $_GET[commonName];
$emailAddress			= $_GET[emailAddress];
$p12Password			= $_GET[password];

// Create a PKCS12 encoded SSL certificate
if ( $p12 = create_identity_p12(
			$countryName, $stateOrProvinceName, $localityName, $organizationName, $organizationalUnitName, $commonName, $emailAddress,
			$foafLocation, $p12Password ) )
{	
	// Send the PKCS12 encoded SSL certificate to the script caller as a file transfer
	download_identity_p12($p12, $foafLocation);
}

?>
