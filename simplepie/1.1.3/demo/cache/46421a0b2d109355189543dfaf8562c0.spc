a:4:{s:5:"child";a:1:{s:0:"";a:1:{s:3:"rss";a:1:{i:0;a:6:{s:4:"data";s:0:"";s:7:"attribs";a:1:{s:0:"";a:1:{s:7:"version";s:3:"2.0";}}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";s:5:"child";a:1:{s:0:"";a:1:{s:7:"channel";a:1:{i:0;a:6:{s:4:"data";s:23:"
	
	
	
	
	
	
	
			
		
	";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";s:5:"child";a:2:{s:0:"";a:7:{s:5:"title";a:1:{i:0;a:5:{s:4:"data";s:15:"Melvin Carvalho";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"link";a:1:{i:0;a:5:{s:4:"data";s:30:"http://melvincarvalho.com/blog";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:11:"description";a:1:{i:0;a:5:{s:4:"data";s:29:"Just another WordPress weblog";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:7:"pubDate";a:1:{i:0;a:5:{s:4:"data";s:31:"Wed, 10 Dec 2008 21:39:01 +0000";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:9:"generator";a:1:{i:0;a:5:{s:4:"data";s:29:"http://wordpress.org/?v=2.6.3";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:8:"language";a:1:{i:0;a:5:{s:4:"data";s:2:"en";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"item";a:2:{i:0;a:6:{s:4:"data";s:39:"
		
		
		
		
		
		
		

		
		
			
			
		";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";s:5:"child";a:4:{s:0:"";a:7:{s:5:"title";a:1:{i:0;a:5:{s:4:"data";s:60:"Enabling a Public Apache Server to Read a Client Certificate";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"link";a:1:{i:0;a:5:{s:4:"data";s:35:"http://melvincarvalho.com/blog/?p=8";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:8:"comments";a:1:{i:0;a:5:{s:4:"data";s:44:"http://melvincarvalho.com/blog/?p=8#comments";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:7:"pubDate";a:1:{i:0;a:5:{s:4:"data";s:31:"Wed, 10 Dec 2008 14:54:26 +0000";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:8:"category";a:1:{i:0;a:5:{s:4:"data";s:13:"Uncategorized";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"guid";a:1:{i:0;a:5:{s:4:"data";s:35:"http://melvincarvalho.com/blog/?p=8";s:7:"attribs";a:1:{s:0:"";a:1:{s:11:"isPermaLink";s:5:"false";}}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:11:"description";a:1:{i:0;a:5:{s:4:"data";s:321:"The following is a recipe to configure an Apache Web Server to accept and read a self-signed SSL client certificates. This is one of the steps to implement the FOAF + SSL protocol as outlined by Henry Story.
1. Starting assumption is that your Apache server has SSL installed and working.

If not this is covered in [...]";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}s:32:"http://purl.org/dc/elements/1.1/";a:1:{s:7:"creator";a:1:{i:0;a:5:{s:4:"data";s:14:"melvincarvalho";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}s:40:"http://purl.org/rss/1.0/modules/content/";a:1:{s:7:"encoded";a:1:{i:0;a:5:{s:4:"data";s:1486:"<p>The following is a recipe to configure an Apache Web Server to accept and read a self-signed SSL client certificates. This is one of the steps to implement the FOAF + SSL protocol as outlined by Henry Story.</p>
<p><strong>1. Starting assumption is that your Apache server has SSL installed and working.<br />
</strong></p>
<p>If not this is covered in depth in many other places, the easiest way is to contact your web hoster to get this done.</p>
<p><strong>2. Change tha Apache httpd.conf to enable client certificates</strong></p>
<p>You will need editing rights on your httpd.conf.  Here are the changes I made in order to get things working:</p>
<p>SSLVerifyClient optional_no_ca<br />
SSLVerifyDepth 1</p>
<p>Note: SSLCACertificateFile is not set so self signed certificates are not checked against the trusted CA&#8217;s configured on the server.</p>
<p><strong>3. Add the following to the .htaccess to make the SSL variables available to php</strong></p>
<p>SSLOptions +StdEnvVars<br />
SSLOptions +ExportCertData</p>
<p><strong>4. How to test it</strong></p>
<p>The following code should be able to print out diagnostic information:</p>
<p>print_r($_SERVER);<br />
print_r(openssl_x509_parse($_SERVER[SSL_CLIENT_CERT]))</p>
<p>An example can be seen here: <a href="https://foaf.me/test.php">https://foaf.me/test.php</a></p>
<p><a href="https://foaf.me/test.php"></a><br />
If you think there&#8217;s a way to improve any of these steps please feel free to let me know.</p>
";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}s:36:"http://wellformedweb.org/CommentAPI/";a:1:{s:10:"commentRss";a:1:{i:0;a:5:{s:4:"data";s:45:"http://melvincarvalho.com/blog/?feed=rss2&p=8";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}}}i:1;a:6:{s:4:"data";s:39:"
		
		
		
		
		
		
		

		
		
			
			
		";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";s:5:"child";a:4:{s:0:"";a:7:{s:5:"title";a:1:{i:0;a:5:{s:4:"data";s:11:"25 November";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"link";a:1:{i:0;a:5:{s:4:"data";s:35:"http://melvincarvalho.com/blog/?p=1";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:8:"comments";a:1:{i:0;a:5:{s:4:"data";s:44:"http://melvincarvalho.com/blog/?p=1#comments";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:7:"pubDate";a:1:{i:0;a:5:{s:4:"data";s:31:"Tue, 25 Nov 2008 14:48:09 +0000";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:8:"category";a:1:{i:0;a:5:{s:4:"data";s:13:"Uncategorized";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"guid";a:1:{i:0;a:5:{s:4:"data";s:35:"http://melvincarvalho.com/blog/?p=1";s:7:"attribs";a:1:{s:0:"";a:1:{s:11:"isPermaLink";s:5:"false";}}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:11:"description";a:1:{i:0;a:5:{s:4:"data";s:398:"On this day in history I started a blog, JFK was buried and, &#8220;Do they know it&#8217;s Chirstmas&#8221; was recorded.
One said to &#8220;Feed the world&#8221;, the other &#8220;Together let us expore the stars, conquer the deserts, eradicate disease, tap the ocean depths, and encourage the arts and commerce&#8221;.
I beleive we can make this happen.  The board is set, the pieces [...]";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}s:32:"http://purl.org/dc/elements/1.1/";a:1:{s:7:"creator";a:1:{i:0;a:5:{s:4:"data";s:5:"admin";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}s:40:"http://purl.org/rss/1.0/modules/content/";a:1:{s:7:"encoded";a:1:{i:0;a:5:{s:4:"data";s:429:"<p>On this day in history I started a blog, JFK was buried and, &#8220;Do they know it&#8217;s Chirstmas&#8221; was recorded.</p>
<p>One said to &#8220;Feed the world&#8221;, the other &#8220;Together let us expore the stars, conquer the deserts, eradicate disease, tap the ocean depths, and encourage the arts and commerce&#8221;.</p>
<p>I beleive we can make this happen.  The board is set, the pieces are in motion!</p>
";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}s:36:"http://wellformedweb.org/CommentAPI/";a:1:{s:10:"commentRss";a:1:{i:0;a:5:{s:4:"data";s:45:"http://melvincarvalho.com/blog/?feed=rss2&p=1";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}}}}}s:27:"http://www.w3.org/2005/Atom";a:1:{s:4:"link";a:1:{i:0;a:5:{s:4:"data";s:0:"";s:7:"attribs";a:1:{s:0:"";a:3:{s:4:"href";s:41:"http://melvincarvalho.com/blog/?feed=rss2";s:3:"rel";s:4:"self";s:4:"type";s:19:"application/rss+xml";}}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}}}}}}}}}}s:4:"type";i:128;s:7:"headers";a:8:{s:4:"date";s:29:"Tue, 17 Mar 2009 16:04:10 GMT";s:6:"server";s:142:"Apache/1.3.41 (Unix) PHP/4.4.8 mod_log_bytes/1.2 mod_bwlimited/1.4 mod_auth_passthrough/1.8 FrontPage/5.0.2.2635 mod_ssl/2.8.31 OpenSSL/0.9.7a";s:12:"x-powered-by";s:9:"PHP/4.4.8";s:10:"x-pingback";s:41:"http://melvincarvalho.com/blog/xmlrpc.php";s:13:"last-modified";s:29:"Wed, 10 Dec 2008 21:39:01 GMT";s:4:"etag";s:32:"8c290a14cf128d481b7270a4515908a5";s:17:"transfer-encoding";s:7:"chunked";s:12:"content-type";s:23:"text/xml; charset=UTF-8";}s:5:"build";i:20081219;}