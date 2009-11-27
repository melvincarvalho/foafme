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

// set up db connection
$db = new db_class();
$db->connect('localhost', $config['db_user'], $config['db_pwd'], $config['db_name']);

// get query string variables
$webid = urldecode($_REQUEST['webid']);
$auth = $_SESSION['auth'];

// get webid from db
$res = $db->select(" select * from foaf where CONCAT('http://foaf.me/', username, '#me') = '$webid' or CONCAT('http://foaf.me/', username) = '$webid' ");
while ($row && $row = mysql_fetch_assoc($res)) {
    if (!empty($row) && !empty($row['rdf'])) {
        $rdf = $row['rdf'];
        $searchstring = '<?xml version="1.0"?>' . "\n";

        $rdf = str_replace($searchstring, '', $rdf);

    }
    if (!empty ($_REQUEST['rdf'])) {
        $rdf = stripslashes($_REQUEST['rdf']);
        $res = $db->update_sql(" update foaf set rdf = '$rdf' where CONCAT('http://foaf.me/', username, '#me') = '$webid' or CONCAT('http://foaf.me/', username) = '$webid' ");
    }
}
?>

                <form id="rawdata" name="results" action="" method="POST" >
                    <h3>Enter FOAF as Raw Data (Beta)  </h3>
                    <textarea style='height:400px' name="rdf" cols="80" rows="80"><? echo $rdf; ?></textarea>

                    <br/><input id="webid" value="<?= $_REQUEST['webid'] ?>" type="hidden" name="webid" />


                    <?php if ($loggedIn) { echo '<input value="Update" type="submit" name="button"/>'; } ?>
                    <br/>
                </form>

                <div>webid : <a rel="webid" href="<?= $webid ?>"><?= $webid ?></a></div>




