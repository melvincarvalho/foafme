<?php

	/**
	 * Elgg Market Plugin
	 * @package market (forked from webgalli's Classifieds Plugin)
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author slyhne
	 * @copyright TechIsUs
	 * @link www.techisus.dk
	 */

	/**
	 * market initialisation
	 */

	function market_init() {
	// Load system configuration
		global $CONFIG;
	// Set up menu for logged in users
		if (isloggedin()) {
			add_menu(elgg_echo('market:title'), $CONFIG->wwwroot . "mod/market/everyone.php");
		// And for logged out users
		} else {
			add_menu(elgg_echo('market'), $CONFIG->wwwroot . "mod/market/everyone.php");
		}
	// Extend system CSS with our own styles, which are defined in the market/css view
		elgg_extend_view('css','market/css');
	// Extend hover-over menu	
		elgg_extend_view('profile/menu/links','market/menu');
	// Add a new widget
		add_widget_type('market',elgg_echo("market:widget"),elgg_echo("market:widget:description"));
	// Register a page handler, so we can have nice URLs
		register_page_handler('market','market_page_handler');
	// Register a URL handler for market posts
		register_entity_url_handler('market_url','object','market');
	// Register entity type
		register_entity_type('object','market');
	}
	
	function market_pagesetup() {
		global $CONFIG;

		//add submenu options
		if (get_context() == "market") {
			// Get page owner
			$page_owner = page_owner_entity();
			if (($page_owner->guid == $_SESSION['guid'] || page_owner()) && isloggedin()) {
				add_submenu_item(elgg_echo('market:your'),$CONFIG->wwwroot."pg/market/" . $_SESSION['user']->username);
				add_submenu_item(elgg_echo('market:friends'),$CONFIG->wwwroot."pg/market/" . $_SESSION['user']->username . "/friends/");
				add_submenu_item(elgg_echo('market:everyone'),$CONFIG->wwwroot."mod/market/everyone.php");

				$adminonly = get_plugin_setting('market_adminonly', 'market');
				if ($adminonly != 'yes' || isadminloggedin()) {
					add_submenu_item(elgg_echo('market:addpost'),$CONFIG->wwwroot."mod/market/add.php");
				}

			} else if (page_owner()) {
				add_submenu_item(sprintf(elgg_echo('market:user'),$page_owner->name),$CONFIG->wwwroot."pg/market/" . $page_owner->username);

				if ($page_owner instanceof ElggUser) { // Sorry groups, this isn't for you.
					add_submenu_item(sprintf(elgg_echo('market:user:friends'),$page_owner->name),$CONFIG->wwwroot."pg/market/" . $page_owner->username . "/friends/");
				}
				add_submenu_item(elgg_echo('market:everyone'),$CONFIG->wwwroot."mod/market/everyone.php");
			} else {
				add_submenu_item(elgg_echo('market:everyone'),$CONFIG->wwwroot."mod/market/everyone.php");
			}

		}
	}

	 // market page handler; allows the use of fancy URLs
	 // @param array $page From the page_handler function
	 // @return true|false Depending on success
	 //
	function market_page_handler($page) {
		// The first component of a market URL is the username
		if (isset($page[0])) {
			set_input('username',$page[0]);
		}
		// The second part dictates what we're doing
		if (isset($page[1])) {
			switch($page[1]) {
				case "read":		set_input('marketpost',$page[2]);
							@include(dirname(__FILE__) . "/read.php");
							break;
				case "friends":		@include(dirname(__FILE__) . "/friends.php");
							break;
			}
		// If the URL is just 'market/username', or just 'market/', load the standard market index
		} else {
			@include(dirname(__FILE__) . "/index.php");
			return true;
		}
		return false;
	}

	 // Populates the ->getUrl() method for market objects
	 //
	 // @param ElggEntity $marketpost market post entity
	 // @return string market post URL

	function market_url($marketpost) {
		global $CONFIG;
		$title = $marketpost->title;
		$title = friendly_title($title);
		return $CONFIG->url . "pg/market/" . $marketpost->getOwnerEntity()->username . "/read/" . $marketpost->getGUID() . "/" . $title;
	}

	// Make sure the market initialisation function is called on initialisation
		register_elgg_event_handler('init','system','market_init');
		register_elgg_event_handler('pagesetup','system','market_pagesetup');

	// Register actions
		global $CONFIG;
		register_action("market/add",false,$CONFIG->pluginspath . "market/actions/add.php");
		register_action("market/edit",false,$CONFIG->pluginspath . "market/actions/edit.php");
		register_action("market/delete",false,$CONFIG->pluginspath . "market/actions/delete.php");
?>
