<?
//-----------------------------------------------------------------------------------------------------------------------------------
//
// Filename   : libACL.php                                                                                                  
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


function getACL($uri)
{
	$acl = array();
	
	if (isset($uri))
	{
		$store = create_store($uri);
		
		$q = "
			prefix rdfs: <http://www.w3.org/2000/01/rdf-schema#> 
			prefix rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#> 
			prefix foaf: <http://xmlns.com/foaf/0.1/> 
			prefix dcterms: <http://purl.org/dc/terms/> 
			prefix acl: <http://www.w3.org/ns/auth/acl#> 
			 
			select distinct ?resource ?person ?mode from <$uri> where {
			 ?aut acl:accessTo ?resource ;
			      acl:mode ?accessMode .
			 ?accessMode a ?mode .      
			 OPTIONAL {
			   ?aut acl:agentClass ?group .
			   ?group foaf:member ?person 
			 }
			 OPTIONAL {
			   ?aut acl:agent ?person 
			 }
			}		
		  ";
		if ($rows = $store->query($q, 'rows')) 
		{
			foreach ($rows as $row) 
			{
				$acl[] = array($row['resource'], $row['person'], $row['mode']);
			}
		}

	}
	
	return $acl;
}

?>
