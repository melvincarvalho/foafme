<?php

$fc = fbconnect_client();
$fbuid = $fc->get_loggedin_user();
if ($fbuid) {    
	$entities = get_entities_from_metadata('facebook_uid', $fbuid, 'user', 'facebook');
	$do_login = false;
	$duplicate_acccount = false;

	if (!$entities || $entities[0]->active == 'no') {
		if (!$entities) {
			$entities = get_entities_from_metadata('facebook_uid', $fbuid, 'user');
			if (!$entities) {
				// this account does not exist, so create it
				
				// check to make sure that a non-Facebook account with the same user name
				// does not already exist
				$username = 'facebook_'.$fbuid;
				if(get_user_by_username($username)) {
						$duplicate_account = true;			
						register_error(sprintf(elgg_echo("fbconnect:account_duplicate"),$username));
				}
				if (!$duplicate_account) {								    
			        $user = new ElggUser();
				    $user->email = '';
				    $user->access_id = 2;
				    $user->subtype = 'facebook';
				    $user->username = $username;
				    $user->facebook_uid = $fbuid;
				    $user->facebook_controlled_profile = 'yes';
				    			
				    if ($user->save()) {
				    	$new_account = true;
					    $do_login = true;
					    // need to keep track of subtype because getSubtype does not work
					    // for newly created users in Elgg 1.5
					    $subtype = 'facebook';
				    } else {
			    	    register_error(elgg_echo("fbconnect:account_create"));
				    }
				} else {
					
				}
			} else {
				$user = $entities[0];
				
				// account is using a Facebook slave login, check to see if this user has been banned
			
			    if (isset($user->banned) && $user->banned == 'yes') { // this needs to change.
			        register_error(elgg_echo("fbconnect:banned"));
			    } else {
				    $do_login = true;
				    $new_account = false;
				    $subtype = 'elgg';
			    }				
			}
		} else {
			// this is an inactive account
			register_error(elgg_echo("fbconnect:inactive"));
		}
		
	} else {		
		$user = $entities[0];
		// account is active, check to see if this user has been banned
	    if (isset($user->banned) && $user->banned == 'yes') { // this needs to change.
	        register_error(elgg_echo("fbconnect:banned"));
	    } else {
		    $do_login = true;
		    $new_account = false;
		    $subtype = 'facebook';
	    }		    
	}

	if ($do_login) {				
		$rememberme = get_input('remember',0);
		if (!empty($rememberme)) {
			login($user,true);
		} else {
			login($user);
		}
		
		if (($subtype == 'facebook') && ($user->facebook_controlled_profile != 'no')) {
			// update from Facebook at each login
			fbconnect_update_profile($user);
		}
		
		if ($new_account) {
			$fbprofile = fbconnect_get_info_from_fb($fbuid,'status');
			if ($fbprofile) {
				thewire_save_post($fbprofile['status']['message'], ACCESS_PUBLIC, 0, 'facebook');
			}
		}
	}
} else {
	register_error(elgg_echo("fbconnect:fail"));
}

forward();

exit;

?>