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
	
	// Get input
	$selected_category = get_input('cat', "all");
	$offset = get_input('offset', 0);

	// Get the current page's owner
	$page_owner = page_owner_entity();
	if ($page_owner == false || is_null($page_owner)) {
		$page_owner = $_SESSION['user'];
		set_page_owner($_SESSION['guid']);
	}

	//set market title
	if($selected_category == 'all'){
		$area1 = elgg_view_title(elgg_echo('market:all:categories'));
	}else{
		$area1 = elgg_view_title(sprintf(elgg_echo('market:category'), elgg_echo($selected_category)));
	}

	// Get a list of market posts in a specific category
	$area2 = "<div id='blogs'>";
	$area2 .= list_entities_from_metadata("marketcategory", $selected_category, "object", "market", $owner_guid, "5", false, false, true);
	$area2 .= "<div class='clearfloat'></div></div>";

	// Get categories, if they're installed
	global $CONFIG;
	$area3 = elgg_view('market/categorylist',array('subtype' => 'market', '0'));
		
	//set a view to display a tag cloud
	$area3 .= elgg_view("market/sidebarTagcloud");	

	// Display them in the page
        $body = elgg_view_layout("two_column_left_sidebar", '', $area1 . $area2, $area3);
		
	// Display page
	page_draw(elgg_echo('market:everyone'),$body);
		
?>
