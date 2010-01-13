<?php
/** 
 * content.php - the social application, in this case FOAF wizard
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
require_once('config.php');
require_once('db.class.php');
require_once('lib/libAuthentication.php');
$auth = getAuth();

if ($auth['isAuthenticated'] == 1) {
     $webid = $auth['agent']['webid'];
     $name = !empty($auth['agent']['name'])?$auth['agent']['name']:$webid;
     if ($webid == $_REQUEST['webid'] || empty($_REQUEST['webid']) ) {
         $loggedIn = true;
     }
}

?>

            <!-- personal profile document -->
            <div style="display:none" typeof="foaf:PersonalProfileDocument" about="">
                <span rel="foaf:maker" href="#me"></span>
                <span rel="foaf:primaryTopic" href="#me"></span>
            </div>

            <!-- start tabs container -->
            <div id="container" typeof="foaf:Person" about="me">
                <ul>
                    <li style="list-style-image: none"><a href="#me"><span>Me</span></a></li>
                    <li style="list-style-image: none"><a href="#friends"><span>Friends</span></a></li>
                    <li style="list-style-image: none"><a href="#accounts"><span>Accounts</span></a></li>
                    <li style="list-style-image: none"><a href="#security"><span>Security</span></a></li>
                    <?php if ( $auth['isAuthenticated'] == 1 || !empty($_REQUEST['webid']) ) { ?>
                    <li style="list-style-image: none"><a href="#activity"><span>Activity</span></a></li>
                    <?php } else { ?>
                    <li style="list-style-image: none"><a href="#interests"><span>Interests</span></a></li>
                    <?php } ?>
                    <?php if ($loggedIn) { ?>
                    <li style="list-style-image: none"><a href="#rawdata"><span>Raw Data</span></a></li>
                    <?php } ?>
                </ul>

                <!-- start me tab -->
                <div id="me" class="inputArea">
                    <?php include('tabme.php'); ?>
                </div>
                <!-- end me tab -->


                <!-- start friends tab -->
                <div id="friends" class="inputArea">
                    <?php include ("tabfriends.php"); ?>
                </div>
                <!-- end friends tab -->

                <?php if ( $auth['isAuthenticated'] == 1 || !empty($_REQUEST['webid']) ) { ?>
                <!-- start activites tab -->
                <div id="activity">Loading...
                </div>
                <!-- end activities tab -->
                <?php } ?>

                <?php if ( $auth['isAuthenticated'] == 1 ) { ?>
                <!-- start raw data tab -->
                <div id="rawdata">
                    <?php include('tabdata.php'); ?>
                </div>
                <!-- end raw data tab -->
                <?php } ?>

                <!-- start accounts tab -->
                <div id="accounts" class="inputArea">
                    <?php include ("tabaccounts.php"); ?>
                </div>
                <!-- end accounts tab -->

                <!-- start interests tab -->
                <div id="interests">
                    <table id="intereststable">
                        <tr><td></td><td>Description</td></tr>
                        <tr typeof="foaf:OnlineAccount"><td>Interest: </td><td><input size="20" rel="foaf:interest" id="interest1" onchange="makeTags()" type="text" name="interest1" /></td></tr>
                        <tr typeof="foaf:OnlineAccount"><td>Interest: </td><td><input size="20" rel="foaf:interest" id="interest2" onchange="makeTags()" type="text" name="interest2" /></td></tr>
                    </table>
                    <a href="#" onclick="javascript:addi()">Add</a>
                </div>
                <!-- end interests tab -->

                <!-- start security tab -->
                <div id="security">
                    <?php include ("tabsecurity.php"); ?>
                </div>
                <!-- end security tab -->

            </div>
            <!-- end tabs container -->

            <script type="text/javascript"> $("#activity").load("tabactivity.php?webid=<?= $agent ?>");</script>

            <?php if ( $auth['isAuthenticated'] == 1 || !empty($_REQUEST['webid']) ) { ?>
            <?php } else { ?>
            <!-- start foaf file -->
            <form name="results" action="store.php" method="post" >
                <div id="form">
                    <p>Your FOAF file:</p>
                    <textarea id="rdf" name="rdf" cols="80" rows="20"></textarea>
                    <br/>
                        <?php echo $_SERVER['HTTP_HOST'] . ((dirname($_SERVER['PHP_SELF'])=='/')?'':dirname($_SERVER['PHP_SELF'])); ?>/<input id="username" value="" type="text" name="username" /> <button type="submit">Save!</button>

                    <br/><br/>
                    <p style='display:none' id="saving">Saving will give you the <a href="http://esw.w3.org/topic/WebID">Web ID</a> = <span style="color:blue" id="displayname"></span></p>

                </div>
            </form>
            <!-- end foaf file -->
            <?php } ?>
        </div>
        <div class="clear"></div>




