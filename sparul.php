<?php //-----------------------------------------------------------------------------------------------------------------------------------
//
// Filename   : sparul.php                                                                                                  
// Version    : 0.1
// Date       : 18th May 2009
//
// Copyright 2008-2009 foaf.me
//
// This program is free software: you can redistribute it and/or modify
// it under the terms of the GNU Affero General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
// GNU Affero General Public License for more details.
//
// You should have received a copy of the GNU Affero General Public License
// along with this program. If not, see <http://www.gnu.org/licenses/>.
//
// "Everything should be made as simple as possible, but no simpler."
// -- Albert Einstein
//
//-----------------------------------------------------------------------------------------------------------------------------------

require_once("config.php");
require_once("arc/ARC2.php");



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

function getSubject($uri)
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


function postSparul($uri, $sparul)
{
	$c = curl_init();
	curl_setopt($c, CURLOPT_URL, $uri);
	curl_setopt($c, CURLOPT_POST, true);
	curl_setopt($c, CURLOPT_POSTFIELDS, $sparul);
//	curl_exec ($c);
//	curl_close ($c);
}


// init
$uri = $_REQUEST['uri'];
$s =  $_REQUEST['s'];
$p = $_REQUEST['p'];
$o = $_REQUEST['o'];
$delete = $_REQUEST['delete'];

// delete request
if (!empty($delete) && !empty($uri)) {
	// sparql for exisitng matches
	$ret = getObject($uri);
	for ($i=0; $i<count($ret); $i++) {
print "line: " . urlencode($ret[$i][0]) . " " . urlencode($delete) . "\n";
		if (urlencode($ret[$i][0]) == urlencode($delete)) {
print "match: " . urlencode($ret[$i][0]) . " " . urlencode($delete) . "\n";
			$t = $ret[$i];
			$sparul = "DELETE { <" . $t[0] . "> <$t[1]> <$t[2]>  . }";
			$return .= $sparul;
			postSparul($uri, $sparul);
			$sparul = "DELETE { <" . $t[0] . "> <$t[1]> \"$t[2]\"  . }";
			$return .= $sparul;
			postSparul($uri, $sparul);
		}
		if (urlencode($ret[$i][2]) == urlencode($delete)) {
			$t = $ret[$i];
			$sparul = "DELETE { <" . $t[0] . "> <$t[1]> <$t[2]>  . }";
			$return += $sparul;
			postSparul($uri, $sparul);
			$sparul = "DELETE { <" . $t[0] . "> <$t[1]> \"$t[2]\"  . }";
			$return .= $sparul;
		}
	}
print("ret");

print_r($ret);
print $uri;
	print $return;
	return;
}

$original = "\"" . $_REQUEST['original_html'] . "\"";
if ( $p == 'http://www.w3.org/2000/01/rdf-schema#seeAlso') {
	$update = "<" . $_REQUEST['update_value'] . ">";
} else {
	$update = "\"" . $_REQUEST['update_value'] . "\"";
}

$sparul = "DELETE { <" . $s . "> <". $p ."> $original . }";
postSparul($uri, $sparul);
$sparul = "INSERT { <" . $s . "> <" . $p  ."> $update . }";
postSparul($uri, $sparul);


// add request
if 	( $_REQUEST[original_html] === '(Click here to add text)' ) {
	$sparul = "INSERT { <" . $uri . "#me> <" . "http://xmlns.com/foaf/0.1/knows" ."> <$s> . }";
	postSparul($uri, $sparul);
}

//print $sparul;
print $_REQUEST['update_value'];


?>
