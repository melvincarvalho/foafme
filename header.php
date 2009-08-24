<body id="tools_scrollable">
	<div id="wrap">	
<a href="index.php">Home</a> | <a href="about.php">About</a> | <a href="documentation.php">Documentation</a> | <a href="downloads.php">Downloads</a> | <a href="http://groups.google.com/group/foafme?lnk=srg&amp;hl=en&amp;ie=UTF-8&amp;oe=utf-8">Mailing List</a> 

<?php
//if (!empty($_SESSION['auth']) && $_SESSION['auth']['subjectAltName']) {
if (!empty($webid) ) {
?>
		<div id="user">
				<a id="logout" href="http://foaf.me/clearSession.php?return_to=<?php echo "http://$_SERVER[HTTP_HOST]$_SERVER[PHP_SELF]" ?>">
					<!-- Logout <strong><?= $_SESSION['auth']['subjectAltName'] ?> </strong> -->
		Logout <strong><?= $_REQUEST['webid'] ?></strong>
				</a>
			<br/>
		</div>
<? } else { ?>
		<div id="user">
				<a id="account" href="https://foafssl.org/srv/idp?authreqissuer=<?php echo "http://$_SERVER[HTTP_HOST]$_SERVER[PHP_SELF]" ?>">
					login to your <strong>account</strong>
				</a>
			<br />
		</div>
<? } ?>		
		
		
		 
		
		
		<div id="content"> 
		
		<h1>
			<img alt="foaf" src="images/foaf.gif" />
			<strong>FOAF</strong> 
		</h1>
		 
		<h2></h2>




