<?php

	$english = array(	
	
		'item:user:facebook' => "Facebook users",			
		'fbconnect:settings:api_key:title' => "API Key",
		'fbconnect:settings:api_secret:title' => "API Secret",
		'fbconnect:account_create' => "Error: Unable to create your account. "
			."Please contact the site administrator or try again later.",
		'fbconnect:inactive' => "Error: cannot activate your Elgg account.",
		'fbconnect:banned' => "Error: cannot log you in. "
			."Please contact the site administrator or try again later.",
		'fbconnect:fail' => "Error: cannot log you in. "
			."Please contact the site administrator or try again later.",
		'fbconnect:facebookerror' => "Error: Facebook returned the following error message: %s",
		'fbconnect:account_duplicate' => "Error: a non-Facebook account with "
			."the same username (%s) already exists on this site.",
		'fbconnect:settings:yes' => "yes",
		'fbconnect:settings:no' => "no",
		'fbconnect:user_settings_title' => "Facebook profile",
		'fbconnect:user_settings_description' => "Let Facebook control my profile when I login into Elgg. "
			."If you set this to \"no\", you will be able to edit your Elgg profile and it will no longer be synchronised with Facebook.",
		'fbconnect:user_settings:save:ok' => "Your Facebook profile preference has been saved.",
		'fbconnect:facebook_login_settings:save:ok' => "Your Facebook uid has been saved.",
		'fbconnect:facebook_login_title' => "Facebook login",
		'fbconnect:facebook_login_description' => "If you want to login to Elgg using Facebook, enter your Facebook uid here (This should be a number that appears in the URL for your Facebook profile page).",
		'fbconnect:cron_report' => "Synced %s Facebook accounts."	
	);
					
	add_translation("en",$english);

?>