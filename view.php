<?

require_once("config.php");
require_once("db.class.php");
require_once('lib/libAuthentication.php');

$db = new db_class();
$db->connect('localhost', $config['db_user'], $config['db_pwd'], $config['db_name']);


function detect_ie()
{
    if (isset($_SERVER['HTTP_USER_AGENT']) && 
    (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false))
        return true;
    else
        return false;
}

function detect_safari()
{
    if (isset($_SERVER['HTTP_USER_AGENT']) && 
    (strpos($_SERVER['HTTP_USER_AGENT'], 'Safari') !== false))
        return true;
    else
        return false;
}

function logger($actionlog, $webid, $nickname)
{
	$fp = fopen($actionlog, 'a');
	$now = time();
	fwrite($fp, date('Y-m-d H:i:s', $now) . ' : webid : ' . $webid . ' : nickname : ' . $nickname . "\r\n");
	fclose($fp);
}

function sparulLog($page, $webid, $sparul) {
	//   return 1;
    $fp = fopen('/home/foaf/www/datawiki/sparul.log', 'a');
    $now = time();
    fwrite($fp, date('Y-m-d H:i:s', $now) . ' : webid : ' . $webid . ' : uri : ' . $page . ' : sparul : ' . $sparul . '' . "\r\n");
    fclose($fp);
}

function rdfLog($cmd, $page, $webid, $sparul = NULL, $rdf = NULL) {
	//   return 1;
    $fp = fopen('/home/foaf/www/datawiki/rdf.log', 'a');
    $now = time();
    fwrite($fp, date('Y-m-d H:i:s', $now) . ' : action : ' . $cmd . ' : webid : ' . $webid . ' : uri : ' . $page . ' : sparul : ' . $sparul . ' : rdf : ' . $rdf . '' . "\r\n");
    fclose($fp);
}

function xmlheader($xsl) {
	print '<?xml version="1.0" encoding="ISO-8859-1"?>' . "\n";
	if (false) {
  	    print '<?xml-stylesheet type="text/xsl" href="'. $xsl .'"?>' . "\n";
	}
}

$username = $_GET['username'];
$page    = 'http://' . $_SERVER['HTTP_HOST'] . '/' . $username;

/*
if ( $username == 'julietasself' ) $username = 'juliet';
if ( $username == 'julietasfriend' ) $username = 'juliet';
if ( $username == 'romeoasself' ) $username = 'romeo';
if ( $username == 'romeoasfriend' ) $username = 'romeo';
*/

if (preg_match('/^post$/i', $_SERVER['REQUEST_METHOD'])) 
{
//	logger('/home/foaf/www/datawiki/post.log', $webid, $username);

	include_once('arc/ARC2.php');

	/* configuration */ 
	$config = array(
		// no config needed for now
	);

	/* instantiation */
	$wiki = ARC2::getComponent('DataWikiPlugin', $config);

	if ($_SERVER['HTTPS'] == 'on')
		$foaf = 'https';
	else
		$foaf = 'http';

	$foaf = $foaf . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

	if ($q = @file_get_contents('php://input')) {
	
		$ret = $wiki->go($webid, $foaf);

		if (file_exists($ret))
		{
			$rdf = file_get_contents($ret);

			if (strcmp($rdf,'')!=0)
			{
				//rdfLog('sparul', $username, $webid, $q, $rdf);

				$sql = " update foaf set rdf = '$rdf' , rdf2 = '$rdf' where username like '$username'  ";

				$res = dbinsertquery($sql);
			}
		}
	}
}
else
{
	if (detect_ie() or detect_safari()) {
		header('Content-Type: application/xml');
	} else {
		header('Content-Type: application/rdf+xml');
	}

	header('MS-Author-Via: SPARQL');

	$xsl = 'foaf.xsl';
	if ($_SERVER['HTTPS'] == 'on') $xsl = 'foaf_secure.xsl';
	if ($auth['isAuthenticated'] == 1) $xsl = 'foaf_self.xsl';
	
	//if ($authentication_level == 'client_certificate_rsakey_matches_foaf_friend_rsakey') $xsl = 'foaf_friend.xsl';

	// overrides
	/*
	if ($_SERVER['HTTPS'] == 'on' && $_GET[username] == 'julietasfriend' ) $xsl = 'foaf_friend.xsl';
	if ($_SERVER['HTTPS'] == 'on' && $_GET[username] == 'romeoasfriend' ) $xsl = 'foaf_friend.xsl';
	if ($_SERVER['HTTPS'] == 'on' && $_GET[username] == 'julietasself' ) $xsl = 'foaf_self.xsl';
	if ($_SERVER['HTTPS'] == 'on' && $_GET[username] == 'romeoasself' ) $xsl = 'foaf_self.xsl';
	*/

	$res = $db->select(" select * from foaf where username like '$username' ");

	if ($row = mysql_fetch_assoc($res))
	{
		//logger('/home/foaf/www/datawiki/read.log', $webid, $username);

		xmlheader($xsl);
		
		$searchstring = '<?xml version="1.0"?>' . "\n";

		$out = $row['rdf'];
		$out = str_replace($searchstring, '', $out);
		print $out;
	}
	else if ( strstr($username, 'mbox/') )
	{
//		logger('/home/foaf/www/datawiki/insert.log', $webid, $username);

		$rdf = '<rdf:RDF 
		xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#" 
		xmlns:rdfs="http://www.w3.org/2000/01/rdf-schema#" 
		xmlns:foaf="http://xmlns.com/foaf/0.1/" 
		xmlns:rsa="http://www.w3.org/ns/auth/rsa#" 
		xmlns:cert="http://www.w3.org/ns/auth/cert#" 
		xmlns:admin="http://webns.net/mvcb/"> 
		
		<foaf:PersonalProfileDocument rdf:about=""> 
		<foaf:maker rdf:resource="#me"/> 
		<foaf:primaryTopic rdf:resource="#me"/> 
		</foaf:PersonalProfileDocument> 
		
		<foaf:Person rdf:ID="me"> 
		<foaf:mbox_sha1sum>' . substr($username, 5) . '</foaf:mbox_sha1sum> 
		</foaf:Person> 
		
		</rdf:RDF>';

		//rdfLog('insert', $username, $webid, NULL, $rdf);

		$db->insert_sql(" insert into foaf (id, username, rdf) VALUES (NULL, '$username', '$rdf')  ");
		
		xmlheader($xsl);

		print $rdf;
	}
	else 
	{
//		logger('/home/foaf/www/datawiki/insert.log', $webid, $username);

		$rdf = '<rdf:RDF 
		xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#" 
		xmlns:rdfs="http://www.w3.org/2000/01/rdf-schema#" 
		xmlns:foaf="http://xmlns.com/foaf/0.1/" 
		xmlns:rsa="http://www.w3.org/ns/auth/rsa#" 
		xmlns:cert="http://www.w3.org/ns/auth/cert#" 
		xmlns:admin="http://webns.net/mvcb/"> 
		
		<foaf:PersonalProfileDocument rdf:about=""> 
		<foaf:maker rdf:resource="#me"/> 
		<foaf:primaryTopic rdf:resource="#me"/> 
		</foaf:PersonalProfileDocument> 
		
		<foaf:Person rdf:ID="me"> 
		<foaf:nick>' . $username . '</foaf:nick> 
		<foaf:firstName>firstname</foaf:firstName> 
		<foaf:givenName>givenname</foaf:givenName> 
		<foaf:homepage rdf:resource="http://foaf.me/' . $username . '"/> 
		</foaf:Person> 
		
		</rdf:RDF>';

		//rdfLog('insert', $username, $webid, NULL, $rdf);

		$db->insert_sql(" insert into foaf (id, username, rdf) VALUES (NULL, '$username', '$rdf')  ");

		xmlheader($xsl);

		print $rdf;
	}
}

?>