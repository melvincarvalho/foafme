<?php
//-----------------------------------------------------------------------------------------------------------------------------------
//
// Filename   : libAuthenticationConformanceTest.php
// Date       : 9th February 2009
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

       chdir (dirname(__FILE__) . "/../..");

       require 'lib/libAuthentication.php';
       header("Content-Type: text/plain; charset=utf-8");
       $auth = getAuth();
       if ($auth['isAuthenticated'])
               print $auth['agent']['webid'];
       else
               print '-';
       # PHP end tag intentionally omitted.
