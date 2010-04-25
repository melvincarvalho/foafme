<?
require_once(dirname(__FILE__).'/../documentation.php');

page_header("Enabling SSL Client Certificates on Apache");
?>
<body>
<h1><a name="s0">Enabling SSL Client Certificates on Apache</a></h1>

The following is a recipe to configure an Apache Web Server to accept and read a self-signed SSL client certificates.<br>
This is one of the steps to implement the <a href="http://www.w3.org/2008/09/msnws/papers/foaf+ssl.html">FOAF + SSL protocol</a> as outlined by <a href="http://bblfish.net/">Henry Story</a>.<br>
<b>
<ul>
1. <a href="#s1">Assumptions</a><br>
2. <a href="#s2">Change the Apache httpd.conf to enable client certificates</a><br>
3. <a href="#s3">Add the following to the .htaccess to make the SSL variables available to PHP</a><br>
4. <a href="#s4">How to test it</a><br>
<br>
5. <a href="#s5">How to exclude specific files from the client certificate request directive</a><br>
<br>
6. <a href="#s6">See Also</a><br>
7. <a href="#s7">External Links</a>
</ul>
</b>
<?
section_header("1", "Assumptions");
?>
<br>
The starting assumption of this recipe is that your Apache server has SSL installed and working.<br>
If not the instructions are here: <a href="http://www.apache-ssl.org/">http://www.apache-ssl.org/</a><br>
<br>
<?
section_header("2", "Change the Apache httpd.conf to enable client certificates");
?>
<br>You will need editing rights on your httpd.conf. Here are the changes we made in order to get things working:
<br>
<pre id=code>
&lt;Directory /&gt;
   SSLVerifyClient optional_no_ca
   SSLVerifyDepth 1
&lt;/Directory&gt;
</pre>
Note: SSLCACertificateFile is not set so self signed certificates are not checked against the trusted CAs configured on the server.<br>
<br>
<?
section_header("3", "Add the following to the .htaccess to make the SSL variables available to PHP");
?>
<pre id=code>
SSLOptions +StdEnvVars
SSLOptions +ExportCertData
</pre>
<?
section_header("4", "How to test it");
?>
<br>
The following code should be able to print out diagnostic information:<br>
<pre id=code>
print_r($_SERVER);
print_r(openssl_x509_parse($_SERVER[SSL_CLIENT_CERT]))
</pre>
An example can be seen here: <a href="https://foaf.me/testSSL.php">https://foaf.me/testSSL.php</a><br>
<br>
<?
section_header("5", "How to exclude specific files from the client certificate request directive");
?>
<br>
If you wish to exlude specific files on you web server from requesting a Client Certificate add the following to the .htaccess file in the appropriate directory.<br>
<pre id=code>
&lt;Files filename&gt;
   SSLVerifyClient none
&lt;/Files&gt;
</pre>
<?
section_header("6", "See Also");
see_also();
section_header("7", "External Links");
?>
<ul>
<a href="http://www.apache-ssl.org/">http://www.apache-ssl.org/</a><br>
<a href ="http://www.modssl.org/docs/2.1/ssl_reference.html">http://www.modssl.org/docs/2.1/ssl_reference.html</a><br>
</ul>
</body>