<?

//-----------------------------------------------------------------------------------------------------------------------------------
//
// Filename   : tabaccounts.php                                                                                                  
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
$auth = getAuth();
if ($auth['isAuthenticated'] == 1) {
    $webid = $auth['agent']['webid'];
}

if (!empty($_REQUEST['webid'])) {
    $auth = get_agent($_REQUEST['webid']);
    $webid = $auth['agent']['webid'];
}


if ( $auth['isAuthenticated'] == 1 || !empty($_REQUEST['webid']) ) {


    $a1 = replace_with_rss(isset($auth['agent']['holdsAccount']) ? $auth['agent']['holdsAccount'] : NULL);
    $a2 = replace_with_rss(isset($auth['agent']['accountProfilePage']) ? $auth['agent']['accountProfilePage'] : NULL);

    if ( $a1 || $a2 ) {
        $a3 = array_merge(  $a1?$a1:array(), $a2?$a2:array() );
    }

    print "<h3>Online Accounts</h3>";

    if (!empty($a3)) {

        foreach ($a3 as $k => $v) {
            print "<a href='$v'>$v</a><br/>";
        }

    } else {
        print "No online accounts discovered";
    }
//print "<h3>Your Account Settings</h3>";
//print "<h3>Active Tabs</h3>";
//print "Me<br/>Friends<br/>Accounts<br/>Activity";

} else {
    ?>
                <table id="accountstable">
                    <tr><td></td><td>External Account URL</td></tr>
                    <tr typeof="foaf:OnlineAccount"><td>OpenID: </td><td><input size="40" rel="foaf:openid" id="account1" onchange="makeTags()" type="text" name="account1" /></td></tr>
                    <tr typeof="foaf:OnlineAccount"><td>Account: </td><td><input size="40" rel="foaf:holdsAccount" id="account2" onchange="makeTags()" type="text" name="account2" value="<?= isset($import['holdsAccount']) ? $import['holdsAccount'] : NULL ?>"/></td></tr>
                    <tr typeof="foaf:OnlineAccount"><td>Account: </td></td><td><input size="40" rel="foaf:holdsAccount" id="account3" onchange="makeTags()" type="text" name="accounts3" /></td></tr>

                    <a href="#" onclick="javascript:adda()">Add</a>
                </table>


<?
}
?>


