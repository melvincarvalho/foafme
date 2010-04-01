<?php
require_once(dirname(dirname(__FILE__)).'/models/model.php');

set_context('openid');
global $CONFIG;

if (isloggedin()) {
 
	$userid = get_loggedin_userid();
	$user = get_user($userid);
	$namechange = get_input('namechange');
	$emailchange = get_input('emailchange');
	$nosync = get_input('nosync');
	
	if ($namechange) {
		$name = get_input('new_name');
		$user->name = $name;
		system_message(sprintf(elgg_echo("openid_client:name_updated"),$name));
	}
			
	if ($emailchange) {
		$i_code = get_input('i_code');
		if (empty($i_code)) {
			$new_email = get_input('new_email');
			// this is an email address change request from a yellow OpenID, so the
			// email address change must be confirmed with an email message
			if (get_user_by_email($email)) {
				register_error(sprintf(elgg_echo("openid_client:email_in_use"),$email));
			} else {
				$details = openid_client_create_invitation('c',$user->username,$userid,$new_email,$user->name);
				openid_client_send_change_confirmation_message($details);
				system_message(sprintf(elgg_echo("openid_client:change_confirmation"), $email));
			}
		} elseif (!($details = openid_client_get_invitation($i_code))) {
			register_error(elgg_echo("openid_client:invalid_code_error"));
		} else {
			// this is an email address change request from a green OpenID, so the
			// email address change does not need to be confirmed
			
			$email = $details->email;
			$ident = $details->owner;
			if (get_user_by_email($email)) {
				register_error(sprintf(elgg_echo("openid_client:email_in_use"),$email));
			} else {
				$user->email;
				system_message(sprintf(elgg_echo("openid_client:email_updated"),$email));
			}
		}
	}
	
	if ($nosync) {
		$store = new OpenID_ElggStore();
		$store->addNoSyncStatus($user);
	}
}

forward();
