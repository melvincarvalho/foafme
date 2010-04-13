<?php

//-----------------------------------------------------------------------------------------------------------------------------------
//
// Filename   : Authentication.php
// Date       : 21st Mar 2010
//
// See Also   : https://foaf.me/testLibAuthentication.php
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

require_once(dirname(__FILE__)."/Authentication_FoafSSLDelegate.php");
require_once(dirname(__FILE__)."/Authentication_FoafSSLARC.php");
require_once(dirname(__FILE__)."/Authentication_AgentARC.php");
/**
 * @author Akbar Hossain
 *
 * Top-level authentication class that integrates multiple authentication
 * procedures. (session, Foaf+SSL, delegated Foaf+SSL)
 */
class Authentication {

    /**
     * After succesful authentication contains the webid
     * (e.g. http://foaf.me/tl73#me)
     * @var string
     */
    public  $webid             = NULL;
    public  $isAuthenticated   = 0;
    /**
     * Always contains the diagnostic message for the last authentication attempt
     * @var string
     */
    public  $authnDiagnostic   = NULL;
    public  $agent = NULL;

    private $session = NULL;

    const STATUS_AUTH_VIA_SESSION = "Authenticated via a session";

    public function __construct($ARCConfig, $sig = NULL) {

        $this->session = new Authentication_Session();
        if ($this->session->isAuthenticated) {
            $this->webid           = $this->session->webid;
            $this->isAuthenticated = $this->session->isAuthenticated;
            $this->agent           = $this->session->agent;
            $this->authnDiagnostic = self::STATUS_AUTH_VIA_SESSION;
/*
            print "<pre>";
            print_r($session);
            print "</pre>";
*/
            return;
         }

         $sig = isset($sig)?$sig:$_GET["sig"];

         if ( /*($this->isAuthenticated == 0) &&*/ (isset($sig)) ) {
             $authDelegate = new Authentication_FoafSSLDelegate(FALSE);

             $this->webid           = $authDelegate->webid;
             $this->isAuthenticated = $authDelegate->isAuthenticated;
             $this->authnDiagnostic = $authDelegate->authnDiagnostic;
/*
             print "<pre>";
             print_r($authDelegate);
             print "</pre>";
*/
         }

         $authSSL = NULL;
         if ( ($this->isAuthenticated == 0) && true ) {
             $authSSL = new Authentication_FoafSSLARC($ARCConfig, NULL, FALSE);

             $this->webid           = $authSSL->webid;
             $this->isAuthenticated = $authSSL->isAuthenticated;
             $this->authnDiagnostic = $authSSL->authnDiagnostic;
/*
             print "<pre>";
             print_r($authSSL);
             print "</pre>";
*/
         }

         if ($this->isAuthenticated) {
            if (isset($authSSL))
                $ARCStore = $authSSL->ARCStore;
            else
                $ARCStore = NULL;
            
            $agent = new Authentication_AgentARC($ARCConfig, $this->webid, $ARCStore);
/*
            print "<pre>";
            print_r($agent);
            print "</pre>";
*/
            $this->agent = $agent->agent;
         }
         else {
            $this->webid = NULL;
            $this->agent = NULL;
         }

         if ($this->isAuthenticated)
            $this->session->setAuthenticatedWebid($this->webid, $this->agent);
         else
            $this->session->unsetAuthenticatedWebid();
    }
    /**
     * Is the current user authenticated?
     * @return bool
     */
    public function isAuthenticated() {
        return $this->isAuthenticated;
    }
    /**
     * Leave the authenticated session
     */
    public function logout() {
        $this->isAuthenticated = 0;
        $this->session->unsetAuthenticatedWebid();
    }
    /**
     * Returns an the authenticated user's parsed Foaf profile
     * @return Authentication_AgentARC
     */
    public function getAgent() {
        return $this->agent;
    }
}

?>
