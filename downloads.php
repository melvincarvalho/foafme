<?php 

session_name('phpMyID_Server');
session_start();

include('head.php'); ?>

<body id="tools_scrollable">

	<div id="wrap">	
			
        <?php include('header.php'); ?>

	<h2><strong>Downloads</strong></h2>


	<ul>
		<a href="http://github.com/melvincarvalho/foafme/tree/master"><h2>GIT Hub Web App</h2></a>
		<a href="http://github.com/melvincarvalho/foafssl/tree/master"><h2>GIT Hub Certifcates</h2></a>

	</ul>

	<h3>FOAF+SSL Authentication PHP Library</h3>
		Requires: <a href="http://arc.semsol.org/download">ARC RDF Classes for PHP</a><br>
		Demo: <a href="https://foaf.me/testLibAuthentication.php">Example usage of getAuth();</a>

		<ul>
			v0.1: <a href="download.php?uri=libAuthentication.php">libAuthentication.php</a><br>
		</ul>

        </div>

    </body>

</html>
