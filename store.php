<?php 

//-----------------------------------------------------------------------------------------------------------------------------------
//
// Filename   : store.php                                                                                                  
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

// functions
function detect_ie() {
    if (isset($_SERVER['HTTP_USER_AGENT']) &&
        (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false))
        return true;
    else
        return false;
}


// set up db connection
$db = new db_class();
$db->connect('localhost', $config['db_user'], $config['db_pwd'], $config['db_name']);

// init
$username = $_POST['username'];
$rdf = $_POST['rdf'];
$URI = "http://" . $_SERVER['HTTP_HOST'] . ((dirname($_SERVER['PHP_SELF'])=='/')?'':dirname($_SERVER['PHP_SELF'])) . '/' . $username;
$webid = $URI . '#me';

$link = "http://" . $_SERVER['HTTP_HOST'] . str_replace('store.php', 'index.php', $_SERVER['PHP_SELF'])
    . "?webid=$URI";



// check if username exists and create new
$res = $db->select(" select * from foaf where URI like '$URI' ");
$numrows = $db->row_count;
if ($numrows == 0) {
    $db->insert_sql(" insert into foaf (id, username, rdf, URI) VALUES (NULL, '$_POST[username]', '$rdf', '$URI')  ");
} else {
    //$db->update_sql(" update foaf set rdf = '$_POST[rdf]' , rdf2 = '$rdf' where username like '$_POST[uri]'  ");
}

// New user
if ($numrows == 0) { ?>


    <div class="success">Congratulations, your new FOAF profile was created successfully.
        You can now use the Web ID <a href='<?= $link ?>'><?= $webid ?></a> to refer to yourself. </div>
    <br/>

    <?
    print 'This identity is not yet protected.<form name="input" action="'
    . $config['certficate_uri'] .'" method="get">';
    ?>
    <br/>
    <input type="hidden" size="25" id="foaf" name="foaf" value="<?= $URI ?>">
    Key Strength: <keygen name="pubkey" challenge="randomchars"></td><td></td><td></td>
    <input type="hidden" id="commonName" name="commonName" value="FOAF ME Cert <?= $URI ?>"><button id="generate" type="submit">Claim Account with SSL Certificate!</button>
    <input type="hidden" id="uri" name="uri" value="<?= $URI ?>">
    </form>

    <a href="https://foaf.me/simpleLogin.php">Test</a>


<? } else { ?>

Sorry, username already exists, please press back and try another username.

<? }

require_once("footer.php")

?>
