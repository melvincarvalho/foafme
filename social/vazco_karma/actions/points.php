<?php 
	//action for admin only
	admin_gatekeeper();
	
	$points = get_input('points','');
	$user_guid= get_input('user_guid','');
	
	if ($points != '' && $user_guid != ''){
		$user = get_entity($user_guid);
		$karma = new vazco_karma();
		$karma->givePoints($user, $points);
		system_message(sprintf(elgg_echo('vazco_karma:pointsgiven'),$user->username,$points));
		forward($_SERVER['HTTP_REFERER']);
	}
	else{
		register_error(elgg_echo('vazco_karma:nopointsuser'));
		forward($_SERVER['HTTP_REFERER']);
	}
	
?>