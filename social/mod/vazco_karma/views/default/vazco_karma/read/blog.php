<?php 
if ($vars['full']){
	$blog = $vars['entity'];
	$karma = new vazco_karma();
	$karma->handleBlogRead(get_loggedin_user(), $blog);
}
?>