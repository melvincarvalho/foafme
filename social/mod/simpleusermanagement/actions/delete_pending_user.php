<?php

    /**
     * Delete disabled user
     *
     * @package simpleusermanagement
     * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
     * @author Pjotr Savitski
     * @copyright (C) Pjotr Savitski
     * @link http://code.google.com/p/simpleusermanagement/
     **/
    
    require_once(dirname(dirname(dirname(dirname(__FILE__)))) . "/engine/start.php");

    admin_gatekeeper();
    action_gatekeeper();

    global $CONFIG;

    // Set access status to perform needed operation
    $access_status = access_get_show_hidden_status();
    access_show_hidden_entities(true);
    // Get user guid
    $user_guid = (int)get_input('user_guid');

    // Check if user guid is provided
    if (!empty($user_guid)) {
        $user = get_entity($user_guid);
        // Check if user exists
        if (($user instanceof ElggUser) && ($user->canEdit())) {
            // Check if user is already enabled
            if (!$user->isEnabled()) {
                // Delete user
                $deleted_name = $user->name;
                if ($user->delete()) {
                    system_message(elgg_echo(sprintf(elgg_echo('simpleusermanagement:user_has_been_deleted'), $deleted_name)));
                } else {
                    register_error(elgg_echo('simpleusermanagement:user_not_deleted'));
                }
            } else {
                register_error(sprintf(elgg_echo('simpleusermanagement:this_is_active_user'), $user->name));
            }
        } else {
            register_error(elgg_echo('simpleusermanagement:no_user_guid_provided'));
        }
    } else {
        register_error(elgg_echo('simpleusermanagement:no_user_guid_provided'));
    }

    access_show_hidden_entities($access_status);

    forward($_SERVER['HTTP_REFERER']);
?>
