<?php

include_once(dirname(__FILE__)."/rdfFragments.php");
include_once(dirname(__FILE__)."/x509Functions.php");
include_once(dirname(__FILE__)."/foafStore.php");



function postSparul($uri, $sparul)
{
	$c = curl_init();
	curl_setopt($c, CURLOPT_URL, $uri);
	// this prevents the return value being dumped to sdtout
	curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($c, CURLOPT_POST, true);
	curl_setopt($c, CURLOPT_POSTFIELDS, $sparul);
	@curl_exec ($c);
	curl_close ($c);
}




//-----------------------------------------------------------------------------------------------------------------------------------
//
// Main
//
//-----------------------------------------------------------------------------------------------------------------------------------

// Check that script is called using the HTTPS protocol
if ($_GET[foaf] == NULL)
{
	session_name('phpMyID_Server');
	session_start();
	$agent = (!empty($_SESSION['auth']) && $_SESSION['auth']['subjectAltName'])? $_SESSION['auth']['subjectAltName'] : '';
	$agent = $_REQUEST['webid']?$_REQUEST['webid']:$agent;

	include('head.php'); ?>

	<body id="tools_scrollable">

		<div id="wrap">	
				
			<?php include('header.php'); ?>


	<h1>Temporary Account Generator</h1>
	<h2>Step 1: Generate Certificate</h2>
	<form name="input" action="http://foaf.me/tempaccount.php" method="get">
	<table>
	<tr>
	<td>Username</td><td><input type="text" size="25" id="foaf" name="foaf"></td><td style="color:blue"><button id="generate" type="submit">Generate!</button> 
	<input type="hidden" id="commonName" name="commonName" value="FOAF ME Cert"></td>
	<td><input type="hidden" id="uri" name="uri" value="Nickname"></td><td style="color:blue"></td>
	</tr>
	<tr>
	<td>Key Length</td><td><keygen name="pubkey" challenge="randomchars"></td><td></td><td></td>
	</tr>
	</table>
	</form>
	<br><br>

    <div class="success" id="step2" style='display:none'>
	    Congratulations!  Your Account is almost ready to be used!
		After installing your browser certificate, please click <a id="link" href="#">here</a> to visit your account.
	</div>
		</div>

	<script>
	var rand = 10000 + Math.round(Math.random()*90000)
	$("#foaf").val("http://foaf.me/temp" + rand);
	$("#uri").val("temp" + rand);
	$("#link").attr("href", "http://foaf.me/temp" + rand);
	$("#commonName").val("FOAF ME Temp Acct " + rand);
	$("#generate").click(function(){ $("#step2").show("slow"); });
	</script>

</body>

</html>

<?

}
else {

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


	// Get the rest of the script parameters
	$countryName			= $_GET[countryName];
	$stateOrProvinceName	= $_GET[stateOrProvinceName];
	$localityName			= $_GET[localityName];
	$organizationName		= $_GET[organizationName];
	$organizationalUnitName = $_GET[organizationalUnitName];
	$emailAddress			= $_GET[emailAddress];
	$pubkey					= $_GET[pubkey];
	$uri					= $_GET[uri];

	// Create a x509 SSL certificate
	if ( $x509 = create_identity_x509(
				$countryName, $stateOrProvinceName, $localityName, $organizationName, $organizationalUnitName, $commonName, $emailAddress,
				$foafLocation, $pubkey ) )
	{	
		$key = get_pkey($x509);


		//$rdf = generate_rdf($foafLocation, $uri, $key);
		$contents = file_get_contents($uri);
        //$rdf = generate_rdf($foafLocation, $uri, '');

		//store_rdf($uri, $rdf);
	
		$webid = $foafLocation;
		$public_exponent = 65537;
		$modulus = $key['modulus'];

		// @TODO need to check if the foaf hosting server is SPARUL capable
		// @TODO inform the caller if the sparul fails
		//if ( strpos ( $webid, 'foaf.me' ) !== FALSE ) {
			@postSparul("$webid", "INSERT { <$webid#cert> <http://www.w3.org/1999/02/22-rdf-syntax-ns#type> <http://www.w3.org/ns/auth/rsa#RSAPublicKey> ; <http://www.w3.org/ns/auth/cert#identity> <$webid#me> ; <http://www.w3.org/ns/auth/rsa#modulus> <$webid#modulus> ; <http://www.w3.org/ns/auth/rsa#public_exponent> <$webid#public_exponent> . <$webid#modulus> <http://www.w3.org/ns/auth/cert#hex> \"$modulus\" .  <$webid#public_exponent> <http://www.w3.org/ns/auth/cert#decimal> \"$public_exponent\" . }");
		//}

		// Send the X.509 SSL certificate to the script caller as a file transfer
		download_identity_x509($x509);
	}

}
?>
