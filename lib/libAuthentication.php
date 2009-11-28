<?
//-----------------------------------------------------------------------------------------------------------------------------------
//
// Filename   : libAuthentication.php                                                                                                  
// Date       : 5th Mar 2009
//
// See Also   : https://foaf.me/testLibAuthentication.php
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
require_once("lib/libActivity.php");


/* Function to return the modulus and exponent of the supplied Client SSL Page */
function openssl_pkey_get_public_hex()
{
	if ($_SERVER['SSL_CLIENT_CERT'])
	{
		$pub_key = openssl_pkey_get_public($_SERVER['SSL_CLIENT_CERT']);
		$key_data = openssl_pkey_get_details($pub_key);
	
		$key_len   = strlen($key_data['key']);
		$begin_len = strlen('-----BEGIN PUBLIC KEY----- ');
		$end_len   = strlen(' -----END PUBLIC KEY----- ');

		$rsa_cert = substr($key_data['key'], $begin_len, $key_len - $begin_len - $end_len);

		$rsa_cert_struct = `echo "$rsa_cert" | openssl asn1parse -inform PEM -i`;

		$rsa_cert_fields = split("\n", $rsa_cert_struct);
		$rsakey_offset   = split(":",  $rsa_cert_fields[4]);

		$rsa_key = `echo "$rsa_cert" | openssl asn1parse -inform PEM -i -strparse $rsakey_offset[0]`;

		$rsa_keys = split("\n", $rsa_key);
		$modulus  = split(":", $rsa_keys[1]);
		$exponent = split(":", $rsa_keys[2]);

		// return($modulus[3]);
		return( array( 'modulus'=>$modulus[3], 'exponent'=>hexdec($exponent[3]) ) );
	}
}

/* Returns an array holding the subjectAltName of the supplied SSL Client Certificate */
function openssl_get_subjectAltName()
{
	if ($_SERVER['SSL_CLIENT_CERT'])
	{
		$cert = openssl_x509_parse($_SERVER['SSL_CLIENT_CERT']);
		if ($cert['extensions']['subjectAltName'])
		{
			$list          = split("[,]", $cert['extensions']['subjectAltName']);

			for ($i = 0, $i_max = count($list); $i < $i_max; $i++) 
			{
				if (strcasecmp($list[$i],"")!=0)
				{
					$value = split(":", $list[$i], 2);
					if ($subject_array)
						$subject_array = array_merge($subject_array, array(trim($value[0]) => trim($value[1])));
					else
						$subject_array = array(trim($value[0]) => trim($value[1]));
				}
			}

			return $subject_array;
		}
	}
}

/* Function to clean up teh supplied hex and convert numbers A-F to uppercase characters eg. a:f => AF */
function cleanhex($hex)
{
	$hex = eregi_replace("[^a-fA-F0-9]", "", $hex); 
	$hex = strtoupper($hex);

	return($hex);
}

/* Returns an array of the modulus and exponent in the supplied RDF */
function get_foaf_rsakey($store, $agenturi)
{
	    $modulus = NULL;
		$exponent = NULL;

		/* list names */
		$q = "
		  PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
		  PREFIX rsa: <http://www.w3.org/ns/auth/rsa#> 
		  PREFIX cert: <http://www.w3.org/ns/auth/cert#>
		  PREFIX foaf: <http://xmlns.com/foaf/0.1/> .
		  SELECT ?mod ?exp  WHERE {
			?sig cert:identity ?person .
			?sig a rsa:RSAPublicKey;
				rsa:modulus [ cert:hex ?mod ] ;
				rsa:public_exponent [ cert:decimal ?exp ] .
		  FILTER regex(?person, '".$agenturi."') 
		  }";
		if ($rows = $store->query($q, 'rows')) 
		{
			foreach ($rows as $row) 
			{
				$modulus =  cleanhex($row['mod']);
				$exponent = cleanhex($row['exp']);
			}
		}

		if ($modulus && $exponent)
			return ( array( 'modulus'=>$modulus, 'exponent'=>$exponent ) );
}

function webid($seeAlso, $about, $homepage, $mbox)
{
	if ($seeAlso)
		return $seeAlso;

	if ($about)
		return $about;

	if ($homepage)
		return $homepage;

	return $mbox;
}

function get_all_friends($store, $agenturi)
{
	$results = NULL;

	if ($store)
	{
		/* list names */
		$q = "PREFIX foaf: <http://xmlns.com/foaf/0.1/>  
			  PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>

			SELECT ?name ?seeAlso ?y ?mbox ?homepage ?x ?accountName WHERE {  
				  ?x foaf:knows ?y .  
				  OPTIONAL { ?y foaf:name ?name } .  
				  OPTIONAL { ?y rdfs:seeAlso ?seeAlso } . 
				  OPTIONAL { ?y foaf:mbox ?mbox } .  
				  OPTIONAL { ?y foaf:homepage ?homepage } .
				  OPTIONAL { ?y foaf:accountName ?accountName } . 
				  FILTER regex(?x, '".$agenturi."') 
			  }";

//		print $q."<br><br>";

		if ($rows = $store->query($q, 'rows')) 
		{
			foreach ($rows as $row) 
			{
//				print_r($row);
				if (strcmp($row['y'],$agenturi)!=0)
				{
					if (isset($row['name']))
						$res = array('name'=>$row['name']);
	
					if (isset($row['seeAlso']) && (strcmp($row['seeAlso type'],'uri')==0) ) 
					{	
						$seeAlso = $row['seeAlso'];
						$res = safe_array_merge($res, array('seeAlso'=>$seeAlso));
					}
					else
						$seeAlso = NULL;

					if (isset($row['mbox']))
						$res = safe_array_merge($res, array('mbox'=>$row['mbox']));

					if (isset($row['homepage']))
						$res = safe_array_merge($res, array('homepage'=>$row['homepage']));
/*
					if ($row['maker'])
						$res = safe_array_merge($res, array('maker'=>$row['maker']));

					if ($row['primaryTopic'])
						$res = safe_array_merge($res, array('primaryTopic'=>$row['primaryTopic']));
*/
					if (isset($row['y']) && (strcmp($row['y type'],'uri')==0) )
					{
						$y = $row['y'];
						$res = safe_array_merge($res, array('about'=>$y));
					}
					else
						$y = NULL;

					$res = safe_array_merge($res, array('webid'=>webid($seeAlso, $y, $row['homepage'], $row['mbox'])));

					$results[] = $res;
				}
			}
		}
	}

	return $results;
}

function get_all_nyms($store, $agenturi)
{
	$res= NULL;

	if ($store && $agenturi)
	{

		/* list names */
		
		$q = "PREFIX foaf: <http://xmlns.com/foaf/0.1/>  
			  PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>

			SELECT ?x ?name ?seeAlso ?mbox ?homepage ?nick ?img ?depiction ?y ?mbox_sha1sum ?accountProfilePage WHERE { 
				  ?x a foaf:Person .  
				  OPTIONAL { ?x foaf:name ?name }.  
				  OPTIONAL { ?x rdfs:seeAlso ?seeAlso } . 
				  OPTIONAL { ?x foaf:mbox ?mbox } .
				  OPTIONAL { ?x foaf:mbox_sha1sum ?mbox_sha1sum } .
				  OPTIONAL { ?x foaf:homepage ?homepage } .
				  OPTIONAL { ?x foaf:nick ?nick } .
				  OPTIONAL { ?x foaf:img ?img } .
				  OPTIONAL { ?x foaf:depiction ?depiction } .
				  OPTIONAL { ?x foaf:holdsAccount ?y } .
				  OPTIONAL { ?y foaf:accountProfilePage ?accountProfilePage } .
				  }";

		$q = "PREFIX foaf: <http://xmlns.com/foaf/0.1/>  
			  PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>

			  SELECT ?x ?name ?seeAlso ?mbox ?homepage ?nick ?img ?depiction ?y ?accountProfilePage ?holdsAccountHomepage WHERE {  
				  ?x a foaf:Person . 
				  ?x foaf:holdsAccount ?y .
				  OPTIONAL { ?x foaf:name ?name }.  
				  OPTIONAL { ?x rdfs:seeAlso ?seeAlso } . 
				  OPTIONAL { ?x foaf:mbox ?mbox } .
				  OPTIONAL { ?x foaf:mbox_sha1sum ?mbox_sha1sum } .
				  OPTIONAL { ?x foaf:homepage ?homepage } .
				  OPTIONAL { ?x foaf:nick ?nick } .
				  OPTIONAL { ?x foaf:img ?img } .
				  OPTIONAL { ?x foaf:depiction ?depiction } .
				  OPTIONAL { ?y foaf:accountProfilePage ?accountProfilePage } .
				  OPTIONAL { ?y foaf:homepage ?holdsAccountHomepage } .
				  }";

//		print $q."<br><br>";

		if ($rows = $store->query($q, 'rows')) 
		{
			foreach ($rows as $row) 
			{
				if (  (strcmp($row['x'],$agenturi)==0) /* && (strcmp($row['x'], $row['maker'])==0) */ )
				{	
//					print_r($row);

					if (isset($row['name']))
						$res = safe_array_merge($res, array('name'=>$row['name']));
	
					if (isset($row['seeAlso']) && (strcmp($row['seeAlso type'],'uri')==0))
						$res = safe_array_merge($res, array('seeAlso'=>array_unique(safe_array_merge($res['seeAlso'], array($row['seeAlso'])))));
			
					if (isset($row['mbox']))
						$res = safe_array_merge($res, array('mbox'=>array_unique(safe_array_merge($res['mbox'], array($row['mbox'])))));

					if (isset($row['mbox_sha1sum']))
						$res = safe_array_merge($res, array('mbox_sha1sum'=>array_unique(safe_array_merge($res['mbox_sha1sum'], array($row['mbox_sha1sum'])))));

					if (isset($row['homepage']))
						$res = safe_array_merge($res, array('homepage'=>array_unique(safe_array_merge($res['homepage'], array($row['homepage'])))));

					if (isset($row['nick']))
						$res = safe_array_merge($res, array('nick'=>array_unique(safe_array_merge($res['nick'], array($row['nick'])))));

					if (isset($row['accountProfilePage']))
						$res = safe_array_merge($res, array('accountProfilePage'=>array_unique(safe_array_merge($res['accountProfilePage'], array($row['accountProfilePage'])))));

					if (isset($row['y']) && (strcmp($row['y type'],'uri')==0))
					{
						$acct = $row['y'];
//						if (strstr($acct, 'http://identi.ca/'))
//							$acct = $acct . '/rss';
						$res = safe_array_merge($res, array('holdsAccount'=>array_unique(safe_array_merge($res['holdsAccount'], array($acct)))));
					}

					if (isset($row['holdsAccountHomepage']))
					{
						$acct = $row['holdsAccountHomepage'];
//						if (strstr($acct, 'http://identi.ca/'))
//							$acct = $acct . '/rss';
						$res = safe_array_merge($res, array('holdsAccount'=>array_unique(safe_array_merge($res['holdsAccount'], array($acct)))));
					}

					if (isset($row['img']))
						$res = safe_array_merge($res, array('img'=>$row['img']));

					if (isset($row['depiction']))
						$res = safe_array_merge($res, array('depiction'=>$row['depiction']));
				}
			}
		}
	}
/*
	if ($res['accountProfilePage'])
	{
		$res['accountProfilePage'] = array_unique($res['accountProfilePage'], SORT_STRING);
	}

	if ($res['holdsAccount'])
	{
		$res['holdsAccount'] = array_unique($res['holdsAccount'], SORT_STRING);
	}
*/
	return $res;
}

function get_all_nyms_sec($store, $agenturi)
{
	$res =  NULL;
    $res['nick'] = NULL;
    $res['homepage'] = NULL;

	if ($store && $agenturi)
	{
		/* list names */
		
		$q = "PREFIX foaf: <http://xmlns.com/foaf/0.1/>  
			  PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>

			SELECT ?x ?name ?seeAlso ?mbox ?homepage ?nick ?img ?depiction ?y ?mbox_sha1sum ?accountProfilePage WHERE { 
				  ?x a foaf:Person .  
				  OPTIONAL { ?x foaf:name ?name }.  
				  OPTIONAL { ?x rdfs:seeAlso ?seeAlso } . 
				  OPTIONAL { ?x foaf:mbox ?mbox } .
				  OPTIONAL { ?x foaf:mbox_sha1sum ?mbox_sha1sum } .
				  OPTIONAL { ?x foaf:homepage ?homepage } .
				  OPTIONAL { ?x foaf:nick ?nick } .
				  OPTIONAL { ?x foaf:img ?img } .
				  OPTIONAL { ?x foaf:depiction ?depiction } .
				  OPTIONAL { ?x foaf:holdsAccount ?y } .
				  OPTIONAL { ?y foaf:accountProfilePage ?accountProfilePage } .
				  }";
/*
		$q = "PREFIX foaf: <http://xmlns.com/foaf/0.1/>  
			  PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>

			  SELECT ?x ?name ?seeAlso ?mbox ?homepage ?nick ?img ?depiction ?y ?accountProfilePage ?holdsAccountHomepage WHERE {  
				  ?x a foaf:Person . 
				  ?x foaf:holdsAccount ?y .
				  OPTIONAL { ?x foaf:name ?name }.  
				  OPTIONAL { ?x rdfs:seeAlso ?seeAlso } . 
				  OPTIONAL { ?x foaf:mbox ?mbox } .
				  OPTIONAL { ?x foaf:mbox_sha1sum ?mbox_sha1sum } .
				  OPTIONAL { ?x foaf:homepage ?homepage } .
				  OPTIONAL { ?x foaf:nick ?nick } .
				  OPTIONAL { ?x foaf:img ?img } .
				  OPTIONAL { ?x foaf:depiction ?depiction } .
				  OPTIONAL { ?y foaf:accountProfilePage ?accountProfilePage } .
				  OPTIONAL { ?y foaf:homepage ?holdsAccountHomepage } .
				  }";
*/
//		print $q."<br><br>";

		if ($rows = $store->query($q, 'rows')) 
		{
			foreach ($rows as $row) 
			{
				if (  (strcmp($row['x'],$agenturi)==0) /* && (strcmp($row['x'], $row['maker'])==0) */ )
				{	
//					print_r($row);

					if (isset($row['name']))
						$res = safe_array_merge($res, array('name'=>$row['name']));
	
					if ( isset($row['seeAlso'])  && (strcmp($row['seeAlso type'],'uri')==0) ) 
						$res = safe_array_merge($res, array('seeAlso'=>array_unique(safe_array_merge($res['seeAlso'], array($row['seeAlso'])))));
			
					if (isset($row['mbox']))
						$res = safe_array_merge($res, array('mbox'=>array_unique(safe_array_merge($res['mbox'], array($row['mbox'])))));

					if (isset($row['mbox_sha1sum']))
						$res = safe_array_merge($res, array('mbox_sha1sum'=>array_unique(safe_array_merge($res['mbox_sha1sum'], array($row['mbox_sha1sum'])))));

					if (isset($row['homepage']))
						$res = safe_array_merge($res, array('homepage'=>array_unique(safe_array_merge($res['homepage'], array($row['homepage'])))));

					if (isset($row['nick']))
						$res = safe_array_merge($res, array('nick'=>array_unique(safe_array_merge($res['nick'], array($row['nick'])))));

					if (isset($row['accountProfilePage']))
						$res = safe_array_merge($res, array('accountProfilePage'=>array_unique(safe_array_merge($res['accountProfilePage'], array($row['accountProfilePage'])))));

					if ( isset($row['y']) && (strcmp($row['y type'],'uri')==0) ) 
						$res = safe_array_merge($res, array('holdsAccount'=>array_unique(safe_array_merge($res['holdsAccount'], array($row['y'])))));

					if (isset($row['holdsAccountHomepage'])) 
						$res = safe_array_merge($res, array('holdsAccount'=>array_unique(safe_array_merge($res['holdsAccount'], array($row['holdsAccountHomepage'])))));

					if (isset($row['img']))
						$res = safe_array_merge($res, array('img'=>$row['img']));

					if (isset($row['depiction']))
						$res = safe_array_merge($res, array('depiction'=>$row['depiction']));
				}
			}
		}
	}
/*
	if ($res['accountProfilePage'])
	{
		$res['accountProfilePage'] = array_unique($res['accountProfilePage'], SORT_STRING);
	}

	if ($res['holdsAccount'])
	{
		$res['holdsAccount'] = array_unique($res['holdsAccount'], SORT_STRING);
	}
*/
	return $res;
}

/* Function to compare two supplied RSA keys */
function equal_rsa_keys($key1, $key2)
{
	if ( $key1 && $key2 && ($key1['modulus'] == $key2['modulus']) && ($key1['exponent'] == $key2['exponent']) )
		return TRUE;

	return FALSE;
}

function safe_array_merge($a, $b)
{
	if ($b)
	{
		if ($a)
			$a = array_merge($a, $b);
		else
			$a = $b;
	}

	return $a;
}

function get_primary_profile($store)
{
	if ($store)
	{
		/* list names */
		$q = 'PREFIX foaf: <http://xmlns.com/foaf/0.1/>  

			SELECT ?x ?primaryTopic WHERE {  
				  ?x a foaf:PersonalProfileDocument .  
				  OPTIONAL { ?x foaf:primaryTopic ?primaryTopic }.  
			  }';

		if ($rows = $store->query($q, 'rows')) 
		{
			foreach ($rows as $row) 
			{
				return $row['primaryTopic'];
			}
		}
	}
}

function get_online_account($store, $agenturi)
{
	if ($store && $agenturi)
	{
		/* list names */
		$q = 'PREFIX foaf: <http://xmlns.com/foaf/0.1/>  
			  PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>

			SELECT ?x ?y WHERE {  
				  ?x a foaf:OnlineAccount .  
				  ?y foaf:holdsAccount ?x  
			  }';

		if ($rows = $store->query($q, 'rows')) 
		{
			foreach ($rows as $row) 
			{
				return $row[y];
			}
		}
	}
}

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

function get_agent($agenturi)
{
	if ($agenturi)
	{
		$agent = NULL;

		$store = create_store($agenturi);

		if ($agentrsakey = get_foaf_rsakey($store, $agenturi))
			$agent = safe_array_merge($agent, array('RSAKey'=>$agentrsakey));

		if ($nyms = get_all_nyms($store, $agenturi))
			$agent = safe_array_merge($agent, $nyms);
		else
		{
			// Where the san points to a rdf file (not the webid) try to find the primary topic of the rdf file
			if ( $primaryuri = get_primary_profile($store) )
			{

				if  ( ($nyms = get_all_nyms($store, $primaryuri)) || ($nyms = get_all_nyms_sec($store, $primaryuri)) )
				{
					$agent = safe_array_merge($agent, $nyms);
					$agenturi = $primaryuri;
				}
				else
				{
//					print "primaryTopic $primaryuri is not helping<br><br>";
				}
			}
			else
			{
				if ($holdaccount = get_online_account($store, $agenturi))
				{
						if ($nyms = get_agent($holdaccount))
						{
							return($nyms);
						}
						else
						{
//							print "holdAccount is not helping<br><br>";
						}
				}
				else
				{
//							print "holdAccount is missing<br><br>";
				}
			}
		}

		if ($friends = get_all_friends($store, $agenturi))
			$agent = safe_array_merge($agent, array('knows'=>$friends));

		if ($agent)
		{
			$agent = safe_array_merge(array("webid"=>$agenturi), $agent);

			$agent = array('agent'=>$agent);
		}

		return $agent;
	}
}

function setAuthenticatedWebID($webid)
{
	if (!is_null($webid))
	{
		$authSession = session_name();

		if (isset($authSession))
		{
			if (session_start())
			{
				$_SESSION['libAuthentication_isAuthenticated'] = 1;
				$_SESSION['libAuthentication_webid'] = $webid;
				$_SESSION['libAuthentication_agent'] = $NULL;
			}
		}
	}
}

function unsetAuthenticatedWebID()
{
	$authSession = session_name();

	if (isset($authSession))
	{
		if (session_start())
		{
			$_SESSION['libAuthentication_isAuthenticated'] = 0;
			$_SESSION['libAuthentication_webid'] = NULL;
			$_SESSION['libAuthentication_agent'] = NULL;
		}
	}
}

function getAuth()
{
	$isAuthenticated = 0;
	$foafuri = NULL;
	$agent = NULL;

	$authSession = session_name();

	if (isset($authSession))
	{
		if (session_start())
		{
			if ( (isset($_SESSION['libAuthentication_isAuthenticated'])) && ($_SESSION['libAuthentication_isAuthenticated']==1) )
			{
				if (isset($_SESSION['libAuthentication_webid']))
				{
					$isAuthenticated = 1;
					$foafuri = isset($_SESSION['libAuthentication_webid'])?$_SESSION['libAuthentication_webid']:NULL;
					$agent = isset($_SESSION['libAuthentication_agent'])?$_SESSION['libAuthentication_agent']:NULL;
					print "previously logged in<br/>";
				}
			}
		}
	}

	if ( ($isAuthenticated == 0) || (is_null($foafuri)) )
	{
		if (!$_SERVER['HTTPS'])
			return ( array( 'isAuthenticated'=>0 , 'authDiagnostic'=>'No client certificate supplied on an unsecure connection') );

		if (!$_SERVER['SSL_CLIENT_CERT'])
			return ( array( 'isAuthenticated'=>0 , 'authDiagnostic'=>'No client certificate supplied') );

		$certrsakey = openssl_pkey_get_public_hex();

		if (!$certrsakey)
			return ( array( 'isAuthenticated'=>0 , 'authDiagnostic'=>'No RSA Key in the supplied client certificate') );

		$result = array('certRSAKey'=>$certrsakey);

		$san     = openssl_get_subjectAltName();
		$foafuri = $san['URI'];

		//	$foafuri = 'http://www.w3.org/People/Berners-Lee/card#i';
		//  $foafuri = 'http://bblfish.net/people/henry/card#me';
		//	$foafuri = 'http://danbri.org/foaf.rdf#danbri';
		//	$foafuri = 'http://foafbuilder.qdos.com/people/melvster.com/foaf.rdf';
		//	$foafuri = 'http://test.foaf-ssl.org/certs/1235593768725.rdf#accnt';
		//	$foafuri = 'http://myopenlink.net/dataspace/person/kidehen#this';

		$result = safe_array_merge($result, array('subjectAltName'=>$foafuri));

		//	$foafrsakey = get_foaf_rsakey($foafuri);
		//	$result = array_merge($result, array('subjectAltNameRSAKey'=>$foafrsakey));
	}

	if (is_null($agent))
	{
		$agent = get_agent($foafuri);
	}

	if ($agent)
	{
		$result = safe_array_merge($result, $agent);

		if ($agent['agent']['RSAKey'])
		{
			if ( ($isAuthenticated == 1) || (equal_rsa_keys($certrsakey, $agent['agent']['RSAKey'])) )
			{
				$_SESSION['libAuthentication_isAuthenticated'] = 1;
				$_SESSION['libAuthentication_webid'] = $foafuri;
				$_SESSION['libAuthentication_agent'] = $agent;

				$result = safe_array_merge($result, array( 'isAuthenticated'=>1,  'authDiagnostic'=>'Client Certificate RSAkey matches SAN RSAkey'));
			}
			else
				$result = safe_array_merge($result, array( 'isAuthenticated'=>0,  'authDiagnostic'=>'Client Certificate RSAkey does not match SAN RSAkey'));
		}
		else
			$result = safe_array_merge($result, array( 'isAuthenticated'=>0,  'authDiagnostic'=>'No RSAKey found at supplied agent'));
	}
	else
		$result = safe_array_merge($result, array( 'isAuthenticated'=>0,  'authDiagnostic'=>'No agent found at supplied SAN'));

	return $result;
}

?>
