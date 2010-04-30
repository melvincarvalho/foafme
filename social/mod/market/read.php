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

	// Get the specified market post
		$post = (int) get_input('marketpost');

	// If we can get out the market post ...
		if ($marketpost = get_entity($post)) {
			
	// Get any comments
			$comments = $marketpost->getAnnotations('comments');
			$marketprice = $marketpost->getAnnotations('marketprice');
			$markettype = $marketpost->getAnnotations('markettype');
	// Set the page owner
			set_page_owner($marketpost->getOwner());
			$page_owner = get_entity($marketpost->getOwner());
			
	// Display it
			$area2 = elgg_view("object/market",array(
											'entity' => $marketpost,
											'entity_owner' => $page_owner,
											'comments' => $comments,
											'price' => $marketprice,
											'type' => $markettype,
											'full' => true
											));
	// Set the title appropriately
	$title = sprintf(elgg_echo("market:posttitle"),$page_owner->name,$marketpost->title);

	// If we're not allowed to see the market post
		} else {
			
	// Display the 'post not found' page instead
			$area2 = elgg_view_title(elgg_echo("market:notfound"));
			$title = elgg_echo("market:notfound");
			
		}
	

	// Get categories, if they're installed
	global $CONFIG;
	$area3 = elgg_view('market/categorylist',array('baseurl' => $CONFIG->wwwroot . 'search/?search_viewtype=gallery&subtype=market&tagtype=universal_marketcategories&tag=','subtype' => 'market', '0'));

	//set a view to display a tag cloud
	$area3 .= elgg_view("market/sidebarTagcloud");	

	// Display through the correct canvas area
	$body = elgg_view_layout("two_column_left_sidebar", '', $area1 . $area2, $area3);
			
		
	// Display page
	page_draw($title,$body);
		
?>
