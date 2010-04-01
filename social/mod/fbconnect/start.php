<?php

	/**
	 * Elgg Facebook Connect plugin
	 * 
	 * @package fbconnect
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Kevin Jardine
	 * @copyright Curverider 2009
	 * @link http://elgg.org/
	 */

	/**
	 * fbconnect initialisation
	 *
	 * These parameters are required for the event API, but we won't use them:
	 * 
	 * @param unknown_type $event
	 * @param unknown_type $object_type
	 * @param unknown_type $object
	 */

	function fbconnect_init() {
		
		// Load system configuration
		global $CONFIG;
		
		// Load the language files
		register_translations($CONFIG->pluginspath . "fbconnect/languages/");
		
		extend_view("account/forms/login", "fbconnect/login");
		
		// Extend system CSS with our own styles
		extend_view('css','fbconnect/css');
		
		register_plugin_hook('usersettings:save','user','fbconnect_user_settings_save');
	
	}
	
	function fbconnect_pagesetup() {
        // make profile edit links invisible for Facebook accounts
        // that do not have Facebook control explicitly turned off
        if ((get_context() == 'profile') 
        	&& ($page_owner_entity = page_owner_entity()) 
        	&& ($page_owner_entity->getSubtype() == "facebook")
        	&& ($page_owner_entity->facebook_controlled_profile != 'no')
        ) {
        	extend_view('metatags','fbconnect/hide_profile_embed');
        }
        
        extend_elgg_settings_page('fbconnect/settings/usersettings', 'usersettings/user');
    }
    
    /**
	 * Cron job
	 * Every 12 hours we need to update the Facebook information
	 *
	 */
	function fbconnect_cron($hook, $entity_type, $returnvalue, $params) {
		$i = 0;
		$twelve_hours = 60*60*12;
		set_context('fbconnect');
		// get the Facebook users
		$user_count = get_entities('user','facebook',0,'',10,0,true);
		if ($user_count) {
			$users = get_entities('user','facebook',0,'',$user_count,0,false);
			foreach ($users as $user) {
				// sync the user data with Facebook if the data is older than
				// tweleve hours
				if(($user->facebook_controlled_profile != 'no')&& ((time()-$user->facebook_sync_time) > $twelve_hours)) {
					fbconnect_update_profile($user);
					$i += 1;
				}
			}
		}

		echo sprintf(elgg_echo('fbconnect:cron_report'),$i);
	}
	
	register_plugin_hook('cron', 'hourly', 'fbconnect_cron');
	
	// allows cron job to update Facebook users
	
	function fbconnect_can_edit($hook_name, $entity_type, $return_value, $parameters) {
         
         $entity = $parameters['entity'];
         $context = get_context();
         if ($context == 'fbconnect' && $entity->getSubtype() == "facebook") {
             // should be able to update Facebook user data
             return true;
         }
         return null;  
     }
     
     register_plugin_hook('permissions_check','user','fbconnect_can_edit');

	register_elgg_event_handler('init','system','fbconnect_init');
	register_elgg_event_handler('pagesetup','system','fbconnect_pagesetup');
	
	function fbconnect_icon_url($hook_name,$entity_type, $return_value, $parameters) {
     	$entity = $parameters['entity'];
     	if (($entity->getSubtype() == "facebook") && ($entity->facebook_controlled_profile != 'no')) {
     		if (in_array($parameters['size'],array('tiny','small','topbar'))) {
     			return $entity->facebook_icon_url_mini;
     		} else {
     			return $entity->facebook_icon_url_normal;
     		}
     	}
     }
     
     function fbconnect_user_settings_save() {    	
    	gatekeeper();
    	
    	$user = page_owner_entity();
    	if (!$user) {    	
    		$user = $_SESSION['user'];
    	}
    	
    	$subtype = $user->getSubtype();
    	
    	if ($subtype == 'facebook') {
    	
    	    $facebook_controlled_profile = get_input('facebook_controlled_profile','yes');
    	
	    	if ((!$user->facebook_controlled_profile && ($facebook_controlled_profile == 'no'))
	    		|| ($user->facebook_controlled_profile && ($user->facebook_controlled_profile != $facebook_controlled_profile))
	    	) {    	
	    		$user->facebook_controlled_profile = $facebook_controlled_profile;	    
	    		system_message(elgg_echo('fbconnect:user_settings:save:ok'));
	    	}
    	} else if (!$subtype) {
    		
    		// users with no subtype (regular Elgg users) are allowed a
    		// slave Facebook login
    		$facebook_uid = get_input('facebook_uid');
    		if ($facebook_uid != $user->facebook_uid) {
    			$user->facebook_uid = $facebook_uid;
    			system_message(elgg_echo('fbconnect:facebook_login_settings:save:ok'));
    		}
    	}
	}

    register_plugin_hook('entity:icon:url','user','fbconnect_icon_url');
	
	/**
	 * Get the facebook client object for easy access.
	 * @return object
	 *   Facebook Api object
	 */
	function fbconnect_client() {
	  global $CONFIG;
	  static $fb = NULL;
	  if (!$fb instanceof Facebook) {
	  	include_once($CONFIG->pluginspath.'fbconnect/facebook-platform/facebook.php');
	  	$api_key = get_plugin_setting('api_key', 'fbconnect');
	  	$api_secret = get_plugin_setting('api_secret', 'fbconnect');
	  	$fb = new Facebook($api_key, $api_secret);
	  }
	  return $fb;
	}
	
	/**
	 * Query information from facebook user table.
	 *
	 * @return array
	 */
	function fbconnect_get_info_from_fb($fbuid, $fields) {
	  if (fbconnect_client() && $fields) {
	    try {
	      $result = fbconnect_client()->api_client->fql_query("SELECT $fields FROM user WHERE uid = $fbuid");
	      return $result[0];
	    } catch (Exception $e) {
	      error_log('Exception thrown while using FQL: '. $e->getMessage());
	    }
	  }
	}
	
	function fbconnect_update_profile($user) {
		$fbuid = $user->facebook_uid;
		$fbprofile = fbconnect_get_info_from_fb($fbuid,'name, pic_with_logo, pic_big_with_logo, pic_square_with_logo, pic_small_with_logo, interests, hometown_location, about_me');
		if ($fbprofile) {
			$user->description = $fbprofile['about_me'];
			$user->name = $fbprofile['name'];
			$location = $fbprofile['hometown_location'];
			$location2 = array();
			foreach($location as $item) {
				if ($item)
					$location2[] = $item;
			}
		    $user->location = $location2;
		    $user->interests = explode(',',$fbprofile['interests']);
		    $user->facebook_icon_url_normal = $fbprofile['pic_big_with_logo'];
		    $user->facebook_icon_url_mini = $fbprofile['pic_square_with_logo'];
		    $user->facebook_sync_time = time();
		    $user->save();
		}
	}
	
// Register actions

	global $CONFIG;

	register_action("fbconnect/login",false,$CONFIG->pluginspath . "fbconnect/actions/login.php");
	
?>