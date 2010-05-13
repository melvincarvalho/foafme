<?php
/**
 * simpleLogin.php - simpleLogin
 *
 * Copyright 2008-2010 foaf.me
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
require_once('config.php');
require_once('db.class.php');
require_once('lib/Authentication.php');
$auth = new Authentication($GLOBALS['config']);
?>
<body>
    <h1>FOAF+SSL Simple Login Page</h1>


    <div id="diagnostics">
        <?php
        // Setup
        if ($_SERVER['SSL_CLIENT_CERT']) {
            $certModulus = $auth->certModulus;
            $certExponent = $auth->certExponent;
            $subjectAltName = $auth->certSubjectAltName['URI'];
            $agent = $auth->getAgent();
            //$agentArc = new Authentication_AgentARC($GLOBALS['config'], $auth->webid);
            //$agent = $agentArc->getAgent();
            if ( isset($agent['RSAKey']) ) {
                $foaf_rsakey = $agent['RSAKey'];
            }
        }

        // Did we login?
        if ($auth->isAuthenticated()) {
            print "<b>The login Suceeded! Authenticated as:  " . $subjectAltName
                    . "</b><p>Technical Explanation:</p>";
        } else {
            print "<b>Not Logged In</b><br/><br/>";
        }

        // Did we discover a cert?
        if ($_SERVER['SSL_CLIENT_CERT']) {
            print 'SSL Client Certificate: <span style="color:green">detected!</span><BR><BR>';
        } else {
            print 'SSL Client Certificate: <span style="color:green">Not detected!</span><BR><BR>';
        }

        // What's in the cert?
        if ($_SERVER['SSL_CLIENT_CERT']) {

            print "Client Certificate Public Key <span style='color:green'>detected! (HEX):<br>";

            print "<pre>";
            print "Modulus : <br /><span style='color:green'>". $certModulus ."</span><br/>";
            print "Exponent : <span style='color:green'> ". $certExponent ." </span><br/>";
            print "</pre></span>";
        } else {
            print "Client Certificate Public Key: <span style='color:green'>Not detected!</span><BR><BR>";
        }

        // Did we find a subjectAltName?
        if ($subjectAltName) {
            print "Subject Alt Name (FOAF Profile): <span style='color:green'>detected!: $subjectAltName</span><BR><BR>";
        } else {
            print "Subject Alt Name: <span style='color:green'>Not detected!</span><BR><BR>";
        }

        //  Did we find a public key in the FOAF?
        if ( $foaf_rsakey ) {
            print "FOAF Remote Public Key found in $subjectAltName:<br><span style='color:green'>";

            foreach ($foaf_rsakey as $rsa_key) {
                print "<pre>";
                print "Modulus : <br /><span style='color:green'>". $rsa_key['modulus'] ."</span><br/>";
                print "Exponent : <span style='color:green'> ". $rsa_key['exponent'] ." </span><br/>";
                print "</pre></span>";
            }
        } else {
            print "FOAF Remote Public Key: <span style='color:green'>Not detected!</span><BR><BR>";
        }


        ?>
    </div>

    <br/>
    <SCRIPT>
        function show() {
            document.getElementById('rdf').style.display = 'block';
            document.getElementById('rdfa').style.display = 'block';
        }
    </SCRIPT>




    <a href="javascript:show()">more</a>

    <div id=rdfa style='display:none'>
        <h2>RDF Representation</h2>
        <textarea rows=20 cols=200>
<rdf:RDF
	xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
	xmlns:cert="http://www.w3.org/ns/auth/cert#"
	xmlns:rsa="http://www.w3.org/ns/auth/rsa#">

<rsa:RSAPublicKey>
   <cert:identity rdf:resource="<?= $subjectAltName[URI] ?>"/>
   <rsa:public_exponent cert:decimal="65537"/>
   <rsa:modulus cert:hex="<? print_r($cert_rsakey['modulus']); ?>"/>
</rsa:RSAPublicKey>

</rdf:RDF>
        </textarea>
    </div>

    <div id=rdf style='display:none'>
        <h2>RDFa Representation</h2>
        <textarea rows=10 cols=200>
<span typeof="rsa:RSAPublicKey">
<div about="#cert" typeof="rsa:RSAPublicKey">
  <div rel="cert:identity" href="$subjectAltName[URI]"></div>
  <div rel="rsa:public_exponent">
    <div property="cert:decimal" content="65537"></div>
  </div>
  <div rel="rsa:modulus">
    <div property="cert:hex" content="<? print_r($cert_rsakey['modulus']); ?>"></div>
  </div>
</div>
</span>

        </textarea>
    </div>

</body>
</html>
