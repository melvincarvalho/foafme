<?php

	/**
	 * Elgg Market Plugin
	 * @package market (forked from webgalli's Classifieds Plugin)
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author slyhne
	 * @copyright TechIsUs
	 * @link www.techisus.dk
	 */

	// Load Elgg engine
	require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");
	if (get_plugin_setting('market_adminonly', 'market') == 'yes') {
		admin_gatekeeper();
	} else {
		gatekeeper();
	}
		
	// Get the current page's owner
	$page_owner = page_owner_entity();
	if ($page_owner === false || is_null($page_owner)) {
		$page_owner = $_SESSION['user'];
		set_page_owner($_SESSION['guid']);
	}

	// How many classifieds can a user have
	$marketmax = get_plugin_setting('market_max', 'market');
	if(!$marketmax){
		$marketmax == "0" ;
	}
	$marketactive = count_user_objects($_SESSION['guid'], 'market');

	// Show form, or error if users has used his quota
	if($marketmax > $marketactive || $marketmax == "0"){ 
		//set the title
		$area2 = elgg_view_title(elgg_echo('market:addpost:title'));
		// Get the form
		$area2 .= elgg_view("market/forms/edit");
	}else{
		//set the title
		$area2 = elgg_view_title(elgg_echo('market:tomany'));
		$area2 .= elgg_view("market/error");
	}

		
	// Display page
	page_draw(elgg_echo('market:addpost'),elgg_view_layout("two_column_left_sidebar", $area1, $area2));

		
?>
