<?php

require_once 'config.php';

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
		$SAN="URI:$foafLocation" . "#me";

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
	$command = "openssl ca -config ".$GLOBALS['config']['openssl_config_dir']."/openssl.cnf -verbose -batch -notext -spkac $tmpSPKACfname -out $tmpCERTfname -passin file:".$GLOBALS['config']['openssl_config_dir']."/password 2>&1";

	// Run the command;
	$output = `$command`;
	// TODO - Check for failures on the command
	if (preg_match("/Data Base Updated/", $output)==0)
	{
		print "Failed to create X.509 Certificate<br><br>";
//		print "<pre>";
//		print $output;
//		print "</pre>";
	
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

function get_pkey($x509file)
{
	$command = "openssl asn1parse -inform DER -i -in $x509file";

	$rsa_cert_struct = `$command`;

	$rsa_cert_fields = split("\n", $rsa_cert_struct);
	$rsakey_offset   = split(":",  $rsa_cert_fields[45]);

	$command = "openssl asn1parse -inform DER -i -in $x509file -strparse $rsakey_offset[0]";

	$rsa_key = `$command`;

	$rsa_keys = split("\n", $rsa_key);
	$modulus  = split(":", $rsa_keys[1]);
	$exponent = split(":", $rsa_keys[2]);

	return(array( 'modulus'=>$modulus[3], 'exponent'=>$exponent[3] ) );
}
?>
