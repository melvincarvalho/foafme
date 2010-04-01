<?php
/**
 * An Elgg 1.x compatible store implementation 
 */
 
require_once (dirname(__FILE__).'/Auth/OpenID.php');
require_once (dirname(__FILE__).'/Auth/OpenID/Interface.php');
require_once (dirname(__FILE__).'/Auth/OpenID/Consumer.php');
require_once (dirname(__FILE__).'/Auth/OpenID/HMACSHA1.php');
require_once (dirname(__FILE__).'/Auth/OpenID/Nonce.php');
require_once (dirname(__FILE__).'/Auth/OpenID/SReg.php');

 /**
 * Require base class for creating a new interface.
 */
 

class OpenID_ElggStore extends Auth_OpenID_OpenIDStore {

    function resetAssociations () {
        openid_client_delete_entities('object', 'openid_client::association');
    }
    function resetNonces () {
        openid_client_delete_entities('object', 'openid_client::nonce');
    }
    function getAssociation ($server_url, $handle = null) {
        if (isset($handle)) {
            $meta_array = array(
                        'server_url'    => $server_url,
                        'handle'        => $handle
            );
            $assocs = get_entities_from_metadata_multi($meta_array, 'object', 'openid_client::association');
        } else {
            $assocs = get_entities_from_metadata('server_url', $server_url, 'object','openid_client::association');
        }
        
        if (!$assocs || (count($assocs) == 0)) {
            return null;
        } else {
            $associations = array();

            foreach ($assocs as $assoc_row) {
                $assoc = new Auth_OpenID_Association($assoc_row->handle,
                                                     base64_decode($assoc_row->secret),
                                                     $assoc_row->issued,
                                                     $assoc_row->lifetime,
                                                     $assoc_row->assoc_type);

                if ($assoc->getExpiresIn() == 0) {
                    OpenID_ElggStore::removeAssociation($server_url, $assoc->handle);
                } else {
                    $associations[] = array($assoc->issued, $assoc);
                }
            }

            if ($associations) {
                $issued = array();
                $assocs = array();
                foreach ($associations as $key => $assoc) {
                    $issued[$key] = $assoc[0];
                    $assocs[$key] = $assoc[1];
                }

                array_multisort($issued, SORT_DESC, $assocs, SORT_DESC,
                                $associations);

                // return the most recently issued one.
                list($issued, $assoc) = $associations[0];
                return $assoc;
            } else {
                return null;
            }
        }
    }
    
    function removeAssociation ($server_url, $handle) {
        if (isset($handle)) {
            $meta_array = array(
                        'server_url'    => $server_url,
                        'handle'        => $handle
            );
            $entities = get_entities_from_metadata_multi($meta_array, 'object', 'openid_client::association');
        } else {
            $entities = get_entities_from_metadata('server_url', $server_url, 'object','openid_client::association');
        }
        foreach ($entities as $entity) {
			$entity->delete();
		}
	}
    function reset () {
        OpenID_ElggStore::resetAssociations ();
        OpenID_ElggStore::resetNonces ();
    }
        
    function storeAssociation ($server_url, $association) {
        
        // Initialise a new ElggObject
		$association_obj = new ElggObject();
		
		$association_obj->subtype = 'openid_client::association';
		$association_obj->owner_guid = 0;
		$association_obj->container_guid = 0;
		$association_obj->title = 'association';
		$association_obj->access_id = 2;		
		
		if ($association_obj->save()) {		
    		$association_obj->server_url = $server_url;
    		$association_obj->handle = $association->handle;
            $association_obj->secret = base64_encode($association->secret);
            $association_obj->issued = $association->issued;
            $association_obj->lifetime = $association->lifetime;
            $association_obj->assoc_type = $association->assoc_type;
    		return true;
		} else {
    		return false;
		}
	}
		
    function useNonce ( $server_url,  $timestamp,  $salt) {
        global $Auth_OpenID_SKEW;

        if ( abs($timestamp - time()) > $Auth_OpenID_SKEW ) {
            return false;
        }
        
        // check to see if the nonce already exists
        
        $meta_array = array(
                        'server_url'    => $server_url,
                        'timestamp'     => $timestamp,
                        'salt'          => $salt
        );
        
        $entities = get_entities_from_metadata_multi($meta_array, 'object', 'openid_client::nonce');
        
        if ($entities) {
            // bad - this nonce is already in use
            return false;
        } else {        
            // Initialise a new ElggObject
    		$nonce_obj = new ElggObject();
    		
    		$nonce_obj->subtype = 'openid_client::nonce';
    		$nonce_obj->owner_guid = 0;
    		$nonce_obj->container_guid = 0;
    		$nonce_obj->title = 'nonce';
    		$nonce_obj->access_id = 2;
    		
    		if ($nonce_obj->save()) {
        		$nonce_obj->server_url = $server_url;
        		$nonce_obj->timestamp = $timestamp;
        		$nonce_obj->salt = $salt;
        		return true;
    		} else {
        		return false;
    		}
		}
	}
	
	function getNoSyncStatus($user) {
    	if (isset($user) && isset($user->openid_client_nosync_status)) {
        	return $user->openid_client_nosync_status;
    	} else {
        	return false;
    	}
	}
	
	function addNoSyncStatus($user) {
    	$user->openid_client_nosync_status = 1;
	}    	
}

function openid_client_create_invitation($prefix,$username,$ident,$email,$fullname) {
    
    $invite = new ElggObject();
		
	$invite->subtype = 'invitation';
	$invite->owner_guid = 0;
	$invite->container_guid = 0;
	$invite->title = 'invitation';
	$invite->access_id = 2;
	if ($invite->save()) {
    	$invite->new_owner = $ident;
    	$invite->name = $fullname;
    	$invite->email = $email;
    	$invite->username = $username;	
    	$invite->code = $prefix . substr(base_convert(md5(time() . $username), 16, 36), 0, 7);
    	$invite->added = time();
    	return $invite;
	} else {
    	return null;
	}
}

function openid_client_get_invitation($code) {
    $invitations = get_entities_from_metadata('code', $code, 'object','invitation');
    if ($invitations) {
        return $invitations[0];
    } else {
        return null;
    }    
}

function openid_client_remove_invitation($code) {
    $invitations = get_entities_from_metadata('code', $code, 'object','invitation');
    if ($invitations) {
        foreach ($invitations as $invitation) {
			$invitation->delete();
		}
    }    
}

function openid_client_get_invitation_by_username($username) {
    $invitations = get_entities_from_metadata('username', $username, 'object','invitation');
    if ($invitations) {
        return $invitations[0];
    } else {
        return null;
    }    
}

function openid_client_send_activate_confirmation_message($details) {
    
	global $CONFIG;
	
	// not sure where these should really come from
	$site = get_entity($CONFIG->site_guid);
	$from_name = $site->name;
	$from_email = $site->email;
	
	$subject = sprintf(elgg_echo('openid_client:activate_confirmation_subject'),$CONFIG->sitename);
	$url = $CONFIG->wwwroot . "pg/openid_client/confirm?code=" . $details->code;

	$message = wordwrap(sprintf(elgg_echo('openid_client:activate_confirmation_body'),$details->name,$CONFIG->sitename,$url, $CONFIG->sitename));
	openid_client_email_user($details->name, $details->email, $from_name, $from_email, $subject,$message);
}

function openid_client_send_change_confirmation_message($details) {
	global $CONFIG;
	
	// not sure where these should really come from
	$site = get_entity($CONFIG->site_guid);
	$from_name = $site->name;
	$from_email = $site->email;
	
	$subject = sprintf(elgg_echo('openid_client:change_confirmation_subject'),$from_name);
	$url = $CONFIG->wwwroot . "pg/openid_client/confirm?code=" . $details->code;
	$message = wordwrap(sprintf(elgg_echo('openid_client:change_confirmation_body'),
	    $details->name,$CONFIG->sitename,$url, $CONFIG->sitename));
	openid_client_email_user($details->name, $details->email, $from_name, $from_email, $subject,$message);
}

$emailLabel = elgg_echo('openid_client:email_label');
$nameLabel = elgg_echo('openid_client:name_label');
$submitLabel = elgg_echo('openid_client:submit_label');
$cancelLabel = elgg_echo('openid_client:cancel_label');

function openid_client_generate_sync_form($new_email,$new_name, $user, $email_confirmation) {
	
	return elgg_view_layout('one_column',elgg_view_title(elgg_echo('openid_client:sync_title')) . elgg_view("openid_client/forms/sync", 
	    array(
	        'userid'                => $user->getGUID(),
	        'new_email'             => $new_email,
	        'new_name'              => $new_name,
	        'email_confirmation'    => $email_confirmation
        )));	
}


function openid_client_generate_missing_data_form($openid_url,$email,$fullname,$email_confirmation,$details) {

	return elgg_view_layout('one_column',elgg_view_title(elgg_echo('openid_client:missing_title')) . elgg_view("openid_client/forms/missing", 
	    array(
	        'openid_url'            => $openid_url,
	        'email'                 => $email,
	        'fullname'              => $fullname,
	        'email_confirmation'    => $email_confirmation,
	        'openid_code'           => $details->code
        )));
}

function openid_client_check_email_confirmation($openid_url) {
	global $CONFIG;
	
	$done = false;	
	$email_confirmation = false;
	$greenlist = get_plugin_setting('greenlist','openid_client');
	$yellowlist = get_plugin_setting('yellowlist','openid_client');
	
	if ($greenlist) {		
		foreach (explode("\n",$greenlist) as $entry ) {
			if (fnmatch($entry,$openid_url)) {
				$email_confirmation = false;
				$done = true;
				break;
			}
		}
	}
	if (!$done && $yellowlist) {		
		foreach (explode("\n",$yellowlist) as $entry ) {
			if (fnmatch($entry,$openid_url)) {
				$email_confirmation = true;
				break;
			}
		}
	}
	return $email_confirmation;
}

//TODO: replace this function with the openid_client_register_user

function openid_client_create_openid_user($openid_url,$email, $fullname, $email_confirmation) {
	
	global $messages;
	
	if ($email && get_user_by_email($email)) {
		register_error(sprintf(elgg_echo('openid_client:create_email_in_use'),$email));
		return null;
	} else {
					    
	    $user = new ElggUser();
		$user->email = $email;
		$user->name = $fullname;
		$user->access_id = ACCESS_PUBLIC;
		$user->subtype = 'openid';

		$user->username = openid_client_randomString(8);
		
		if ($user->save()) {    				
    		$id = $user->getGUID();    		
    		$user = get_user($id);    			
    		$user->alias = $openid_url;    
    		$user->username = "openid_".$id;
    		
    		if ($email_confirmation) {
    			$user->active = 'no';
    		} else {
    			$user->active = 'yes';
    		}
    		
    		$user->save();
		
		    return $user;
	    } else {
    	    register_error(elgg_echo('openid_client:user_creation_failed'));
    	    forward();
    	    return null;
	    }
	}						
}

/**
 * Registers a user, returning false if the username already exists
 *
 * @param string $username The username of the new user
 * @param string $password The password
 * @param string $name The user's display name
 * @param string $email Their email address
 * @param bool $allow_multiple_emails Allow the same email address to be registered multiple times?
 * @param int $friend_guid Optionally, GUID of a user this user will friend once fully registered
 * @return int|false The new user's GUID; false on failure
 * 
 * Note: there is no way to pass the subtype in or to to change it afterwards,
 * so this code is copied here to create users with subtype "openid"
 * 
 */
function openid_client_register_user($username, $password, $name, $email, $allow_multiple_emails = false, $friend_guid = 0, $invitecode = '') {
	// Load the configuration
	global $CONFIG;

	$username = trim($username);
	// no need to trim password.
	$password = $password;
	$name = trim($name);
	$email = trim($email);

	// A little sanity checking
	if (empty($username)
	|| empty($password)
	|| empty($name)
	|| empty($email)) {
		return false;
	}

	// See if it exists and is disabled
	$access_status = access_get_show_hidden_status();
	access_show_hidden_entities(true);

	// Validate email address
	if (!validate_email_address($email)) {
		throw new RegistrationException(elgg_echo('registration:emailnotvalid'));
	}

	// Validate password
	if (!validate_password($password)) {
		throw new RegistrationException(elgg_echo('registration:passwordnotvalid'));
	}

	// Validate the username
	if (!validate_username($username)) {
		throw new RegistrationException(elgg_echo('registration:usernamenotvalid'));
	}

	// Check to see if $username exists already
	if ($user = get_user_by_username($username)) {
		//return false;
		throw new RegistrationException(elgg_echo('registration:userexists'));
	}

	// If we're not allowed multiple emails then see if this address has been used before
	if ((!$allow_multiple_emails) && (get_user_by_email($email))) {
		throw new RegistrationException(elgg_echo('registration:dupeemail'));
	}

	access_show_hidden_entities($access_status);

	// Check to see if we've registered the first admin yet.
	// If not, this is the first admin user!
	$have_admin = datalist_get('admin_registered');

	// Otherwise ...
	$user = new ElggUser();
	$user->username = $username;
	$user->email = $email;
	$user->name = $name;
	$user->access_id = ACCESS_PUBLIC;
	$user->salt = generate_random_cleartext_password(); // Note salt generated before password!
	$user->password = generate_user_password($user, $password);
	$user->owner_guid = 0; // Users aren't owned by anyone, even if they are admin created.
	$user->container_guid = 0; // Users aren't contained by anyone, even if they are admin created.
	$user->subtype = 'openid';
	$user->save();

	// Turn on email notifications by default
	set_user_notification_setting($user->getGUID(), 'email', true);

	return $user->getGUID();
}

/**
 * Send a notification via email.
 * 
 * TODO: figure out how to replace this (if possible) with notify_user
 * 
 */
function openid_client_email_user($to_name, $to_email, $from_name, $from_email, $subject, $message)
{	
    $to = "$to_name <$to_email>";
	
	$headers = "From: $from_name <$from_email>\r\n";
			
	return mail($to, $subject, $message, $headers);
}   


function openid_client_randomString($length)
{
    // Generate random 32 character string
    $string = md5(time());

    // Position limiting
    $highest_startpoint = 32-$length;

    // Take a random starting point in the randomly
    // generated string, not going any higher then $highest_startpoint
    $randomString = substr($string,rand(0,$highest_startpoint),$length);

    return $randomString;

}

function openid_client_delete_entities($type, $subtype = "", $owner_guid = 0) {
	// sanity check to make sure "type" is defined
	if ($type) {
		$entities = get_entities($type, $subtype, $owner_guid, "time_created desc", 0);
		
		foreach ($entities as $entity) {
			$entity->delete();
		}
		
		return true;
	}
}

function openid_client_authenticate_user_login($username) {
	
	global $CONFIG;
	
	// match username against green, yellow and red lists
	
	$greenlist = get_plugin_setting('greenlist','openid_client');
	$yellowlist = get_plugin_setting('yellowlist','openid_client');
	$redlist = get_plugin_setting('redlist','openid_client');
	
	$passed = true;
	
	if ($greenlist || $yellowlist) {
		$passed = false;
		$yesarray = array_merge(explode("\n",$greenlist),explode("\n",$yellowlist));
		foreach ( $yesarray as $entry ) {
			if (fnmatch($entry,$username)) {
				$passed = true;
				break;
			}
		}
	}
	
	if ($passed) {
		if ($redlist) {		
			foreach (explode("\n",$redlist) as $entry ) {
				if (fnmatch($entry,$username)) {
					$passed = false;
					break;
				}
			}
		}
	}
	
	if (!$passed) {
    	
    	register_error(elgg_echo("openid_client:disallowed"));
		return false;
	}				

    $identity_url = $username;

    $consumer = new Auth_OpenID_Consumer(new OpenID_ElggStore());

    $auth_request = $consumer->begin($identity_url);

	if ($auth_request) {
        $trust_root = $CONFIG->wwwroot;
        
        $return_url = $CONFIG->wwwroot.'mod/openid_client/return.php';

        // Add simple registration arguments.
        
        $sreg_request = Auth_OpenID_SRegRequest::build(
                                     // Optional
                                     array('fullname', 'email'));
        if ($sreg_request) {
            $auth_request->addExtension($sreg_request);
        }
        
        // Store the token for this authentication so we can verify the
        // response.
    
        // For OpenID 1, send a redirect.  For OpenID 2, use a Javascript
        // form to send a POST request to the server.
        
        if ($auth_request->shouldSendRedirect()) {            
            $redirect_url = $auth_request->redirectURL($trust_root,
                                                       $return_url);
    
            // If the redirect URL can't be built, display an error
            // message.
            if (Auth_OpenID::isFailure($redirect_url)) {
                register_error(sprintf(elgg_echo("openid_client:redirect_error"), $redirect_url->message));
            } else {
                // Send redirect.
                forward($redirect_url);
            }
        } else {
            // Generate form markup and render it.
            $form_id = 'openid_message';
            $form_html = $auth_request->formMarkup($trust_root, $return_url,
                                                   false, array('id' => $form_id));
    
            // Display an error if the form markup couldn't be generated;
            // otherwise, render the HTML.
            if (Auth_OpenID::isFailure($form_html)) {
                 register_error(sprintf(elgg_echo("openid_client:redirect_error"), $form_html->message));
            } else {
                $page_contents = array(
                   "<html><head><title>",
                   "OpenID transaction in progress",
                   "</title></head>",
                   "<body onload='document.getElementById(\"".$form_id."\").submit()'>",
                   $form_html,
                   "</body></html>");
    
                print implode("\n", $page_contents);
                
                exit;
            }
        }   
        
    } else {
        register_error(sprintf(elgg_echo('openid_client:authentication_failure'),$username));
    }

	return false;

}

function openid_client_get_security_bit() {
	$ts = time();
	$token = generate_action_token($ts);
	return "__elgg_token=$token&__elgg_ts=$ts";
}

function openid_client_handle_login() {
	global $CONFIG;

	$passthru_url = get_input('passthru_url');
	
	if ($passthru_url) {
		$redirect_url = $passthru_url;
	} else {
		$redirect_url = $CONFIG->wwwroot . "index.php";
	}
	
	if (isloggedin()) {
		// if we're already logged in, say so and do nothing
		register_error(elgg_echo("openid_client:already_loggedin"));
	    forward();
	} else {
		set_context('openid');
		$username = trim(get_input('username'));
		$externalservice = get_input('externalservice');
		
		if (!empty($externalservice)) {
	        switch($externalservice) {
	            
	            case "livejournal":     $username = "http://" . $username . ".livejournal.com";
	                                    break;
	            case "aim":             $username = "http://openid.aol.com/" . $username;
	                                    break;
	            case "vox":             $username = "http://" . $username . ".vox.com";
	                                    break;
	            case "wordpress":       $username = "http://" . $username . ".wordpress.com";
	                                    break;
	            case "pip":             $username = "http://" . $username . ".pip.verisignlabs.com";
	                                    break;
	            
	        }
	    }
		
		if (!empty($username)) {
			
			// normalise username
			
			if (strpos($username,'.') === false) {
				// appears to be a bare account name, so try for a default server
				$default_server = get_plugin_setting('default_server','openid_client');
				if ($default_server) {
					$username = sprintf($default_server,$username);
				}
			} elseif ((strpos($username,'http://') === false) && (strpos($username,'https://') === false)) {
				// allow for OpenID URLs that are missing the "http://" prefix
				$username = 'http://'.$username;
			}
		    
			//TO DO: Find a replacement for the code below
		    // Remove any malformed entries
		    //    delete_records('users', 'alias', $username, 'email', '');
		    
		    // try logging in
			$ok = openid_client_authenticate_user_login($username);
		    if ($ok) {
	    	    system_message(elgg_echo("openid_client:login_success"));
		    } 
	    	} else {
	        	register_error(elgg_echo("openid_client:login_failure"));
	    	}
	}
	
	forward($redirect_url);
	
}

if (!function_exists('fnmatch')) {
function fnmatch($pattern, $string) {
   for ($op = 0, $npattern = '', $n = 0, $l = strlen($pattern); $n < $l; $n++) {
       switch ($c = $pattern[$n]) {
           case '\\':
               $npattern .= '\\' . @$pattern[++$n];
           break;
           case '.': case '+': case '^': case '$': case '(': case ')': case '{': case '}': case '=': case '!': case '<': case '>': case '|':
               $npattern .= '\\' . $c;
           break;
           case '?': case '*':
               $npattern .= '.' . $c;
           break;
           case '[': case ']': default:
               $npattern .= $c;
               if ($c == '[') {
                   $op++;
               } else if ($c == ']') {
                   if ($op == 0) return false;
                   $op--;
               }
           break;
       }
   }

   if ($op != 0) return false;

   return preg_match('/' . $npattern . '/i', $string);
}
}

?>