<?php 
	$discussion = $vars['entity'];
	$karma = new vazco_karma();
	$karma->handleDiscussionRead(get_loggedin_user(), $discussion);
?>