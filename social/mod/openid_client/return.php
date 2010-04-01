<?php

/**
 * Callback for return_to url redirection. The identity server will
 * redirect back to this handler with the results of the
 * authentication attempt.
 * 
 * Note: the Elgg action system strips off the query string and is incompatible with
 * the JanRain OpenID library, so we need to keep this as an ordinary PHP file
 * for now.
 * 
 */

require_once(dirname(dirname(dirname(__FILE__))).'/engine/start.php');
require_once(dirname(__FILE__).'/models/model.php');

global $CONFIG;

set_context('openid');
$store = new OpenID_ElggStore();
$consumer = new Auth_OpenID_Consumer($store);

$return_url = $CONFIG->wwwroot.'mod/openid_client/return.php';

// TODO - handle passthru_url properly
// $dest = $query['destination'];
$response = $consumer->complete($return_url);

if ($response->status == Auth_OpenID_CANCEL) {
    register_error(elgg_echo("openid_client:authentication_cancelled"));
} else if ($response->status != Auth_OpenID_SUCCESS) {
    register_error(sprintf(elgg_echo("openid_client:authentication_failed"),$response->status,$response->message) );
} else { // SUCCESS.
	$openid_url = $response->getDisplayIdentifier();
	
    // Look for sreg data.
    $sreg_resp = Auth_OpenID_SRegResponse::fromSuccessResponse($response);
    $sreg = $sreg_resp->contents();
	if ($sreg) {
        $email = trim($sreg['email']);
        $fullname = trim($sreg['fullname']);
        //print ($email.' '.$fullname);
    }
    
    $entities = get_entities_from_metadata('alias', $openid_url, 'user', 'openid');

	if (!$entities || $entities[0]->active == 'no') {
		if (!$entities) {
			// this account does not exist
	    	if (!$email || !validate_email_address($email)) {
    	    	// there is a problem with the email provided by the profile exchange, so generate a form to collect it
				if ($user = openid_client_create_openid_user($openid_url,$email, $fullname, true)) {
		    		$details = openid_client_create_invitation('a',$openid_url,$user->getGUID(),$email,$fullname);
	    			$body = openid_client_generate_missing_data_form($openid_url,'',$fullname,true,$details);
				}
				$missing_data = true;
			} elseif (!$fullname) {
    			// the name is missing
				$email_confirmation = openid_client_check_email_confirmation($openid_url);
				if ($email_confirmation) {
					$prefix = 'a';
				} else {
					$prefix = 'n';
				}
				// create the account
				if ($user = openid_client_create_openid_user($openid_url,$email, $fullname, $email_confirmation)) {
					$details = openid_client_create_invitation($prefix,$openid_url,$user->getGUID(),$email,$fullname);
					$body = openid_client_generate_missing_data_form($openid_url,$email,'',$email_confirmation,$details);
				}
				$missing_data = true;
			} else {
				// email address and name look good 
				
				$login = false;			
							    
			    // create a new account
				   
			   	$email_confirmation = openid_client_check_email_confirmation($openid_url);		    					    
			    							
				$user = openid_client_create_openid_user($openid_url,$email, $fullname, $email_confirmation);
				$missing_data = false;
			}
		} else {
			// this is an inactive account
			$user = $entities[0];
			
			// need to figure out why the account is inactive
			
			$email_confirmation = openid_client_check_email_confirmation($openid_url);
			
			if ($user->email && $user->name) {
    			$missing_data = false;
    			// no missing information
			    if (!$email_confirmation) {
    			    // OK, this is weird - no email confirmation required and all the information has been supplied
    			    // this should not happen, so just go ahead and activate the account
    			    $user->active = 'yes';
    			    $user->save();
			    }
		    } else {    		    
    		    // missing information
    		    $missing_data = true;
    		    // does this person have an existing magic code?
    		    if ($details = openid_client_get_invitation_by_username($user->alias)) {
        		    $body = openid_client_generate_missing_data_form($openid_url,$user->email,$user->name,$email_confirmation,$details);
    		    } else {
        		    // create a new magic code
        		    $details = openid_client_create_invitation('a',$openid_url,$user->getGUID(),$user->email,$user->name);
	    			$body = openid_client_generate_missing_data_form($openid_url,$user->email,$user->name,$email_confirmation,$details);
    			}   
		    }
		}
		if ($user && !$missing_data) {
				
			if ($email_confirmation) {
				$i_code = openid_client_create_invitation('a',$openid_url,$user->guid,$email,$fullname);
				openid_client_send_activate_confirmation_message($i_code);
				system_message(sprintf(elgg_echo("openid_client:activate_confirmation"), $email));
			} else {
				system_message(sprintf(elgg_echo("openid_client:created_openid_account"),$email, $fullname));
				$login = true;
			}
		}
				
	} else {
    	
    	$user = $entities[0];
		
		// account is active, check to see if this user has been banned
	
	    if (isset($user->banned) && $user->banned == 'yes') { // this needs to change.
	        register_error(elgg_echo("openid_client:banned"));
	    } else {
		    // user has not been banned
		    // check to see if email address has changed
		    if ($email && $email != $user->email && validate_email_address($email)) {
			    // the email on the OpenID server is not the same as the email registered on this local client system
			    $email_confirmation = openid_client_check_email_confirmation($openid_url);
			    if ($CONFIG->openid_client_always_sync == 'yes') {
				    // this client always forces client/server data syncs
				    if ($fullname) {
				    	$user->name = $fullname;
			    	}
				    if ($email_confirmation) {
					    // don't let this user in until the email address change is confirmed
					    $login = false;
					    $i_code = openid_client_create_invitation('c',$openid_url,$user->guid,$email,$fullname);
					    openid_client_send_change_confirmation_message($i_code);
					    system_message(sprintf(elgg_echo("openid_client:change_confirmation"), $email));
					} else {
						$login = true;
						if (openid_client_get_user_by_email($email)) {
							register_error(elgg_echo("openid_client:email_in_use"),$email);
						} else {
    						$user->email = $email;
							system_message(sprintf(elgg_echo("openid_client:email_updated"),$email));
						}
					}
				} else {
					$login = true;
					if (!$store->getNoSyncStatus($user)) {
						// the following conditions are true:
						// the email address has changed on the server,
						// this client does not *require* syncing with the server,
						// but this user has not turned off syncing
						// therefore the user needs to be offered the chance to sync his or her data
						$body = openid_client_generate_sync_form($email,$fullname,$user,$email_confirmation);
					}
				}
			} elseif ($fullname && $fullname != $user->name) {
				// the fullname on the OpenID server is not the same as the name registered on this local client system
				$login = true;
				if ($CONFIG->openid_client_always_sync == 'yes') {
				    // this client always forces client/server data syncs
				    $user->name = $fullname;
				} else {
					if (!$store->getNoSyncStatus($user)) {
				    	// the following conditions are true:
						// the fullname has changed on the server,
						// this client does not *require* syncing with the server,
						// but this user has not turned off syncing
						// therefore the user needs to be offered the chance to sync his or her data
						$body = openid_client_generate_sync_form($email,$fullname,$user,false);
					}
				}
			} else {
				// nothing has changed or the data is null so let this person in
				$login = true;
			}
		}							    
	}
    
    if ($login) {
		
		$rememberme = get_input('remember',0);
		if (!empty($rememberme)) {
			login($user,true);
		} else {
    		login($user);
		}
	}
} 

if(isset($body) && $body) {
    
    page_draw(elgg_echo('openid_client:information_title'),$body);

} else {
	forward();
}
