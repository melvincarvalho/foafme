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
		
	// Get the current page's owner
	$page_owner = page_owner_entity();
	if ($page_owner == false || is_null($page_owner)) {
		$page_owner = $_SESSION['user'];
		set_page_owner($_SESSION['guid']);
	}
	if (!($page_owner instanceof ElggEntity)) forward();

	//set the title
        if($page_owner == $_SESSION['user']){
		$area2 = elgg_view_title(elgg_echo('market:yourfriends'));
	}else{
		$area2 = elgg_view_title($page_owner->username . "'s " . elgg_echo('market:friends'));
	}
		
	// Get a list of market posts
	//set_context('search');
	//$area2 .= list_user_friends_objects($page_owner->getGUID(),'market',12,false);
	$area2 .= "<div id='blogs'>" . list_user_friends_objects($page_owner->getGUID(),'market',5,false) . "<div class='clearfloat'></div></div>";
		
	// Get categories, if they're installed
	global $CONFIG;
	$area3 = elgg_view('market/categorylist',array('baseurl' => $CONFIG->wwwroot . 'search/?subtype=market&tagtype=universal_marketcategories&tag=','subtype' => 'market', '0'));

	//set a view to display a tag cloud
	$area3 .= elgg_view("market/sidebarTagcloud");	

	// Display them in the page
        $body = elgg_view_layout("two_column_left_sidebar", '', $area1 . $area2, $area3);
		
	// Display page
	page_draw(elgg_echo('market:friends'),$body);
		
?>
