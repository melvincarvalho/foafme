<?php

	$english = array(	
			
		'openid_client_login_title'                     => "Log in using OpenID",
		'openid_client_login_service'                   => "Service",
		'openid_client_logon'                           => "Logon",
		'openid_client_go'                              => "Go",
		'openid_client_remember_login'                  => "Remember login",
		'openid_client:already_loggedin'                => "You are already logged in.",
		'openid_client:login_success'                   => "You have been logged on.",
		'openid_client:login_failure'                   => "The username was not specified. The system could not log you in.",
		'openid_client:disallowed'                      => "This site does not allow the OpenID that you entered. "
		        ."Please try another OpenID or contact the site administrator for more information.",
		'openid_client:redirect_error'                  => "Could not redirect to server: %s",
		'openid_client:authentication_failure'          => "OpenID authentication failed: %s is not a valid OpenID URL.",
		'openid_client:authentication_cancelled'        => "OpenID authentication cancelled.",
		'openid_client:authentication_failed'           => "OpenID authentication failed (status: %s, message: %s )",
		'openid_client:banned'                          => "You have been banned from the system!",
		'openid_client:email_in_use'                    => "Cannot change your email address to %s because it is already in use.",
		'openid_client:email_updated'                   => "Your email address has been updated to %s",
		'openid_client:information_title'               => "OpenID information",
		'openid_client:activate_confirmation'           => "A confirmation message has been sent to %s ."
		        ." Please click on the link in that message to activate your account."
		        ." You will then be able to login using the OpenID you have supplied.",
        'openid_client:change_confirmation'             => "Your email address has changed. A confirmation message has been sent to"
                ." your new address at %s . Please click on the link in that message to confirm this new email address. ",
        'openid_client:activate_confirmation_subject'   => "%s account verification",
        'openid_client:activate_confirmation_body'      => "Dear %s,\n\nThank you for registering with %s.\n\n"
            ."To complete your registration, visit the following URL:\n\n\t%s\n\nwithin seven days.\n\nRegards,\n\nThe %s team.",
        'openid_client:change_confirmation_subject'     => "%s email change",
        'openid_client:change_confirmation_body'        => "Dear %s,\n\nWe have received a request to change your email address"
            ." registered with %s.\n\nTo change your email address to {%s}, visit the following URL:\n\n\t%s\n\nwithin seven days."
            ."\n\nRegards,\n\nThe %s team.",				
	    'openid_client:email_label'                     => "Email:",
	    'openid_client:name_label'                      => "Name:",
	    'openid_client:submit_label'                    => "Submit",
	    'openid_client:cancel_label'                    => "Cancel",
	    'openid_client:nosync_label'                    => "Do not notify me again if the data on this system is not the same"
	        ." as the data on my OpenID server.",
	    'openid_client:sync_instructions'               => "The information on your Open ID server is not the same as on this system."
	        ." Tick the check boxes next to the information you would like to update (if any) and press submit.",
	    'openid_client:missing_title'					=> "Please provide missing information",
	    'openid_client:sync_title'						=> "Synchronise your information",
	    'openid_client:missing_email'                   => "a valid email address",
	    'openid_client:missing_name'                    => "your full name",
	    'openid_client:and'                             => "and",
	    'openid_client:missing_info_instructions'       => "In order to create an account on this site you need to supply %s."
	        ." Please enter this information below.",
	    'openid_client:create_email_in_use'             => "Cannot create an account with the email address %s because it is already in use.",
	    'openid_client:missing_name_error'              => "You must provide a name.",
	    'openid_client:invalid_email_error'             => "You must provide a valid email address.",
	    'openid_client:invalid_code_error'              => "Your form code appears to be invalid. Codes only last for seven days;"
	        ." it's possible that yours is older.",
	    'openid_client:user_creation_failed'            => "Unable to create OpenID account.",
	    'openid_client:created_openid_account'          => "Created OpenID account, transferred email %s and name %s from the OpenID server.",
	    'openid_client:name_updated'                    => "Your name has been updated to %s.",
	    'openid_client:missing_confirmation_code'       => "Your confirmation code appears to be missing. Please check your link and try again.",
	    'openid_client:at_least_13'                     => "You must indicate that you are at least 13 years old to join.",
	    'openid_client:account_created'                 => "Your account was created! You can now log in using the OpenID (%s) you supplied.",
	    'openid_client:email_changed'                   => "Your email address has been changed to {%s} . "
		    ."You can now login using your OpenID if you are not already logged in.",
		'openid_client:thankyou'                        => "Thank you for registering for an account with %s!"
	        ." Registration is completely free, but before you confirm your details,"
	        ." please take a moment to read the following documents:",
	    'openid_client:terms'                           => "terms and conditions",
	    'openid_client:privacy'                         => "privacy policy",
	    'openid_client:acceptance'                      => "Submitting the form below indicates acceptance of these terms. "
	        ."Please note that currently you must be at least 13 years of age to join the site.",
	    'openid_client:correct_age'                     => "I am at least thirteen years of age.",
	    'openid_client:join_button_label'               => "Join",
	    'openid_client:confirmation_title'              => "OpenID confirmation",
	    'openid_client:admin_title'                     => "Configure OpenID client",
	    'openid_client:default_server_title'             => "Default server",
	    'openid_client:default_server_instructions1'     => "You can simplify logging on using OpenID by specifying a default OpenID server."
            ." Users who enter a simple account name (eg. \"susan\") during an OpenID login can have it expanded to a full OpenID"
	        ." if you provide a default server here. Put \"%s\" where you want the account name added. For example, enter"
	        ." \"http://openidserver.com/%s/\" if you want the OpenID to become \"http://openidserver.com/susan/\" or"
	        ." \"http://%s.openidserver.com/\" if you want the OpenID to become \"http://susan.openidserver.com/\"",
	    'openid_client:default_server_instructions2'    => "The presence of dots (\".\") is used to distinguish OpenID URLs from simple"
	        ." account names, so you can only use this feature for default servers that do not allow dots in their simple account names.",
	    'openid_client:server_sync_title'               => "Server synchronisation",
	    'openid_client:server_sync_instructions'        => "Check this box if you want to automatically update this client site if a"
	        ." user logs in and their email address or name is different from that on their OpenID server. Leave this box unchecked"
	        ." if you want to allow your users to have the ability to maintain a different name or email address on this system"
	        ." from the ones on their OpenID server.",
	    'openid_client:server_sync_label'               => "Automatically update from the OpenID server.",
	    
	    'openid_client:sso_title'               		=> "Single sign-on",
	    'openid_client:sso_instructions'        		=> "Check this box if you want to activate the single sign-on link."
	        ." This link simulates an Elgg OpenID login form submit and can be used to create a one-click single sign-on with Elgg."
	        ." Note that it is a bit insecure becomes it circumvents Elgg's XSS security"
	        ." and could in principle be used to log the user into Elgg without his/her knowledge.",
	    'openid_client:sso_label'               		=> "Enable single sign-on (SSO) link.",
	        
	    'openid_client:lists_title'                     => "OpenID lists",
	    'openid_client:lists_instruction1'              => "You can set up a green, yellow or red list of OpenIDs that this client will accept.",
	    'openid_client:lists_instruction2'              => "The green list contains OpenIDs that will be accepted to provide identification"
	        ." and that can supply a trusted email address.",
	    'openid_client:lists_instruction3'              => "The yellow list contains OpenIDs that will be accepted for identification only."
	        ." If they provide an email address, a message will be sent to that address for confirmation before registration is allowed.",
	    'openid_client:lists_instruction4'              => "The red list contains OpenIDs that should be rejected.",
	    'openid_client:lists_instruction5'              => "If you do not provide a green, yellow or red list, by default all OpenIDs"
	        ." will be given a green status (they will be accepted for identification and email addresses that they provide will be"
	        ." accepted without confirmation).",
	    'openid_client:lists_instruction6'              => "Put one OpenID entry on each line. You can use \"*\" as a wildcard character"
	        ." to match a number of possible OpenIDs or OpenID servers. Each OpenID must begin with http:// or https:// and end with a"
	        ." slash (\"/\") - eg. http://*.myopenid.com/",
	    'openid_client:green_list_title'                => "Green list",
	    'openid_client:yellow_list_title'               => "Yellow list",
	    'openid_client:red_list_title'                  => "Red list",
	    'openid_client:ok_button_label'                 => "OK",
	    'openid_client:admin_response'                  => "OpenID client configuration values saved."
	    
	);
					
	add_translation("en",$english);

?>