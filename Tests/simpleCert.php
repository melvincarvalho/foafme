<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
<head profile="http://www.w3.org/2000/08/w3c-synd/#">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Create Certificate</title>
<style type="text/css">
<!--
#section
{
	border-top: 1px solid black;
	padding-top: 10px;
}

.skip
{
	display: none;
}
-->
</style>
</head>
<body>
<h1>Create Certificate</h1>
The following recipe is a PHP implementation of <a href="http://test.foafssl.org/cert/">http://test.foafssl.org/cert/</a>.<br>
<br>
This PHP script creates a X.509 certificate which is automatically loaded into your browser. This script only works with browsers that support the <a href="http://eskimonorth.com/~bloo/indexdot/html/tagpages/k/keygen.htm">KEYGEN</a> tag: Firefox, Safari and Opera.<br>
The generated client certificate holds an indirect reference to the supplied foaf:Person in the certificate's subjectAltName and can be used as part of the <a href="http://www.w3.org/2008/09/msnws/papers/foaf+ssl.html">FOAF + SSL protocol</a> as outlined by <a href="http://bblfish.net/">Henry Story</a>.<br>
<br>
<b>Step 1: Enter a deferencable foaf:Person URI</b><br>
<ul>
<form name="input" action="http://foaf.me/suggestNames.php" method="get">
foaf:Person URI:
<input type="text" size="80" name="foafuri"/>
<input type="submit" value="submit webid"/>
</form>
</ul>
<br>
<table width=100% id=section>
<tr>
<td><B>Downloads</B></td>
</tr>
</table>
<ul>
<a href="download.php?uri=createCertificateAccount.php">createCertificateAccount.php</a><br>
<a href="download.php?uri=rdfFragments.php">rdfFragments.php</a><br>
<a href="download.php?uri=x509Functions.php">x509Functions.php</a><br>
</ul>
<table width=100% id=section>
<tr>
<td><B>See Also</B></td>
</tr>
</table>
<ul>
<a href="http://foaf.me/Enabling_SSL_Client_Certificates_on_Apache.php">Enabling SSL Client Certificates on Apache</a><br>
<a href="https://foaf.me/RDF_Representation_of_a_X.509_Client_Certificate.php">RDF Representation of a X.509 Client Certificate</a><br>
</ul>
<table width=100% id=section>
<tr>
<td><B>External Links</B></td>
</tr>
</table>
<ul>
<a href="http://phpmylogin.sourceforge.net/wiki/doku.php?id=keygen_attribute">http://phpmylogin.sourceforge.net/wiki/doku.php?id=keygen_attribute</a><br>
<a href="http://lists.foaf-project.org/pipermail/foaf-protocols/2009-January/000200.html">[foaf-protocols] http://test.foafssl.org/cert/</a>
</ul>
</body>
</html>