<?php

//-----------------------------------------------------------------------------------------------------------------------------------
//
// Filename   : webdav_server.php                                                                                                  
// Date       : 14th January 2010
// Version    : 0.1
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
require_once('db.class.php');
require_once('lib/Authentication.php');

chdir (dirname(__FILE__) . "/inc");

require_once "HTTP/WebDAV/Server/Filesystem.php";
$server = new HTTP_WebDAV_Server_Filesystem();

$file = dirname(__FILE__) . "/webdav_data";

$server->ServeRequest($file, $config['db_name'], $config['db_user'], $config['db_pwd']);

?>