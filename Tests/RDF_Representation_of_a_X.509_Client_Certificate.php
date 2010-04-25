<?
require_once(dirname(__FILE__).'/../documentation.php');

page_header("RDF Representation of a X.509 SSL Client Certificate");
?>
<body>
<h1><a name="s0">RDF Representation of a X.509 SSL Client Certificate</a></h1>

The following RDF fragment is generated from the SSL Client Certificate presented to the server based on the following ontologies<br>
<ul>
<a href="http://www.w3.org/ns/auth/cert">Certificate Ontology</a> - http://www.w3.org/ns/auth/cert<br>
<a href="http://www.w3.org/ns/auth/rsa">RSA Ontology</a> - http://www.w3.org/ns/auth/rsa<br>
</ul>
Adding this fragment to your FOAF file is one of the steps for implementing the <a href="http://www.w3.org/2008/09/msnws/papers/foaf+ssl.html">FOAF + SSL protocol</a> as outlined by <a href="http://bblfish.net/">Henry Story</a>.<br>
<b>
<ul>
1. <a href="#s1">Client Certificate in RDF</a><br>
2. <a href="#s2">Downloads</a><br>
<br>
3. <a href="#s3">See Also</a><br>
4. <a href="#s4">External Links</a><br>
</ul>
</b>
<?
$subjectAltName = openssl_get_subjectAltName();
$certrsakey     = openssl_pkey_get_public_hex();

function printrdf($str)
{
	print preg_replace('/</', '&lt;', $str);
}

section_header("1", "Client Certificate in RDF");

if (!$_SERVER[SSL_CLIENT_CERT]) 
{
	print "<br>Please use the following secure uri. <a href='https://foaf.me/RDF_Representation_of_a_X.509_Client_Certificate.php#s1'>https://foaf.me/RDF_Representation_of_a_X.509_Client_Certificate.php</a> to display your Client Certificate in RDF here.<br><br>";
}

	print "<pre><font color='blue'>";
	printrdf('<?xml version="1.0" encoding="ISO-8859-1"?>');
    print "<br>";
	printrdf('<rdf:RDF');
    print '<br>	xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"<br>';
//    print '	xmlns:rdfs="http://www.w3.org/2000/01/rdf-schema#"<br>';
	print '	xmlns:cert="http://www.w3.org/ns/auth/cert#"<br>';
    print '	xmlns:rsa="http://www.w3.org/ns/auth/rsa#">';
	print "</font><br><br>";
	printrdf('<rsa:RSAPublicKey>');
	print "<br>";
	$foaffile = ($subjectAltName[URI])?$subjectAltName[URI]:'TYPE YOUR WEBID HERE';
	printrdf('   <cert:identity rdf:resource="'.$foaffile.'"/>');
	print "<br>";
	printrdf('   <rsa:public_exponent cert:decimal="');
	$exponent = ($certrsakey[exponent])?hexdec($certrsakey[exponent]):'TYPE THE EXPONENT OF YOUR PUBLIC KEY HERE';
	printrdf($exponent.'"/>');
	print "<br>";
	printrdf('   <rsa:modulus cert:hex="');
	$modulus = ($certrsakey[modulus])?$certrsakey[modulus]:'TYPE THE MODULUS OF YOUR PUBLIC RSA KEY HERE';
	printrdf($modulus.'"/>');
	print "<br>";
	printrdf('</rsa:RSAPublicKey>');
	print "<br><br><font color='blue'>";
	printrdf('</rdf:RDF>');
	print "</font></pre>";
?>
<?
section_header("2", "Downloads");
?>
<ul>
<a href="https://foaf.me/cert.rdf">Export RDF</a><br>
</ul>
<?
section_header("3", "See Also");
see_also();
section_header("4", "External Links");
?>
<ul>
<a href="http://www.w3.org/ns/auth/cert">Certificate Ontology</a> - http://www.w3.org/ns/auth/cert<br>
<a href="http://www.w3.org/ns/auth/rsa">RSA Ontology</a> - http://www.w3.org/ns/auth/rsa<br>
</ul>
</body>
</html>