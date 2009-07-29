<?
//-----------------------------------------------------------------------------------------------------------------------------------
//
// Filename   : sparul.php                                                                                                  
// Version    : 0.1
// Date       : 18th May 2009
//
//-----------------------------------------------------------------------------------------------------------------------------------

include_once("config.php");
include_once("arc/ARC2.php");



function create_store($uri)
{
	$store = ARC2::getStore($GLOBALS['config']);
	if (!$store->isSetUp()) 
	{
		$store->setUp();
	}
	
	$store->reset();

	/* LOAD will call the Web reader, which will call the
	   format detector, which in turn triggers the inclusion of an
	   appropriate parser, etc. until the triples end up in the store. */
	$store->query('LOAD <'.$uri.'>');

	return $store;
}


function getObject($uri)
{
	$ret = array();
	
	if (isset($uri))
	{
		$store = create_store($uri);
		
		$q = "
			prefix rdfs: <http://www.w3.org/2000/01/rdf-schema#> 
			prefix rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#> 
			prefix foaf: <http://xmlns.com/foaf/0.1/> 
			prefix dcterms: <http://purl.org/dc/terms/> 
			prefix acl: <http://www.w3.org/ns/auth/acl#> 
			 
			select distinct ?s ?p ?o from <$uri> where {
				?s ?p ?o
			 }

		  ";
		if ($rows = $store->query($q, 'rows')) 
		{
			foreach ($rows as $row) 
			{
				$ret[] = array($row['s'],$row['p'],$row['o']);
			}
		}

	}
	
	return $ret;
}

$uri = $_REQUEST['uri'];

$ret = getObject($uri);

for ($i=0; $i<count($ret); $i++) {
	if ($ret[$i][2] == $_REQUEST['original_html']) {
		$t = $ret[$i];
	}
}


function postSparul($uri, $sparul)
{
	$c = curl_init();
	curl_setopt($c, CURLOPT_URL, $uri);
	curl_setopt($c, CURLOPT_POST, true);
	curl_setopt($c, CURLOPT_POSTFIELDS, $sparul);
	curl_exec ($c);
	curl_close ($c);
}


$sparul = "DELETE { <" . $t[0] . "> <$t[1]> \"$_REQUEST[original_html]\" . }";
postSparul($uri, $sparul);
$sparul = "INSERT { <" . $t[0] . "> <$t[1]> \"$_REQUEST[update_value]\" . }";
postSparul($uri, $sparul);

//print "$sparul";

print $_REQUEST['update_value'];


?>
