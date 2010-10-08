<?php

//-----------------------------------------------------------------------------------------------------------------------------------
//
// Filename   : FoafRequest.php
// Date       : 5th May 2010
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
require_once('lib/Authentication.php');

class FoafRequest
{
     private static $instance = NULL;
     public $isAuth = false;

     public $viewingWebid = NULL;
     public $viewingAgent = NULL;
     
     public $displayedWebid = NULL;
     public $displayedAgent = NULL;
     
     public function  __construct()
     {
         $auth = new Authentication($GLOBALS['config']);
         if ($auth->isAuthenticated()) {
             $this->isAuth = true;
             $this->viewingWebid = $auth->webid;
             $this->viewingAgent = $auth->getAgent();
             $this->displayedWebid = $this->viewingWebid;
             $this->displayedAgent = $this->viewingAgent;
         }
         if ($_REQUEST['webid']) {
             if ($_REQUEST['webid'] != $this->displayedWebid) {
                $pageAgent = new Authentication_AgentARC($GLOBALS['config'],
                                                            $_REQUEST['webid']);
                $this->displayedAgent = $pageAgent->getAgent();
                $this->displayedWebid = $this->displayedAgent['webid'];
             }
         }
     }

     public static function get()
     {
         if (NULL == self::$instance) {
             self::$instance = new FoafRequest();
         }
         return self::$instance;
     }
}

?>
