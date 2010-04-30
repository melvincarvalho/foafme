<?php

    /**
     * List disabled users
     *
     * @package simpleusermanagement
     * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
     * @author Pjotr Savitski
     * @copyright (C) Pjotr Savitski
     * @link http://code.google.com/p/simpleusermanagement/
     **/    

    // Check if uservalidationbyemail plugin is enabled
    $useractivationbyemail_enabled = is_plugin_enabled('uservalidationbyemail');
    // Order
	$invalid_users = simpleusermanagement_get_disabled_users();
	
	$body = '';

	$body .= elgg_view('simpleusermanagement/forms/invalid_users_search_form');

	// Mask addition for email change
	$body .= '<div id="simpleusermanagement_email_mask" onclick="simpleusermanagementCloseEmailChange();">';
	$body .= '</div>';
	$body .= '<div id="simpleusermanagement_email_form">';
	$body .= elgg_view('simpleusermanagement/forms/change_invalid_user_email');
	$body .= '</div>';


    // Add content holder
	$body .= '<div id="simpleusermanagement_disabled_users_content" class="simpleusermanagement_disabled_users_content">';

    // Show inactive users count or display no_disabled_users_found message
    if ($invalid_users) {
	    $body .= '<div class="simpleusermanagement_entities_count">' . sprintf(elgg_echo('simpleusermanagement:entities_count'), count($invalid_users)) . '</div>';

	    // Create a listing of all found inactive user entities
	    foreach($invalid_users as $invalid_user) {
	        $body .= elgg_view('simpleusermanagement/invalid_user_view', array('user' => $invalid_user, 'useractivation_byemail_enabled' => $useractivationbyemail_enabled));
	    }
    } else {
	    // Add content holder
	    $body .= '<div class="simpleusermanagement_disabled_users_content">';

	    $body .= '<div class="simpleusermanagement_nothing_found">' . elgg_echo('simpleusermanagement:no_disabled_users_found') . '</div>';

	    $body .= '</div>';
	}

	$body .= '</div>';

    echo $body;
?>
