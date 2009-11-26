<?
//-----------------------------------------------------------------------------------------------------------------------------------
//
// Filename   : libACL.php                                                                                                  
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
