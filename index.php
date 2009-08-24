<?php
/** 
 * index.php - general application framework that powers foaf.me
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


// head.php contains the init and head information
// much of the plumbing goes on here, including links to libAuthentication 
// libACL libImport and the rdfquery javascript libraries, arc2 is also used 
// to parse a Web ID into an array and also to make files read / write using 
// SPARUL, the complexity is abstracted from the developer and you left with 
// a rich array of profile and relationship data out of the box
//
include('head.php'); 


// header.php is a short customisable header bar with login/logout button
//
include('header.php'); 


// content.php is general purpose content, in this case it links to a tabbed 
// FOAF creator new applications can be added to the framework simply by 
// replacing content.php
//
include('content.php'); 		


// footer.php is a general purpose footer
//
include('footer.php'); 


?>
