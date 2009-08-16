<?php include('head.php'); ?>

<body>

<div id="wrap"><?php include('header.php'); ?> <?php

require_once("config.php");
require_once("db.class.php");
require_once('lib/libAuthentication.php');

$db = new db_class();
$db->connect('localhost', $config['db_user'], $config['db_pwd'], $config['db_name']);



function printrdf($str) {
	global $rdf;
	$rdf .= $str;
}

$subjectAltName = openssl_get_subjectAltName();
$certrsakey     = openssl_pkey_get_public_hex();


$rdf = $_POST['rdf'];
if (empty($rdf) || $rdf == '0' ) {

	$rdf = '<rdf:RDF';
	printrdf('	xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"');
	printrdf('	xmlns:cert="http://www.w3.org/ns/auth/cert#"');
	printrdf('	xmlns:rsa="http://www.w3.org/ns/auth/rsa#">');
	printrdf('<rsa:RSAPublicKey>');
	$foaffile = ($subjectAltName['URI'])?$subjectAltName['URI']:'TYPE YOUR WEBID HERE';
	printrdf('   <cert:identity rdf:resource="'.$foaffile.'"/>');
	printrdf('   <rsa:public_exponent cert:decimal="');
	$exponent = ($certrsakey['exponent'])?hexdec($certrsakey['exponent']):'TYPE THE EXPONENT OF YOUR PUBLIC KEY HERE';
	printrdf($exponent.'"/>');
	printrdf('   <rsa:modulus cert:hex="');
	$modulus = ($certrsakey['modulus'])?$certrsakey['modulus']:'TYPE THE MODULUS OF YOUR PUBLIC RSA KEY HERE';
	printrdf($modulus.'"/>');
	printrdf('</rsa:RSAPublicKey>');
	printrdf('</rdf:RDF>');

}

// check if username exists
$username = 
$res = $db->select(" select * from foaf where username like '$_POST[uri]' ");
$numrows = $db->row_count;
if ($numrows == 0) {
	$db->insert_sql(" insert into foaf (id, username, rdf) VALUES (NULL, '$_POST[uri]', '$rdf')  ");
} else {
	//$db->update_sql(" update foaf set rdf = '$_POST[rdf]' , rdf2 = '$rdf' where username like '$_POST[uri]'  ");
}


$webid = "http://" . $_SERVER['HTTP_HOST'] . str_replace('store.php', '', $_SERVER['PHP_SELF']) .
        $_POST['uri'];
        
$link = "http://" . $_SERVER['HTTP_HOST'] . str_replace('store.php', 'index.php', $_SERVER['PHP_SELF'])
        . "?webid=$webid";


if ($numrows == 0) {
?>


<div class="success">Congratulations, your new FOAF profile was created successfully. You can now use the Web ID <a href='<?= $link ?>%23me'><?= $webid ?>#me</a> to refer to yourself. </div> 
<br/>

<?
	print 'This identity is not yet protected.<form name="input" action="' . $config['certficate_uri'] .'" method="get">';
?>
<br/>
	<input type="hidden" size="25" id="foaf" name="foaf" value="<?= $webid ?>">
	Key Strength: <keygen name="pubkey" challenge="randomchars"></td><td></td><td></td>
	<input type="hidden" id="commonName" name="commonName" value="FOAF ME Cert <?= $webid ?>"><button id="generate" type="submit">Claim Account with SSL Certificate!</button> 
	<input type="hidden" id="uri" name="uri" value="<?= $webid ?>">
	</form>

	<a href="https://foaf.me/simpleLogin.php">Test</a>

<? } else { ?>

Sorry, username already exists, please press back and try another username.

<? } ?>

</div>
</body>
</html>
