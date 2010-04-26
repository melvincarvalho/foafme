<?php

    /**
     * Search for disabled users
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
    $results = "";

	$search_criteria = get_input('search_criteria');
    $useractivationbyemail_enabled = is_plugin_enabled('uservalidationbyemail');

    // Check if search criteria is provided
    if (!empty($search_criteria)) {
		$users = simpleusermanagement_search_for_disabled_users($search_criteria);

		if ($users)
			$results .= '<div class="simpleusermanagement_entities_count">' . sprintf(elgg_echo('simpleusermanagement:entities_count'), count($users)) . '</div>';
		else 
			$results .= '<div class="simpleusermanagement_nothing_found">' . elgg_echo('simpleusermanagement:no_disabled_users_found_with_criteria') . '</div>';

	    foreach ($users as $user) {
            $results .= elgg_view('simpleusermanagement/invalid_user_view', array('user' => $user, 'useractivation_byemail_enabled' => $useractivationbyemail_enabled));
		}

	} else {
		$results .= '<div class="simpleusermanagement_nothing_found">' . elgg_echo('simpleusermanagement:no_search_criteria_provided') . '</div>';
		$all_users = simpleusermanagement_get_disabled_users();

		if ($all_users)
            $results .= '<div class="simpleusermanagement_entities_count">' . sprintf(elgg_echo('simpleusermanagement:entities_count'), count($all_users)) . '</div>';

		foreach ($all_users as $user) {
            $results .= elgg_view('simpleusermanagement/invalid_user_view', array('user' => $user, 'useractivation_byemail_enabled' => $useractivationbyemail_enabled));

		}
	}

    echo $results;
?>
