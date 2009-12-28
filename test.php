<?

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
//
// If included from a container the header and footer are not repeated


// $headerLoaded is imported from the containter
// determines whether we were called standalone or included
require_once('head.php');
require_once('header.php');


$webid = 'http://foaf.me/git/gittest124';
print "<pre>$webid";
// get webid details
$auth = getAuth();
print_r($auth);

