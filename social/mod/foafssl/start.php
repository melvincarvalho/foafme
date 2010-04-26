<?php

/**
 * au_default_profile_fields start file:
 * 
 * a simple plugin to set default profile fields
 * 
 * @author Brian Jorgensen (brianj@athabascau.ca)
 * @copyright 2010 Brian Jorgensen
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
  */

// register hook
register_plugin_hook('profile:fields', 'profile', 'get_au_default_profile_fields');

/**
 * method that returns a hash (php array) of profile field names/types
 * 
 * @return array
 */
function get_au_default_profile_fields() {
    
    // these are the ones that come with Elgg 1.6.1
	$au_profile_defaults = array (
		'description' => 'longtext',
		'briefdescription' => 'text',
		'location' => 'text',
		'interests' => 'tags',
		'skills' => 'tags',
		'contactemail' => 'email',
		'phone' => 'text',
		'mobile' => 'text',
		'website' => 'url',
	
	/**
	 * these are the ones that AU added
	 */
        'likes' => "tags",
        'dislikes' => "tags",
        'goals' => "tags",
        'streetaddress' => "text",
        'state' => "text",
        'postcode' => "text",
        'country' => "text",
        'homephone' => "text",
        'personalweb' => "url",
        'icq' => "text",
        'msn' => "text",
        'aim' => "text",
        'skype' => "text",
        'jabber' => "text",
        'occupation' => "text",
        'industry' => "text",
        'publickey' => "text",
        'publickeyexponent' => "text",
        'publickeymodulus' => "text"
	);
			
    return $au_profile_defaults;
}

?>
