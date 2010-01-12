<?php

//-----------------------------------------------------------------------------------------------------------------------------------
//
// Filename   : tabfriends.php                                                                                                  
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

// This tab can act as a standalone page or be included from a containter
require_once('head.php');
require_once('header.php');
require_once('lib/libAuthentication.php');

// init
$friends = 2;


$auth = getAuth();
if ($auth['isAuthenticated'] == 1) {
    $webid = $auth['agent']['webid'];
    $webid_viewer = $auth['agent']['webid'];
}

if (!empty($_REQUEST['webid'])) {
    $webid = $_REQUEST['webid'];
    $webid_owner = $_REQUEST['webid'];
    if ( $webid_owner != $webid_viewer) {
        $auth = get_agent($_REQUEST['webid']);
    }
}

$canEdit = false;
if (!empty($webid)) {
    if (empty($webid_owner) || $webid_owner == $webid_viewer) {
        $canEdit = true;
    }
}

if ( !empty($webid_owner) || !empty($webid_viewer) ) {

    $friends = count($auth['agent']['knows']);

} 
?>


                <script type="text/javascript">
                    // TODO: make this more generic
                    function sparul() {
                        $("span[property]").editInPlace({ url: 'sparul.php' , params: 'uri=<?= $agent ?>' });
                        $("span[rel]").editInPlace({ url: 'sparul.php' , params: 'uri=<?= $agent ?>' });
                    }

<?php if ($canEdit) { ?>
                    $(function() {
                        sparul();
                    });
<?php } ?>

                    <!--
                    // function to add a friend
                    function addf(el) {

                        // empty list
                        // clone it
                        // replace numbers
                        // make sure fields are blank
                        if ($(el).prevAll().find("tr:last input").attr("type") === 'text' ) {

                            var about = $(el).prevAll().find(" tr:last").attr("about");
                            var lastFriend = (about != undefined) ? about.replace(/[^0-9]*/, "") : -1;

                            lastFriend++;
                            var clone = $("#friendstable tr:last").clone();

                            clone.attr({about : 'friend' + lastFriend });
                            clone.appendTo("#friendstable");

                            return;
                        }

                        // edit in place
                        var last = $("#friendstable tr:last");
                        if (last == null) {
                        } else {
                            var about = $("#friendstable tr:last").attr("about");
                            var lastFriend = about != undefined? about.replace(/.*friend/, "") : -1;
                            lastFriend++;
                            //alert (lastFriend)
                            $("#friendstable tr:last").after("<tr about='<?= $webidbase ?>#friend"+lastFriend+"' typeof='foaf:Person' ><td>Friend</td><td><span property='foaf:name'></span></td><td><a rel='refs:seeAlso'></a></td><td about='<?= $webid ?>' rel='foaf:knows' href='<?= $webidbase ?>#friend"+lastFriend+"' ><a>x</a></td></tr>");

                            sparul();
                        }


                    }
                    // -->
                </script>

                <h2>Friends</h2>
                <table id="friendstable" about="<?= $webid ?>">
                    <?php if ( $friends > 0 ){ ?>
                    <tr>
                        <td></td>
                        <td>Name</td><td>URL</td>
                    </tr>
                    <?php } else { ?>
                        No Friends visible in FOAF file
                    <?php } ?>

                    <?php for ($i=0; $i<$friends; $i++) { ?>


                        <?php if (empty($webid)) {  ?>

                    <tr typeof="foaf:Person" about="<?= $webidbase ?>friend<?= $i ?>" >
                        <td>Friend: </td>
                        <td><input size="12" property="foaf:name" onchange="makeTags()" type="text" /></td>
                        <td><input size="12" rel="rdfs:seeAlso" onchange="makeTags()" type="text" /></td>
                    </tr>

                        <?php } else { $v = $auth['agent']['knows'][$i]; $about =  $v['about']?$v['about']  : $webidbase . "friend" . $i ; ?>

                    <tr typeof="foaf:Person" id="friend<?= $i ?>" about="<?= $about ?>" >
                        <td><a href="?webid=<?= $v['webid'] ?>">View</a>: </td>
                        <td><span property="foaf:name"><?= $v['name'] ?></span></td>
                        <td><span href="<?= $v['webid'] ?>" rel="rdfs:seeAlso" ><?= $v['webid'] ?></span></td>
                        <td about="<?= $webid ?>" rel="foaf:knows" href="<?= $webidbase ?>#friend<?= $i ?>">
                            <?php if ($canEdit) { ?>
                                <a  id="delfriend<?= $i ?>" href="javascript:del('delfriend<?= $i ?>')" >x</a>
                            <?php } ?>
                        <?php } ?>
                        </td>

                    </tr>

                    <?php } ?>


                </table>
                <br/>

                <?php
                if ( $auth['isAuthenticated'] == 1 || empty($_REQUEST['webid']) ) {

                    print '<a id="addf" href="#" onclick="javascript:addf(this)">Add</a>';

                }

                ?>