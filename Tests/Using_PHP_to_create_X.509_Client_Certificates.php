<?
require_once('/home/foaf/public_html/v1/documentation.php');

page_header("Using PHP to create self-signed X.509 Client Certificates");
?>
<body>
<h1><a name="s0">Using PHP to create self-signed X.509 Client Certificates</a></h1>
The following is a recipe on how to create a self-signed X.509 client certificates.<br>
This is one of the steps to implement the <a href="http://www.w3.org/2008/09/msnws/papers/foaf+ssl.html">FOAF + SSL protocol</a> as outlined by <a href="http://bblfish.net/">Henry Story</a>.<br>
<b>
<ul>
1. <a href="#s1">Assumptions</a><br>
2. <a href="#s2">Add SubjectAltName to openssl.cnf</a><br>
<br>
3. <a href="#s3">Create an array with the appropriate configuration for the openssl function calls</a><br>
4. <a href="#s4">Create a private/public key pair</a><br>
5. <a href="#s5">Generate a certificate signing request</a><br>
6. <a href="#s6">Generate a self-signed certificate</a><br>
7. <a href="#s7">Generate a PKCS12</a><br>
<br>
8. <a href="#s8">function create_identity_p12()</a><br>
9. <a href="#s9">function download_identity_p12()</a><br>
<br>
10. <a href="#s10">cert.php</a><br>
11. <a href="#s11">Example Form</a><br>
12. <a href="#s12">Downloads</a><br>
<br>
13. <a href="#s13">Security Considerations</a><br>
14. <a href="#s14">See Also</a><br>
15. <a href="#s15">External Links</a>
</ul>
</b>
<br>
<?
section_header("1", "Assumptions");
?>
<br>The starting assumption of this recipe is that your PHP installation has the OpenSSL PHP extension installed and working.<br>
If not the instructions are here: <a href=http://uk2.php.net/manual/en/intro.openssl.php>http://uk2.php.net/manual/en/intro.openssl.php</a><br>
<br>
<?
section_header("2", "Add SubjectAltName to openssl.cnf");
?>
<br>
The FOAF+SSL protocol requires that the URI of your FOAF file is stored in the "subjectAltName" within the X509v3 extensions section.<br>
To do this add the following line to the openssl.cnf of your OpenSSL installation<br>
<pre id=code>
subjectAltName=${ENV::SAN}
</pre>
This directive should be added to the 'x509_extensions' section.<br>
<br>
In our case it was within the [usr_cert] section of /usr/share/ssl/openssl.cnf as specifiec by this directive 'x509_extensions	= usr_cert		# The extentions to add to the cert
'<br>
<br>
Adding as an env variable allows us to set this before the openssl certificates creation calls without editting the openssl.cnf file further.<br>
<br>
<?
section_header("3", "Create an array with the appropriate configuration for the openssl function calls");
?>
<ul>
1, Reference the openssl.cnf file which was editted as outlined in the previous section.<br>
2, Point the certificate creation functions to the x509_extensions directives.<br>
3, Export an env variable 'SAN' which holds the string URI:foaflocation,email:email@address.com. 'SAN' was referenced in the v3 extension directive outlined above.
</ul>
<pre id=code>
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
	$config = array('config'=>'/usr/share/ssl/openssl.cnf');

	if ($SAN)
	{
		// TODO - This should be more easily configured
		$config = array_merge($config, array('x509_extensions' => 'usr_cert'));
	}
</pre>
<?
section_header("4", "Create a private/public key pair");
?>
<br>
NOTE: The private/public key pair is only held in memory at this stage.<br>
<pre id=code>
// Generate a new private (and public) key pair
$privkey = openssl_pkey_new($config);

if ($privkey==FALSE) 
{
	while (($e = openssl_error_string()) !== false)
	{
		echo $e . "\n";
		print "&lt;br&gt;&lt;br&gt;";
	}
}
</pre>
<?
section_header("5", "Generate a certificate signing request");
?>
<br>
NOTE: The signing request is only held in memory.<br>
<pre id=code>
$dn = array(
    "countryName" => "UK",
    "stateOrProvinceName" => "Somerset",
    "localityName" => "Glastonbury",
    "organizationName" => "The Brain Room Limited",
    "organizationalUnitName" => "PHP Documentation Team",
    "commonName" => "Wez Furlong",
    "emailAddress" => "wez@example.com"
);

// Generate a certificate signing request
$csr = openssl_csr_new($dn, $privkey, $config);

if (!$csr)
{
	while (($e = openssl_error_string()) !== false) 
	{
		echo $e . "\n";
		print "&lt;br&gt;&lt;br&gt;";
	}
}
</pre>
<?
section_header("6", "Generate a self-signed certificate");
?>
<br>
NOTE: The certificate is only held in memory.<br>
<pre id=code>
// You will usually want to create a self-signed certificate at this
// point until your CA fulfills your request.
// This creates a self-signed cert that is valid for 365 days
$sscert = openssl_csr_sign($csr, null, $privkey, 365, $config);

if ($sscert==FALSE) 
{
	while (($e = openssl_error_string()) !== false)
	{
		echo $e . "\n";
		print "&lt;br&gt;&lt;br&gt;";
	}
}
</pre>
<?
section_header("7", "Generate a PKCS12");
?>
<br>
NOTE: The PKCS12 certificate is only held in memory.<br>
<pre id=code>
if (openssl_pkcs12_export($sscert, $p12Out, $privkey, $p12Password)==FALSE)
{
	// Show any errors that occurred here
	while (($e = openssl_error_string()) !== false) 
	{
		echo $e . "\n";
		print "&lt;br&gt;&lt;br&gt;";
	}
}
</pre>
<?
section_header("8", "function create_identity_p12()");
?>
<br>
Putting it all in a single function.<br>
<pre id=code>
// Returns a p12 encoded SSL certificate
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
	$config = array('config'=>'/usr/share/ssl/openssl.cnf');

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
			print "&lt;br&gt;&lt;br&gt;";
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
			print "&lt;br&gt;&lt;br&gt;";
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
			print "&lt;br&gt;&lt;br&gt;";
		}
	}

	if (openssl_pkcs12_export($sscert, $p12Out, $privkey, $p12Password)==FALSE)
	{
		// Show any errors that occurred here
		while (($e = openssl_error_string()) !== false) 
		{
			echo $e . "\n";
			print "&lt;br&gt;&lt;br&gt;";
		}
	}

	return $p12Out;
}
</pre>
<?
section_header("9", "function download_identity_p12()");
?>
<pre id=code>
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
</pre>
<?
section_header("10", "cert.php");
?>
<pre id=code>
// Check if the foaf loaction is specified in the script call
$foafLocation = $_GET[foaf];
if (!$foafLocation)
{
	if (array_key_exists('foaf', $_GET))
		$query = $_SERVER[QUERY_STRING];
	else
		$query = ($_SERVER[QUERY_STRING]?$_SERVER[QUERY_STRING]."&":"") . "foaf=";

	print "Please specify the location of your foaf file. &lt;a href='https://foaf.me/cert.php?" . $query . 
	"'>https://foaf.me/cert.php?foaf=&lt;/a>&lt;font color='red'>&lt;b>http://foaf.me/nickname&lt;/b>&lt;/font>&lt;br>&lt;br>
	The FOAF location is added to the SubjectAltName within the SSL Client Certificate&lt;br>";

	exit();
}

// Check that script is called using the HTTPS protocol
if ($_SERVER[HTTPS] == NULL)
{
	print "Please use the following secure uri to download the Identity P12. &lt;a href='https://foaf.me/cert.php?" . $_SERVER[QUERY_STRING] . 
	"'>https://foaf.me/cert.php?" . $_SERVER[QUERY_STRING] . "&lt;/a>&lt;br>";

	exit();
}

// Get the rest of the script parameters
$countryName			= $_GET[countryName];
$stateOrProvinceName		= $_GET[stateOrProvinceName];
$localityName			= $_GET[localityName];
$organizationName		= $_GET[organizationName];
$organizationalUnitName	= $_GET[organizationalUnitName];
$commonName			= $_GET[commonName];
$emailAddress			= $_GET[emailAddress];
$p12Password			= $_GET[password];

// Create a p12 encoded SSL certificate
if ( $p12 = create_identity_p12(
			$countryName, $stateOrProvinceName, $localityName, $organizationName, $organizationalUnitName, $commonName, $emailAddress,
			$foafLocation, $p12Password ) )
{	
	// Send the p12 encoded SSL certificate to the script caller as a file transfer
	download_identity_p12($p12, $foafLocation);
}
</pre>
<?
section_header("11", "Example Form");
?>
<h3><a href="http://foaf.me/simpleCreateClientCertificate.php">Simple Create Client Certificate Form</a></h3><br>
<?
section_header("12", "Downloads");
?>
<ul>
<a href="download.php?uri=cert.php">cert.php</a><br>
<a href="download.php?uri=simpleCreateClientCertificate.php">simpleCreateClientCertificate.php</a><br>
</ul>
<br>
<?
section_header("13", "Security Considerations");
?>
<br>
The server script has access to the private/public key pair. A malicious script could farm this information for later use.<br>
<br>
<?
section_header("14", "See Also");
see_also();
section_header("15", "External Links");
?>
<ul>
<a href="http://en.wikipedia.org/wiki/X.509">http://en.wikipedia.org/wiki/X.509</a><br>
<a href="http://www.foaf-project.org/">http://www.foaf-project.org</a><br>
<a href="http://www.rsa.com/rsalabs/node.asp?id=2138">http://www.rsa.com/rsalabs/node.asp?id=2138</a> - PKCS12<br>
<a href="http://www.ipsec-howto.org/x600.html">http://www.ipsec-howto.org/x600.html</a><br>
</ul>
</body>
</html>