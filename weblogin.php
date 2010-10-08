<?php

//-----------------------------------------------------------------------------------------------------------------------------------
//
// Copyright 2008-2010 foaf.me
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
require_once('config.php');
require_once('lib/Authentication.php');

function weblogin() {
     $auth = new Authentication($GLOBALS['config']);
     return $auth;
}

function weblogin_display() {
    print '<a id="account" href="https://foafssl.org/srv/idp?authreqissuer=' . "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] . '">Login via foafssl.org</a>';
}


$auth = weblogin();
weblogin_display();
print '<pre>';
print_r($auth);

?>
