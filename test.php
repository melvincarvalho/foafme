<?

//-----------------------------------------------------------------------------------------------------------------------------------
//
// Filename   : test.php                                                                                                  
// Date       : 15th October 2009
//
// Copyright 2008-2009 foaf.me
//
// This program is free software: you can redistribute it and/or modify
// it under the terms of the GNU Affero General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
// GNU Affero General Public License for more details.
//
// You should have received a copy of the GNU Affero General Public License
// along with this program. If not, see <http://www.gnu.org/licenses/>.
//
// "Everything should be made as simple as possible, but no simpler."
// -- Albert Einstein
//
//-----------------------------------------------------------------------------------------------------------------------------------

require_once('/home/foaf/public_html/v1/authenticationLevel.php');
require_once('/home/foaf/public_html/v1/documentation.php');

page_header("SSL Test Page");
?>
<body>
<h1><a name="s0">SSL Test Page</a></h1>
Below are some code fragments and functions displaying the SSL setup configuration on your Apache server and some basic interaction with a SSL Client Certificate if presented when viewing this page.<br>
<b>
<ul>
Checking the SSL Setup of the Server<br>
<br>
1. <a href="#s1">Displaying the output of the $_SERVER global variable</a><br>
<br>
Checking the SSL Client Certificate Setup<br>
<br>
2. <a href="#s2">Displaying the details in the supplied Client Certificate</a><br>
3. <a href="#s3">Displaying the Client Public Key info</a><br>
4. <a href="#s4">Function returning the Client Public Key info in HEX</a><br>
5. <a href="#s5">Function returning the subjectAltName in the Client Certificate</a><br>
<br>
6. <a href="#s6">See Also</a><br>
7. <a href="#s7">External Links</a>
</ul>
</b>
<br>
<?
section_header("1", 'Displaying the output of the $_SERVER global variable');
?>
<pre id=code>print_r($_SERVER};</pre>
<?
print '<pre>';
print_r($_SERVER);
print '</pre>';

section_header("2", "Displaying the details in the supplied Client Certificate");

print '<pre id=code>print_r(openssl_x509_parse($_SERVER[SSL_CLIENT_CERT]));</pre>';

if ($_SERVER[SSL_CLIENT_CERT]){
	print '<pre>';
	print_r(openssl_x509_parse($_SERVER[SSL_CLIENT_CERT]));
	print '</pre>';
}
else
	print 'No Client Certificate Sent<BR><BR>';

section_header("3", "Displaying the Client Public Key info");

print '<pre id=code>print_r(openssl_pkey_get_details(openssl_pkey_get_public($_SERVER[SSL_CLIENT_CERT])));</pre>';

if ($_SERVER[SSL_CLIENT_CERT]) {
	print '<pre>';
	print_r(openssl_pkey_get_details(openssl_pkey_get_public($_SERVER[SSL_CLIENT_CERT])));
	print '</pre>';
}
else
	print 'No Client Certificate Sent<BR><BR>';

section_header("4", "Function returning the Client Public Key info in HEX");

?>
<pre id=code>
function openssl_pkey_get_public_hex()
{
	if ($_SERVER[SSL_CLIENT_CERT])
	{
		$pub_key = openssl_pkey_get_public($_SERVER[SSL_CLIENT_CERT]);
		$key_data = openssl_pkey_get_details($pub_key);
	
		$key_len   = strlen($key_data[key]);
		$begin_len = strlen('-----BEGIN PUBLIC KEY----- ');
		$end_len   = strlen(' -----END PUBLIC KEY----- ');

		$rsa_cert = substr($key_data[key], $begin_len, $key_len - $begin_len - $end_len);

		$rsa_cert_struct = `echo "$rsa_cert" | openssl asn1parse -inform PEM -i`;

		$rsa_cert_fields = split("\n", $rsa_cert_struct);
		$rsakey_offset   = split(":",  $rsa_cert_fields[4]);

		$rsa_key = `echo "$rsa_cert" | openssl asn1parse -inform PEM -i -strparse $rsakey_offset[0]`;

		$rsa_keys = split("\n", $rsa_key);
		$modulus  = split(":", $rsa_keys[1]);
		$exponent = split(":", $rsa_keys[2]);

		return( array( 'modulus'=>$modulus[3], 'exponent'=>$exponent[3] ) );
	}
}
</pre>
<?

if ($_SERVER[SSL_CLIENT_CERT]) {
	$certrsakey = openssl_pkey_get_public_hex();

	print "Client Certificate Public Key in HEX:<BR>";
	print "<pre>";
	print_r($certrsakey);
	print "</pre>";
}
else
	print 'No Client Certificate Sent<BR><BR>';

section_header("5", "Function returning the subjectAltName in the Client Certificate");

?>
<pre id=code>
function openssl_get_subjectAltName()
{
	if ($_SERVER[SSL_CLIENT_CERT])
	{
		$cert = openssl_x509_parse($_SERVER[SSL_CLIENT_CERT]);
		if ($cert[extensions][subjectAltName])
		{
			$list          = split("[, ]", $cert[extensions][subjectAltName]);

			for ($i = 0, $i_max = count($list); $i < $i_max; $i++) 
			{
				if (strcmp($list[$i],"")!=0)
				{
					$value = split(":", $list[$i], 2);
					if ($subject_array)
						$subject_array = array_merge($subject_array, array($value[0] => $value[1]));
					else
						$subject_array = array($value[0] => $value[1]);
				}
			}

			return $subject_array;
		}
	}
}
</pre>
<?

if ($subjectAltName = openssl_get_subjectAltName())
{
	print "<pre>";
	print_r($subjectAltName);
	print "</pre>";
}
else
	print "No subjectAltName in supplied certificate<BR><BR>";

section_header("6", "See Also");
see_also();
section_header("7", "External Links");
?>
<ul><a href="http://en.wikipedia.org/wiki/Transport_Layer_Security">http://en.wikipedia.org/wiki/Transport_Layer_Security</a><br>
<a href="http://www.openssl.org/">http://www.openssl.org/</a><br>
<a href="http://madboa.com/geek/openssl/">http://madboa.com/geek/openssl/</a><br>
<a href="http://www.ipsec-howto.org/x595.html">http://www.ipsec-howto.org/x595.html</a><br>
</ul>
</body>
</html>