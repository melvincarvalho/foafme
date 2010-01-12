<?php

/** 
 * index.php - general application framework that powers foaf.me
 *
 * Copyright 2008-2009 foaf.me
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * "Everything should be made as simple as possible, but no simpler."
 * -- Albert Einstein
 *
 */

// includes
require_once('head.php');
require_once('header.php');


$auth = getAuth();

if ($auth['isAuthenticated'] == 1) {
     $webid = $auth['agent']['webid'];
     $name = !empty($auth['agent']['name'])?$auth['agent']['name']:$webid;
}


// set up db connection
$db = new db_class();
$db->connect('localhost', $config['db_user'], $config['db_pwd'], $config['db_name']);

$db2 = new db_class();
$db2->connect('localhost', $config['db_user'], $config['db_pwd'], $config['db_name']);

// get webid from db
$res = $db->select(" select * from foaf where CONCAT(URI, '#me') = '$webid' or URI = '$webid' ");

while ($res && ($row = $db->get_row($res))) {
    if (!empty($row) && !empty($row['rdf'])) {

        $searchstring1 = '<?xml version="1.0"?>' . "\n";
        $searchstring2 = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $searchstring3 = '<?xml version="1.0" encoding="UTF-8"?>';

        $rdf = $row['rdf'];
        $rdf = str_replace($searchstring1, '', $rdf);
        $rdf = str_replace($searchstring2, '', $rdf);
        $rdf = str_replace($searchstring3, '', $rdf);

        $rdf = str_replace($searchstring, '', $rdf);

    }
    if (!empty ($_REQUEST['rdf'])) {
        $rdf = stripslashes($_REQUEST['rdf']);
        $res2 = $db2->update_sql(" update foaf set rdf = '$rdf' where CONCAT(URI, '#me') = '$webid' or URI = '$webid' ");
    }
}
?>

                <form name="results" action="" method="post" >
                    <div>
                    <h3>Enter FOAF as Raw Data (Beta)  </h3>
                    <textarea style='height:400px' name="rdf" cols="80" rows="80"><? echo $rdf; ?></textarea>

                    <br/><input id="webid" value="<?= $_REQUEST['webid'] ?>" type="hidden" name="webid" />


                    <?php if ($loggedIn) { echo '<input value="Update" type="submit" name="button"/>'; } ?>
                    <br/>
                    </div>
                </form>

                <div>webid : <a rel="webid" href="<?= $webid ?>"><?= $webid ?></a></div>
                <div>validate + graph : <a rel="webid" href="<?= "http://www.w3.org/RDF/Validator/ARPServlet?URI=" . urlencode($webid) .  "&PARSE=Parse+URI%3A+&TRIPLES_AND_GRAPH=PRINT_BOTH&FORMAT=PNG_EMBED"  ?>">Go</a></div>



