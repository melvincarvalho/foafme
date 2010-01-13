<?php

//-----------------------------------------------------------------------------------------------------------------------------------
//
// Filename   : tabsecurity.php                                                                                                  
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
    $key = $auth['agent']['RSAKey'];

    print "<h3>Security</h3>";

    if (!empty($key)) {

    // TODO: rdfa to match the table below
        print "Public Key: $key[modulus]<br/>";
        print "Exponent: $key[exponent]<br/>";

    } else {
        print 'This identity is not yet protected.<form name="input" action="' . $config['certficate_uri'] .'" method="get">';
        ?>
                <div>
                <input type="hidden" size="25" id="foaf" name="foaf" value="<?= $_REQUEST['webid'] ?>">
                        Key Strength: <keygen name="pubkey" challenge="randomchars"></td><td></td><td></td>
                <input type="hidden" id="commonName" name="commonName" value="FOAF ME Cert <?= $_REQUEST['webid'] ?>"><button id="generate" type="submit">Claim Account with SSL Certificate!</button>
                <input type="hidden" id="uri" name="uri" value="<?= $_REQUEST['webid'] ?>">
                </div>
                </form>
                <a href="https://foaf.me/simpleLogin.php">Test</a>
    <?
    }


    print "<h3>Coming soon</h3>";
    print "Edit profile (please use tabulator at the moment)<br/> ";
    print "Privacy control<br/>";

} else {
    ?>

                <table typeof="cert:identity">
                    <tr>
                        <td><b>Secure Account!</b></td>
                        <td>(RSA)</td>
                    </tr>
                    <tr>
                        <td>Public Key:</td>
                        <td><input class="cert:hex" property="rsa:modulus" id="publicKey"
                                   onchange="makeTags()" type="text" name="publicKey" />
                        </td>
                    </tr>
                    <tr>
                        <td>Exponent:</td>
                        <td><input class="cert:decimal" property="rsa:public_exponent"
                                   id="exponent" onchange="makeTags()" type="text" name="exponent" />
                                (Default = 65537)
                        </td>
                    </tr>
                </table>



<?
}
?>


