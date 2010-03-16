<?php 

session_name('phpMyID_Server');
session_start();

include('head.php'); ?>

<body id="tools_scrollable">

	<div id="wrap">	
			
        <?php include('header.php'); ?>

	<h2><strong>Server Setup</strong></h2>

	<ul>
		<a href="http://foaf.me/Enabling_SSL_Client_Certificates_on_Apache.php">Enabling SSL Client Certificates on Apache</a>
	</ul>

	<h2><strong>Diagnostic Tools</strong></h2>
	<ul>
		<a href="https://foaf.me/RDF_Representation_of_a_X.509_Client_Certificate.php"><h3>RDF Representation of a X.509 SSL Client Certificate</h3></a>
		<a href="http://foaf.me/simpleCert.php"><h3>Simple Create Client Certificate and corresponding FOAF File</h3></a>


		<a href="http://foaf.me/simple_KEYGEN_CreateClientCertificate.php"><h3>Simple KEYGEN based Create Client Certificate Page</h3></a>


		<a href="http://foaf.me/simpleCreateClientCertificate.php"><h3>Simple Create Client Certificate Page</h3></a>
		See Also: <a href="http://foaf.me/Using_PHP_to_create_X.509_Client_Certificates.php">[Using PHP to create self-signed X.509 Client Certificates]</a>


	
	</ul>
        </div>

    </body>

</html>
