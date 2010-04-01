<?php

// This used to be an action, but as it is sent in an email message
// with unknown response time, it cannot have an action time stamp
// and so is now just a page

require_once(dirname(dirname(__FILE__)).'/models/model.php');

set_context('openid');
$code = get_input('code');
if (empty($code)) {
	register_error(elgg_echo("openid_client:missing_confirmation_code"));
} elseif ($code{0} == 'a') {
	// request to activate an account
	if (!$details = openid_client_get_invitation($code)) {
		register_error(elgg_echo("openid_client:invalid_code_error"));
	} else {
		// OK, everything seems to be in order, so activate this user
		$user = get_user($details->new_owner);
		$user->email = $details->email;
		$user->name = $details->name;
		$user->active = 'yes';
		$user->save();
		system_message(sprintf(elgg_echo("openid_client:account_created"), $details->username));
		openid_client_remove_invitation($code);
	}

} elseif ($code{0} == 'c') {	
	// request to change an email address
	if (!$details = openid_client_get_invitation($code)) {
		register_error(elgg_echo("openid_client:invalid_code_error"));
	} else {
		// OK, everything seems to be in order, so change the email address
		$user = get_user($details->new_owner);
		$user->email = $details->email;
		$user->save();
		system_message(sprintf(elgg_echo('openid_client:email_changed'),$details->email));
		openid_client_remove_invitation($code);
	}
}	

if(isset($body) && $body) {
    page_draw(elgg_echo('openid_client:confirmation_title'),$body);
} else {
    forward();
}
