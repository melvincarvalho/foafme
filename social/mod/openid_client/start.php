<?php

/**
 * Elgg openid client plugin
 * 
 * @package ElggOpenID
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Kevin Jardine <kevin@radagast.biz>
 * @copyright Curverider Ltd 2008-2009
 * @link http://elgg.com/
 */
 
 global $CONFIG;
 
 set_include_path(get_include_path() . PATH_SEPARATOR . $CONFIG->pluginspath . 'openid_client/models');

/**
 * OpenID client initialisation
 *
 * These parameters are required for the event API, but we won't use them:
 * 
 * @param unknown_type $event
 * @param unknown_type $object_type
 * @param unknown_type $object
 */

function openid_client_init() {
		
    elgg_extend_view("account/forms/login", "openid_client/forms/login");
        
	// Extend system CSS with our own styles
	elgg_extend_view('css','openid_client/css');
		
	// Register a page handler, so we can have nice URLs
	register_page_handler('openid_client','openid_client_page_handler');
    	
}
        
function openid_client_pagesetup()
    {
    if (get_context() == 'admin' && isadminloggedin()) {
    	global $CONFIG;
    	add_submenu_item(elgg_echo('openid_client:admin_title'), $CONFIG->wwwroot . 'pg/openid_client/admin');
    }
}

function openid_client_can_edit($hook_name, $entity_type, $return_value, $parameters) {
	$entity = $parameters['entity'];
	$context = get_context();
	if ($context == 'openid' && $entity->getSubtype() == "openid") {
	// should be able to do anything with OpenID user data
	return true;
	}
	return null;  
}

function openid_client_page_handler($page) {
	if (isset($page[0])) {
		if ($page[0] == 'admin') {
			include(dirname(__FILE__) . "/pages/admin.php");
			return true;
		} else if ($page[0] == 'confirm') {
			include(dirname(__FILE__) . "/pages/confirm.php");
			return true;
		} else if ($page[0] == 'sso') {
			include(dirname(__FILE__) . "/pages/sso.php");
			return true;
		} else if ($page[0] == 'reset') {
			include(dirname(__FILE__) . "/pages/reset.php");
			return true;
		}
	}
	return false;
}

register_elgg_event_handler('init','system','openid_client_init');
register_elgg_event_handler('pagesetup','system','openid_client_pagesetup');

register_plugin_hook('permissions_check','user','openid_client_can_edit');

// Register actions
global $CONFIG;
register_action("openid_client/login",true,$CONFIG->pluginspath . "openid_client/actions/login.php");
register_action("openid_client/return",true,$CONFIG->pluginspath . "openid_client/actions/return.php");
register_action("openid_client/admin",false,$CONFIG->pluginspath . "openid_client/actions/admin.php");
//register_action("openid_client/confirm",false,$CONFIG->pluginspath . "openid_client/actions/confirm.php");
register_action("openid_client/missing",false,$CONFIG->pluginspath . "openid_client/actions/missing.php");
register_action("openid_client/sync",false,$CONFIG->pluginspath . "openid_client/actions/sync.php");
