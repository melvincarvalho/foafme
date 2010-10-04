<?php
/***************************/
//@Author: Adrian "yEnS" Mato Gondelle & Ivan Guardado Castro
//@website: www.yensdesign.com
//@email: yensamg@gmail.com
//@license: Feel free to use it, but keep this credits please!					
/***************************/

/************************
	CONSTANTS
/************************/
define("HOST", "localhost");
define("USER", "root");
define("PASSWORD", "");
define("DB", "foaf_foaf");

/************************
	FUNCTIONS
/************************/
function connect($db, $user, $password){
	$link = @mysql_connect($db, $user, $password);
	if (!$link)
	    die("Could not connect: ".mysql_error());
	else{
		$db = mysql_select_db(DB);
		if(!$db)
			die("Could not select database: ".mysql_error());
		else return $link;
	}
}
function getContent($link, $num){
	$res = @mysql_query("SELECT date, user, message FROM shoutbox ORDER BY date DESC LIMIT ".$num, $link);
	if(!$res)
		die("Error: ".mysql_error());
	else
		return $res;
}
function insertMessage($user, $message){
	$query = sprintf("INSERT INTO shoutbox(user, message) VALUES('%s', '%s');", mysql_real_escape_string(strip_tags($user)), mysql_real_escape_string(strip_tags($message)));
	$res = @mysql_query($query);
	if(!$res)
		die("Error: ".mysql_error());
	else
		return $res;
}

/******************************
	MANAGE REQUESTS
/******************************/
if(!$_POST['action']){
	//We are redirecting people to our shoutbox page if they try to enter in our shoutbox.php
	header ("Location: index.html"); 
}
else{
	$link = connect(HOST, USER, PASSWORD);
	switch($_POST['action']){
		case "update":
			$res = getContent($link, 20);
			while($row = mysql_fetch_array($res)){
				$result .= "<li><strong>".$row['user']."</strong><img src=\"css/images/bullet.gif\" alt=\"-\" />".$row['message']." <span class=\"date\">".$row['date']."</span></li>";
			}
			echo $result;
			break;
		case "insert":
			echo insertMessage($_POST['nick'], $_POST['message']);
			break;
	}
	mysql_close($link);
}


?>
