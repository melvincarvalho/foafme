<?php

//-----------------------------------------------------------------------------------------------------------------------------------
//
// Filename   : Authentication_FoafSSLARC.php
// Date       : 14th Feb 2010
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

require_once(dirname(__FILE__)."/../arc/ARC2.php");
require_once(dirname(__FILE__)."/Authentication_Helper.php");
require_once(dirname(__FILE__)."/Authentication_FoafSSLAbstract.php");
/**
 * @author Akbar Hossain
 * Implements Foaf+SSL authentication as described by http://esw.w3.org/Foaf%2Bssl
 *
 * The facilities of the ARC library are used.
 */
class Authentication_FoafSSLARC extends Authentication_FoafSSLAbstract
{
   private $ARCConfig = NULL;
   // TODO this instance is shared
   public  $ARCStore  = NULL;

   /**
    * Authenticate using Foaf+SSL procedure
    *
    * @param array $ARCConfig
    * @param mixed $ARCStore
    * @param Boolean $createSession
    * @param String $SSLClientCert Client certificate in PEM format
    */
   public function __construct($ARCConfig, $ARCStore = NULL, $createSession= TRUE, $SSLClientCert = NULL) {

       $this->ARCConfig = $ARCConfig;
       $this->ARCStore = $ARCStore;

       parent::__construct($createSession, $SSLClientCert);
   }

    private function createStore() {

        if ( (!isset($this->ARCStore)) && (Authentication_Helper::isValidURL($this->webid)) ) {

            $store = ARC2::getStore($this->ARCConfig);

            if (!$store->isSetUp()) {
                $store->setUp();
            }

            $store->reset();

            /* LOAD will call the Web reader, which will call the
               format detector, which in turn triggers the inclusion of an
               appropriate parser, etc. until the triples end up in the store. */
            $store->query('LOAD <'.$this->webid.'>');

            $this->ARCStore = $store;
        }
    }

    /* Returns an array of the modulus and exponent in the supplied RDF */
    protected function getFoafRSAKey() {

        $modulus   = NULL;
        $exponent  = NULL;
        $res       = NULL;
        $primaryId = $this->webid;

        $q = 'PREFIX foaf: <http://xmlns.com/foaf/0.1/>

              SELECT ?x ?primaryTopic
              WHERE {
                      ?x foaf:primaryTopic ?primaryTopic .
	            }';

        if ($rows = $this->ARCStore->query($q, 'rows')) {
            foreach ($rows as $row) {
//                    print "primaryTopic " . $row['primaryTopic'] . "<br/>";
                    $primaryId = $row['primaryTopic'];
            }
        }
	/* list names */
        $q = " PREFIX cert: <http://www.w3.org/ns/auth/cert#>
               PREFIX rsa: <http://www.w3.org/ns/auth/rsa#>
               SELECT ?m ?e ?mod ?exp ?person
               WHERE {
                       [] cert:identity ?person ;
                       rsa:modulus ?m ;
                       rsa:public_exponent ?e .
                       OPTIONAL { ?m cert:hex ?mod . }
                       OPTIONAL { ?e cert:decimal ?exp . }
                     } ";

      if ($rows = $this->ARCStore->query($q, 'rows')) {
 
            foreach ($rows as $row) {

                if ($row['person']==$primaryId) {

                    if (isset($row['mod']))
                        $modulus =  $row['mod'];
                    elseif (isset($row['m']))
                        $modulus =  $row['m'];

                    if (isset($row['exp']))
                        $exponent = $row['exp'];
                    elseif (isset($row['e']))
                        $exponent = $row['e'];

                    $modulus =  Authentication_Helper::cleanHex($modulus);
                    $exponent = Authentication_Helper::cleanHex($exponent);

                    $res[] = array( 'modulus'=>$modulus, 'exponent'=>$exponent );

                }
            }
       }
       
       return ( $res );
    }

    protected function getAgentRSAKey() {

        if ($this->webid) {

            $this->createStore();

            $store = $this->ARCStore;

            if (isset($store) && ($errs = $store->getErrors()))
            {
                return NULL;
            }

            if (isset($store) && ($agentRSAKey = $this->getFoafRSAKey()))
                return($agentRSAKey);

            return NULL;

        }

    }

}

?>
