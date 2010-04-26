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

	admin_gatekeeper();
	set_context('admin');
	$title = elgg_echo('vazco_karma:userpoints');
	$content = elgg_view_title($title);
	$content .= elgg_view('forms/vazco_karma/userpoints',array('user_login'=>$user_login));

	$sidebar = '';	
	$body = elgg_view_layout('two_column_left_sidebar', '', $content, $sidebar);
	
	page_draw($title, $body);
?>