<?php

//-----------------------------------------------------------------------------------------------------------------------------------
//
// Filename   : spkac_cert.php                                                                                                         
// Version    : 1.0
// Date       : 14th Jan 2009
//
// Decription : This script creates an X.509 SSL Certificate based on a supplied SPKAC.
//
// Usage      : spkac_cert.php?foaf=http://foaf.me/jsmith&
//                       commonName=J Smith&
//                       emailAddress=jsmith@example.com&
//                       organizationName=My Company Ltd&
//                       organizationalUnitName=Technology Division&
//                       localityName=Newbury&
//				         stateOrProvinceName=Berkshire&
//                       countryName=GB&
//                       pubkey=***...***
//
//              All parameters except 'foaf' and 'commonName' are optional. Some parameters if missing will default as per openssl.cnf 
//
// See Also   : This script is entirely based on 
//              http://phpmylogin.sourceforge.net/wiki/doku.php?id=keygen_attribute
//
//-----------------------------------------------------------------------------------------------------------------------------------


// Returns a X.509 SSL certificate
function create_identity_x509( 
	$countryName,  $stateOrProvinceName, $localityName, $organizationName, $organizationalUnitName, $commonName, $emailAddress,
	$foafLocation, $pubkey)
{
	// Remove any whitespace in teh supplied SPKAC
	$keyreq = "SPKAC=".str_replace(str_split(" \t\n\r\0\x0B"), '', $pubkey);

	// Create the DN for the openssl call
	if ($countryName)
		$keyreq .= "\ncountryName=".$countryName;

	if ($stateOrProvinceName)
		$keyreq .= "\nstateOrProvinceName=".$stateOrProvinceName;

	if ($localityName)
		$keyreq .= "\nlocalityName=".$localityName;

	if ($organizationName)
		$keyreq .= "\norganizationName=".$organizationName;

	if ($organizationalUnitName)
		$keyreq .= "\n0.OU=".$organizationalUnitName;

	if ($commonName)
		$keyreq .= "\nCN=".$commonName;

	if ($emailAddress) 
		$keyreq .= "\nemailAddress=".$emailAddress;

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
	
	// Create temporary files to hold the input and output to the openssl call.
	$tmpSPKACfname = tempnam("/tmp", "SPK");
	$tmpCERTfname  = tempnam("/tmp", "CRT");

	// Write the SPKAC and DN into the temporary file
	$handle = fopen($tmpSPKACfname, "w");
	fwrite($handle, $keyreq);
	fclose($handle);

	// TODO - This should be more easily configured
	$command = "openssl ca -config /usr/share/ssl/openssl.cnf -verbose -batch -notext -spkac $tmpSPKACfname -out $tmpCERTfname -passin file:/home/foaf/ssl/password 2>&1";

	// Run the command;
	$output = `$command`;

	// TODO - Check for failures on the command
	if (preg_match("/Data Base Updated/", $output)==0)
	{
		print "Failed to create X.509 Certificate<br><br>";
		print "<pre>";
		print $output;
		print "</pre>";
	
		return;
	}

	// Delete the temporary SPKAC and DN file
	unlink($tmpSPKACfname);

	return $tmpCERTfname;
}

// Send the p12 encoded SSL certificate as a file transfer
function download_identity_x509($certLocation)
{
	$length = filesize($certLocation);	
	header('Last-Modified: '.date('r+b'));
	header('Accept-Ranges: bytes');
	header('Content-Length: '.$length);
	header('Content-Type: application/x-x509-user-cert');
	readfile($certLocation);

	unlink($certLocation);

	exit;
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
	print "pubkey=***...***</ul>";
	exit();
}

// Check if the foaf location is specified in the script call
$foafLocation = $_GET[foaf];
if (!$foafLocation)
{
	if (array_key_exists('foaf', $_GET))
		$query = $_SERVER[QUERY_STRING];
	else
		$query = ($_SERVER[QUERY_STRING]?$_SERVER[QUERY_STRING]."&":"") . "foaf=";

	print "Please specify the location of your foaf file. <a href='https://foaf.me/spkac_cert.php?" . $query . "'>https://foaf.me/spkac_cert.php?foaf=</a><font color='red'><b>http://foaf.me/nickname</b></font><br><br>The FOAF location is added to the SubjectAltName within the SSL Client Certificate<br>";

	exit();
}

// Check if the commonName is specified in the script call
$commonName	= $_GET[commonName];
if (!$commonName)
{
	if (array_key_exists('commonName', $_GET))
		$query = $_SERVER[QUERY_STRING];
	else
		$query = ($_SERVER[QUERY_STRING]?$_SERVER[QUERY_STRING]."&":"") . "commonName=";

	print "Please specify the Common Name to be added to your certficate. <a href='https://foaf.me/spkac_cert.php?" . $query . "'>https://foaf.me/spkac_cert.php?commonName=</a><font color='red'><b>Common Name</b></font><br><br>";

	exit();
}

// Check that script is called using the HTTPS protocol
if ($_SERVER[HTTPS] == NULL)
{
	print "Please use the following secure uri to download the Identity P12. <a href='https://foaf.me/spkac_cert.php?" . $_SERVER[QUERY_STRING] . "'>https://foaf.me/spkac_cert.php?" . $_SERVER[QUERY_STRING] . "</a><br>";

	exit();
}

// Get the rest of the script parameters
$countryName			= $_GET[countryName];
$stateOrProvinceName	= $_GET[stateOrProvinceName];
$localityName			= $_GET[localityName];
$organizationName		= $_GET[organizationName];
$organizationalUnitName = $_GET[organizationalUnitName];
$emailAddress			= $_GET[emailAddress];
$pubkey					= $_GET[pubkey];

// Create a x509 SSL certificate
if ( $x509 = create_identity_x509(
			$countryName, $stateOrProvinceName, $localityName, $organizationName, $organizationalUnitName, $commonName, $emailAddress,
			$foafLocation, $pubkey ) )
{	
	// Send the X.509 SSL certificate to the script caller as a file transfer
	download_identity_x509($x509);
}

?>