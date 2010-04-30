<?php

    /**
     * Elgg simpleusermanagement plugin
     *
     * @package simpleusermanagement
     * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
     * @author Pjotr Savitski
     * @copyright (C) Pjotr Savitski
     * @link http://code.google.com/p/simpleusermanagement/
     **/

    function simpleusermanagement_init() {
        global $CONFIG;
        register_page_handler('simpleusermanagement', 'simpleusermanagement_page_handler');

		extend_view('css', 'simpleusermanagement/simpleusermanagement_css');
		extend_view('metatags', 'simpleusermanagement/metatags');
    }

    function simpleusermanagement_pagesetup() {
        global $CONFIG;
        if (get_context() == 'admin' && isadminloggedin()) {
            add_submenu_item(elgg_echo('simpleusermanagement:submenu_item_usermanagement'), $CONFIG->wwwroot . 'pg/simpleusermanagement/mainmanage');
        }
    }

    function simpleusermanagement_page_handler($page) {
        global $CONFIG;

        if ($page[0]) {
            switch ($page[0]) {
            case "mainmanage":
                include($CONFIG->pluginspath . 'simpleusermanagement/index.php');
                break;
            default:
                include($CONFIG->pluginspath . 'simpleusermanagement/index.php');
                break;
            }
        } else {
            include($CONFIG->pluginspath . 'simpleusermanagement/index.php');
            return true;
        }
    }

    function simpleusermanagement_get_disabled_users($order=null) {
        global $CONFIG;
        // Additional check for admin to be logged in
        if (isadminloggedin()) {
            // If no order provided use descending
            if (!in_array($order, array('desc', 'asc')))
                $order = 'desc';
            $access_status = access_get_show_hidden_status();
            access_show_hidden_entities(true);
            $data = get_data("SELECT e.* FROM {$CONFIG->dbprefix}entities e join {$CONFIG->dbprefix}users_entity u on e.guid=u.guid WHERE e.enabled='no' ORDER BY e.time_created {$order}", "entity_row_to_elggstar");
            access_show_hidden_entities($access_status);
            return $data;
        }
        return false;
    }

    // Unvalidated users search
    function simpleusermanagement_search_for_disabled_users($criteria) {
        global $CONFIG;
        // Additional check for admin to be logged in
        if (isadminloggedin()) {
            $access_status = access_get_show_hidden_status();
            access_show_hidden_entities(true);
            $data = get_data("SELECT e.* FROM {$CONFIG->dbprefix}entities e join {$CONFIG->dbprefix}users_entity u on e.guid=u.guid WHERE e.enabled='no' and (u.name like \"%{$criteria}%\" or u.username like \"%{$criteria}%\") ORDER BY e.time_created desc", "entity_row_to_elggstar");
            access_show_hidden_entities($access_status);
            return $data;
        }
        return false;
    }

    // Initialize
    global $CONFIG;
    register_elgg_event_handler('init','system','simpleusermanagement_init');
    register_elgg_event_handler('pagesetup','system','simpleusermanagement_pagesetup');

    // Actions
    register_action('simpleusermanagement/activate_user', false, $CONFIG->pluginspath . 'simpleusermanagement/actions/activate_user.php', true);
    register_action('simpleusermanagement/resend_activation_email', false, $CONFIG->pluginspath . 'simpleusermanagement/actions/resend_activation_email.php', true);
	register_action('simpleusermanagement/delete_pending_user', false, $CONFIG->pluginspath . 'simpleusermanagement/actions/delete_pending_user.php', true);
	register_action('simpleusermanagement/change_user_email', false, $CONFIG->pluginspath . 'simpleusermanagement/actions/change_user_email.php', true);
?>
