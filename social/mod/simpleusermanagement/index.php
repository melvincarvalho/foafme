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

    require_once(dirname(dirname(dirname(__FILE__))) . '/engine/start.php');
    admin_gatekeeper();
    set_context('admin');
    global $CONFIG;

    $title = elgg_echo('simpleusermanagement:main_management');

	$body = '';
    $body .= elgg_view_title($title);

	$body .= elgg_view('simpleusermanagement/simpleusermanagement_disabled_users_view');

    page_draw($title,elgg_view_layout('two_column_left_sidebar', '', $body));
    
?>
