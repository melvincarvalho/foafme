<?
// includes
include('config.php');
include('lib/libAuthentication.php');

$auth = $_SESSION['auth'];

if (!empty($_REQUEST['webid'])) {
	$auth = get_agent($_REQUEST['webid']);
	$key = $auth['agent']['RSAKey'];

	print "<h3>Security</h3>";

	if (!empty($key)) {

		// TODO: rdfa to match the table below
		print "Public Key: $key[modulus]<br/>";
		print "Exponent: $key[exponent]<br/>";

	} else {
	print 'This identity is not yet protected.<form name="input" action="' . $config['certficate_uri'] .'" method="get">';
?>
	<input type="hidden" size="25" id="foaf" name="foaf" value="<?= $_REQUEST['webid'] ?>">
	Key Strength: <keygen name="pubkey" challenge="randomchars"></td><td></td><td></td>
	<input type="hidden" id="commonName" name="commonName" value="FOAF ME Cert <?= $_REQUEST['webid'] ?>"><button id="generate" type="submit">Claim Account with SSL Certificate!</button> 
	<input type="hidden" id="uri" name="uri" value="<?= $_REQUEST['webid'] ?>">
	</form>
	<a href="https://foaf.me/simpleLogin.php">Test</a>
<?
	}
	

	print "<h3>Coming soon</h3>";
	print "Edit profile (please use tabulator at the moment)<br/> ";
	print "Privacy control<br/>";

} else {
	?>

<table typeof="cert:identity">
	<tr>
		<td><b>Secure Account!</b></td>
		<td>(RSA)</td>
	</tr>
	<tr>
		<td>Public Key:</td>
		<td><input inner="cert:hex" property="rsa:modulus" id="publicKey"
			onChange="makeTags()" type="text" name="publicKey" />
	
	</tr>
	<tr>
		<td>Exponent:</td>
		<td><input inner="cert:decimal" property="rsa:public_exponent"
			id="exponent" onChange="makeTags()" type="text" name="exponent" />
		(Default = 65537)
	
	</tr>
</table>



<?
}
?>


