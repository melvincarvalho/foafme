<?php
/** 
 * header.php - short header bar and login
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

$auth = getAuth();
if ($auth['isAuthenticated'] == 1) {
     $webid = $auth['agent']['webid'];
     $name = !empty($auth['agent']['name'])?$auth['agent']['name']:$webid;
} else {
    $webid= NULL;
}


?>

<body bgcolor="#CCE9FA">
    <div id="wrap">
        <div id="header">
            <a href="index.php">Home</a> | <a href="http://foaf.me/index.php?webid=http://www.w3.org/People/Berners-Lee/card">Explore FOAFs</a> | <a href="about.php">About</a> | <a href="documentation.php">Documentation</a> | <a href="downloads.php">Downloads</a> | <a href="http://groups.google.com/group/foafme?lnk=srg&amp;hl=en&amp;ie=UTF-8&amp;oe=utf-8">Mailing List</a> 


            <?php
            //if (!empty($_SESSION['auth']) && $_SESSION['auth']['subjectAltName']) {

            // If logged in
            if (!empty($webid) ) {
                ?>
            <span id="user">
                <a id="logout" href="http://foaf.me/clearSession.php?return_to=<?php echo "http://$_SERVER[HTTP_HOST]$_SERVER[PHP_SELF]" ?>">
                <!-- Logout <strong><?= $_SESSION['auth']['subjectAltName'] ?> </strong> -->
                    Logout <strong><?= $webid ?></strong>
                </a>
                <br/>
            </span>
            <? } else { ?>
            <span id="user">
                <a id="account" href="https://foafssl.org/srv/idp?authreqissuer=<?php echo "http://$_SERVER[HTTP_HOST]$_SERVER[PHP_SELF]" ?>">
                    Login to your <strong>account</strong>
                </a>
                <br />
            </span>
            <? } ?>

        </div>


        <div id="content">

            <h1>
                <img alt="foaf" src="images/foaf.gif" />
                <strong>FOAF</strong>
            </h1>

            <h2></h2>




