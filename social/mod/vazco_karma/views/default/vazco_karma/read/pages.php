<?php 
if ($vars['full']){
	$page = $vars['entity'];
	$karma = new vazco_karma();
	$karma->handlePageRead(get_loggedin_user(), $page);
}
?>