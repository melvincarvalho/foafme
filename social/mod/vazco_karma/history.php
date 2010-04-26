<?php
/**
	 * Elgg vazco_books plugin
	 * 
	 * @author Michal Zacher [michal.zacher@gmail.com]
	 * @website www.elggdev.com
	 * @license GPL
	 */

	//param passed from previous form: $user_login
	require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");

	gatekeeper();

	set_context('profile');
	set_page_owner(get_user_by_username($user_login)->guid);


	$title = elgg_echo('vazco_karma:history');
	$content = elgg_view_title($title);
	$content .= elgg_view('vazco_karma/history',array('user_login'=>$user_login));

	$sidebar = '';	
	$body = elgg_view_layout('two_column_left_sidebar', '', $content, $sidebar);
	
	page_draw($title, $body);
?>