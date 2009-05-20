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
		print "No public key found";
	}
	
	print "<h3>Coming soon</h3>";
	print "Protect account with SSL <a href='$config[certficate_uri]?" .
	      "commonName=foaf.me-cert&foaf=" .
	      $_REQUEST['webid'] . "'>certificate</a><br/> ";
	print "Edit profile (please use tabulator at the moment)<br/> ";
	print "Privacy control<br/>";

} else {
	?>

<table>
	<tr typeof="cert:identity">
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


