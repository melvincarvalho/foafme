<?php

//-----------------------------------------------------------------------------------------------------------------------------------
//
// Filename   : tabme.php                                                                                                  
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

require_once('head.php');
require_once('header.php');
require_once('lib/libAuthentication.php');

$auth = getAuth();
if ($auth['isAuthenticated'] == 1) {
    $webid = $auth['agent']['webid'];
}

if (!empty($_REQUEST['webid'])) {
    $auth = get_agent($_REQUEST['webid']);
    $webid = $auth['agent']['webid'];
}


if ( $auth['isAuthenticated'] == 1 || !empty($_REQUEST['webid']) ) {
    if (!empty($webid)) {
        print "<script type='text/javascript' src='http://foaf-visualizer.org/embed/widget/?uri=$webid' ></script>";
        ?>
            <script type='text/javascript'>
            $("a").each( function() {
               this.href = this.href.replace(/foaf-visualizer.org..uri=/g,"foaf.me/index.php?webid=");
            });
            </script>
        <?php
        print "<h2>Other Visualisations</h2>";
        print "<a target='_blank' href='http://www.foafer.org/?file=" . $webid . "'>Foafer</a><br/>";
        print "<a target='_blank' href='http://www5.wiwiss.fu-berlin.de/marbles?uri=" . $webid . "'>Marbles</a><br/>";
        print "<a target='_blank' href='http://sig.ma/search?q=" . $webid . "'>Sig.ma</a><br/>";
        print "<a target='_blank' href='http://linkeddata.uriburner.com/ode/?uri=" . $webid . "'>OpenLink Data Explorer</a><br/>";
        print "<a target='_blank' href='http://xml.mfd-consult.dk/foaf/explorer/?foaf=" . $webid . "'>Foaf Explorer</a><br/>";
        print "<a target='_blank' href='http://dataviewer.zitgist.com/?uri=" . $webid . "'>Zitgist</a><br/>";
        print "<a target='_blank' href='http://foafmap.net/?foaf=" . $webid . "'>Foaf MAP</a><br/>";
        ?>

<?php
    } else {
        print "No profile discovered yet";
    }
  
} else { ?>
                <table>
                    <tr><td><b>Create Profile!</b> </td><td></tr>
                    <tr><td>Username/Nick:</td><td><input id="nick" onChange="makeTags()" property="foaf:nick" type="text" name="nick" value="<?= isset($import['nick']) ? $import['nick'] : NULL ?>" /><span class="required">*</span></tr>
                    <tr><td>First Name</td><td><input property="foaf:firstName" id="firstname" onChange="makeTags()" type="text" name="firstName"></td></tr>
                    <tr><td>Last Name</td><td><input property="foaf:givenname" id="surname" onChange="makeTags()" type="text" name="surname"></td></tr>
                    <tr><td>Picture</td><td><input rel="foaf:depiction" id="depiction" onChange="makeTags()" type="text" name="depiction"></td></tr>
                    <tr><td>Homepage</td><td><input rel="foaf:homepage" id="homepage" onChange="makeTags()" type="text" name="homepage"/></tr>
                </table>
                <br/>
                <div class="blue">* required field (all other fields are optional)</div>
<?php } ?>
