<?

include_once("/home/foaf/public_html/rdfFragments.php");
include_once("/home/foaf/public_html/x509Functions.php");
include_once("/home/foaf/public_html/foafStore.php");

$foafuri  = $_GET[foafuri];

if (!$foafuri)
{
	if (array_key_exists('foafuri', $_GET))
		$query = $_SERVER[QUERY_STRING];
	else
		$query = ($_SERVER[QUERY_STRING]?$_SERVER[QUERY_STRING]."&":"") . "foafuri=";

	print "Please specify the location of a dereferencable foaf:Person. <a href='http://foaf.me/createCertificateAccount.php?" . $query . "'>http://foaf.me/createCertificateAccount.php?foafuri=</a>";

	exit();
}

$nickname = $_GET[nickname];

if (!$nickname)
{
	if (array_key_exists('nickname', $_GET))
		$query = $_SERVER[QUERY_STRING];
	else
		$query = ($_SERVER[QUERY_STRING]?$_SERVER[QUERY_STRING]."&":"") . "nickname=";

	print "Please specify the Common Name to be added to the Client Certificate. <a href='http://foaf.me/createCertificateAccount.php?" . $query . "'>http://foaf.me/createCertificateAccount.php?nickname=</a>";

	exit();
}

$pubkey   = $_GET[pubkey];

if (!$pubkey)
{
	if (array_key_exists('pubkey', $_GET))
		$query = $_SERVER[QUERY_STRING];
	else
		$query = ($_SERVER[QUERY_STRING]?$_SERVER[QUERY_STRING]."&":"") . "pubkey=";

	print "Please specify the pubkey (KEYGEN) to be used in SPKAC generated certificate. <a href='http://foaf.me/createCertificateAccount.php?" . $query . "'>http://foaf.me/createCertificateAccount.php?pubkey=</a>";

	exit();
}

$nicknametmp = 'temp/'.urlencode($nickname);
$nicknameuri = 'http://foaf.me/temp/'.urlencode($nickname);

if($x509 = create_identity_x509(
			NULL, NULL, NULL, NULL, NULL, $nickname, NULL, $nicknameuri, $pubkey ))
{
	$key = get_pkey($x509);

	$rdf = generate_rdf($foafuri, $nicknameuri, $key);

	store_rdf('temp/'.$nickname, $rdf);

	download_identity_x509($x509);
}

?>