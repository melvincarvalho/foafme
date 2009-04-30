<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
  	<title>Secure Web ID Login</title>
  	<meta name="description" content="Demo of a Sliding Login Panel using jQuery 1.3.2" />
  	<meta name="keywords" content="jquery, sliding, toggle, slideUp, slideDown, login, login form, register" />
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />	

	<!-- stylesheets -->
  	<link rel="stylesheet" href="css/style.css" type="text/css" media="screen" />
  	<link rel="stylesheet" href="css/slide.css" type="text/css" media="screen" />
	
  	<!-- PNG FIX for IE6 -->
  	<!-- http://24ways.org/2007/supersleight-transparent-png-in-ie6 -->
	<!--[if lte IE 6]>
		<script type="text/javascript" src="js/pngfix/supersleight-min.js"></script>
	<![endif]-->
	 
    <!-- jQuery - the core -->
	<script src="js/jquery-1.3.2.min.js" type="text/javascript"></script>
	<!-- Sliding effect -->
	<script src="js/slide.js" type="text/javascript"></script>

</head>

<body>
<!-- Panel -->
<div id="toppanel">
	<div id="panel">
		<div class="content clearfix">
			<div class="left">
				<h1>What is a Secure Web ID?</h1>
				<p class="grey">Super charge your browser with a Secure Web ID!  Do you always forget your passwords?  Well now you can!  Secure Web ID is an addon to your browser, that allows you to log in securely to 1000's of web sites without a password, and best of all it's free!  <br/><br/>To get a Secure Web ID you just need 2 things:<br/><br/>1) A FOAF profile <br/>2) A certificate</p>
			</div>
			<div class="left">
				<!-- Login Form -->
				<form class="clearfix" action="#" method="post">
					<h1>How Do I Get a FOAF Profile?</h1>
				    <p class="grey">Perhaps you already have a FOAF profile?  Sites like hi5, livejournal, myopera, qdos and identi.ca all provide you with one.<br/><br/>If not, click <a href="/">here</a></p>
					<!--
					<label class="grey" for="log">Username:</label>
					<input class="field" type="text" name="log" id="log" value="" size="23" />
					<label class="grey" for="pwd">Password:</label>
					<input class="field" type="password" name="pwd" id="pwd" size="23" />
	            	<label><input name="rememberme" id="rememberme" type="checkbox" checked="checked" value="forever" /> &nbsp;Remember me</label>
        			<div class="clear"></div>
					<input type="submit" name="submit" value="Login" class="bt_login" />
					<a class="lost-pwd" href="#">Lost your password?</a>
					-->
				</form>
			</div>
			<div class="left right">			
				<!-- Register Form -->
				<form action="#" method="post">
					<h1>How Do I Get a Certificate?</h1>				
				    <p class="grey">Got your FOAF profile?  Great!  You're almost done.  All you need now is a browser certificate.
					
					<br/><br/>To get your secure browser certificate, click <a href="http://test.foafssl.org/cert">here</a></p>
					<!--
					<label class="grey" for="signup">Username:</label>
					<input class="field" type="text" name="signup" id="signup" value="" size="23" />
					<label class="grey" for="email">Email:</label>
					<input class="field" type="text" name="email" id="email" size="23" />
					<label>A password will be e-mailed to you.</label>
					<input type="submit" name="submit" value="Register" class="bt_register" />
					-->
				</form>
			</div>
		</div>
	</div> <!-- /login -->	

    <!-- The tab on top -->	
	<div class="tab">
		<ul class="login">
	    	<li class="left">&nbsp;</li>
	        <li><? print $_REQUEST['webid'] ? "<a href=index.php>Logout: $_REQUEST[webid]</a>" : "<a href=https://foafssl.org/srv/insecureLogin?return_to=http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI] />Login With Secure Web ID</a>" ?></li>
			<li class="sep">|</li>
			<li id="toggle">
				<a id="open" class="open" href="#" ?> New Users</a>
				<a id="close" style="display: none;" class="close" href="#">Close Panel</a>			
			</li>
	    	<li class="right">&nbsp;</li>
		</ul> 
	</div> <!-- / top -->
	
</div> <!--panel -->

    <div id="container">
	<img align="right" id="postit" src="http://brophus.com/postit.png"/>
		<div id="content" style="padding-top:100px;">

<?php			
print $_REQUEST['webid'] ? "<h1>Welcome!</h1><script src=http://foaf-visualizer.org/embed/widget/?uri=$_REQUEST[webid] ></SCRIPT>" : "<h1>Welcome!</h1>  " ;
?>

		</div><!-- / content -->		
	</div><!-- / container -->
</body>
</html>
