<?php 
	//action for admin only
	admin_gatekeeper();
	$old = ini_set('default_socket_timeout', 999999);
	$karma = new vazco_karma();
	$users = get_entities('user','',0,'',99999999);
	foreach($users as $user){
		$karma->givePoints($user,0);
	}
	ini_set('default_socket_timeout', $old);
	
	system_message(elgg_echo('vazco_karma:updaterankssuccess'));
	forward($_SERVER['HTTP_REFERER']);
?>