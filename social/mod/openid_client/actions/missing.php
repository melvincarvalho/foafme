<?php
require_once(dirname(dirname(__FILE__)).'/models/model.php');

global $CONFIG;
set_context('openid');
$code = get_input('openid_code');
$name = trim(get_input('name'));
$email = trim(get_input('email'));
$error = false;
if (!$name) {
	register_error(elgg_echo("openid_client:missing_name_error"));
	$error = true;
}
if (!$email || !validate_email_address($email)) {
    register_error(elgg_echo("openid_client:invalid_email_error"));
	$error = true;
}

if (empty($code) || !($details = openid_client_get_invitation($code))) {
	register_error(elgg_echo("openid_client:invalid_code_error"));
	$error = true;
}

if (!$error) {
	// looks good	
	
	if ($code{0} == 'a') {
		// need to confirm first
		$details->email = $email;
		$details->name = $name;
		openid_client_send_activate_confirmation_message($details);
		system_message(sprintf(elgg_echo("openid_client:activate_confirmation"),$email));
	} elseif ($code{0} == 'n') {
		//activate and login
		$user = get_user($details->owner);
		$user->email = $email;
		$user->name = $name;
		$user->active = 'yes';
		$user->save();
		system_message(sprintf(elgg_echo("openid_client:created_openid_account"),$email, $name));
        login($user);
	}
	forward();
} elseif ($details) {
	// regenerate the form
	$user = get_user($details->owner);
	$openid_url = $user->alias;
	$email_confirmation = openid_client_check_email_confirmation($openid_url);
	$body = openid_client_generate_missing_data_form($openid_url,$email,$fullname,$email_confirmation,$code);	
	page_draw(elgg_echo('openid_client:information_title'),$body);
} else {
	// bad code - not much to do but inform user
	forward();
}
