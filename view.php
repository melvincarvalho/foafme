<?

//-----------------------------------------------------------------------------------------------------------------------------------
//
// Filename   : view.php                                                                                                  
// Date       : 15th October 2009
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
require_once("db.class.php");
require_once('lib/libAuthentication.php');

// set up db
$db = new db_class();
$db->connect('localhost', $config['db_user'], $config['db_pwd'], $config['db_name']);

// init
$username = $_GET['username'];
$URI = "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/' . $username;
$webid = $webid . '#me';



function detect_ie() {
    if (isset($_SERVER['HTTP_USER_AGENT']) &&
        (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false))
        return true;
    else
        return false;
}

function detect_safari() {
    if (isset($_SERVER['HTTP_USER_AGENT']) &&
        (strpos($_SERVER['HTTP_USER_AGENT'], 'Safari') !== false))
        return true;
    else
        return false;
}

function logger($actionlog, $webid, $nickname) {
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


/*
if ( $username == 'julietasself' ) $username = 'juliet';
if ( $username == 'julietasfriend' ) $username = 'juliet';
if ( $username == 'romeoasself' ) $username = 'romeo';
if ( $username == 'romeoasfriend' ) $username = 'romeo';
*/


// SPARUL
if (preg_match('/^post$/i', $_SERVER['REQUEST_METHOD'])) {
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

        if (file_exists($ret)) {
            $rdf = file_get_contents($ret);

            if (strcmp($rdf,'')!=0) {
            //rdfLog('sparul', $username, $webid, $q, $rdf);

                $sql = " update foaf set rdf = '$rdf' , rdf2 = '$rdf' where URI like '$URI'  ";

                $res = dbinsertquery($sql);
            }
        }
    }
}
// RDF
else {
    if (detect_ie() or detect_safari()) {
        header('Content-Type: application/xml');
    } else {
        header('Content-Type: application/rdf+xml');
    }

    header('MS-Author-Via: SPARQL');


    $res = $db->select(" select * from foaf where URI like '$URI' ");

    if ($row = mysql_fetch_assoc($res)) {
    //logger('/home/foaf/www/datawiki/read.log', $webid, $username);

        xmlheader($xsl);

        $searchstring = '<?xml version="1.0"?>' . "\n";

        $out = $row['rdf'];
        $out = str_replace($searchstring, '', $out);
        print $out;
    }
    // auto create mbox (tobyink)
    else if ( strstr($username, 'mbox/') ) {
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

            $db->insert_sql(" insert into foaf (id, username, rdf, URI) VALUES (NULL, '$username', '$rdf', '$URI')  ");

            xmlheader($xsl);

            print $rdf;
        }
        // auto create
        else {
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
		<foaf:homepage rdf:resource="http://'. $_SERVER['HTTP_HOST'] .'/' . $username . '"/> 
		</foaf:Person> 
		
		</rdf:RDF>';

            //rdfLog('insert', $username, $webid, NULL, $rdf);

            $db->insert_sql(" insert into foaf (id, username, rdf, URI) VALUES (NULL, '$username', '$rdf', '$URI')  ");

            xmlheader($xsl);

            print $rdf;
        }
}

?>