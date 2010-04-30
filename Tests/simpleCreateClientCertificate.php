<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
<head profile="http://www.w3.org/2000/08/w3c-synd/#">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style type="text/css">
<!--
#section
{
	border-top: 1px solid black;
	padding-top: 10px;
}
-->
</style>
<title>Simple Create Client Certificate Page</title>
</head>
<body>
<h1>Simple Create Client Certificate Page</h1>
<form name="input" action="https://foaf.me/cert.php" method="get">
<table>
<tr>
<td>FOAF URI</td><td><input type="text" name="foaf"></td><td style="color:red">http://foaf.me/jsmith</td><td style="color:blue">Required</td>
</tr>
<tr>
<td>commonName</td><td><input type="text" name="commonName"></td><td style="color:red">J Smith</td><td style="color:blue">Optional</td>
</tr>
<tr>
<td>emailAddress</td><td><input type="text" name="emailAddress"></td><td style="color:red">jsmith@example.com</td><td style="color:blue">Optional</td>
</tr>
<tr>
<td>organizationName</td><td><input type="text" name="organizationName"></td><td style="color:red">My Company Ltd</td><td style="color:blue">Optional / Default</td>
</tr>
<tr>
<td>organizationalUnitName</td><td><input type="text" name="organizationalUnitName"></td><td style="color:red">Technology Division</td><td style="color:blue">Optional</td>
</tr>
<tr>
<td>localityName</td><td><input type="text" name="localityName"></td><td style="color:red">Newbury</td><td style="color:blue">Optional / Default</td>
</tr>
<tr>
<td>stateOrProvinceName</td><td><input type="text" name="stateOrProvinceName"></td><td style="color:red">Berkshire</td><td style="color:blue">Optional / Default</td>
</tr>
<tr>
<td>countryName</td><td><input type="text" name="countryName"></td><td style="color:red">GB</td><td style="color:blue">Optional / Default</td>
</tr>
<tr>
<td>p12Password</td><td><input type="text" name="password"></td><td style="color:red">secret</td><td style="color:blue">Optional</td>
</tr>
<tr>
<td>&nbsp;</td>
</tr>
<tr>
<td></td><td><input type="submit" value="Submit"></td>
</tr>
</table>
</form>
<br><br>
<table width=100% id=section>
<tr>
<td><B>Downloads</B></td>
</tr>
</table>
<ul>
<a href="download.php?uri=cert.php">cert.php</a><br>
<a href="download.php?uri=simpleCreateClientCertificate.php">simpleCreateClientCertificate.php</a><br>
</ul>
<table width=100% id=section>
<tr>
<td><B>See Also</B></td>
</tr>
</table>
<ul>
<a href="http://foaf.me/Enabling_SSL_Client_Certificates_on_Apache.php">Enabling SSL Client Certificates on Apache</a><br>
<a href="http://foaf.me/Using_PHP_to_create_X.509_Client_Certificates.php">Using PHP to create X.509 Client Certificates</a><br>
<a href="https://foaf.me/RDF_Representation_of_a_X.509_Client_Certificate.php">RDF Representation of a X.509 Client Certificate</a><br>
</ul>
</body>
</html>