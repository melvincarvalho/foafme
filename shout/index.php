<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Shout Box</title>
	<link rel="stylesheet" href="css/general.css" type="text/css" media="screen" />
</head>
<body>
<?php  if ($_REQUEST['webid']) { ?>
	<form method="post" id="form">
		<table>
			<tr style='display:none'>
				<td><label>User</label></td>
				<td><input class="text user" id="nick" type="text" MAXLENGTH="50" value="<?= $_REQUEST['webid'] ?>"/></td>
			</tr>
			<tr>
				<td><label>What's on your mind?</label></td>
			</tr>
			<tr>
				<td><input class="text" id="message" type="text" MAXLENGTH="255" /></td>
			</tr>
			<tr>
				<td><input id="send" type="submit" value="Send!" /></td>
			</tr>
		</table>
	</form>
<?php  } else  { ?>
		<div id="user">
				<a id="account" href="https://foafssl.org/srv/idp?authreqissuer=<?php echo 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] ?>">
					login to your <strong>account</strong>
				</a>
			<br clear="all" />
		</div>
<?php  } ?>
	<div id="container">
		<ul class="menu">
			<li>Shoutbox</li>
		</ul>
		<span class="clear"></span>
		<div class="content">
			<h1>Latest Messages</h1>
			<div id="loading"><img src="css/images/loading.gif" alt="Loading..." /></div>
			<ul>
			<ul>
		</div>
	</div>
	<script type="text/javascript" src="jquery.js"></script>
	<script type="text/javascript" src="shoutbox.js"></script>
</body>
</html>
