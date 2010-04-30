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
		gatekeeper();
		
	// Get the current page's owner
		$page_owner = page_owner_entity();
		if ($page_owner === false || is_null($page_owner)) {
			$page_owner = $_SESSION['user'];
			set_page_owner($_SESSION['guid']);
		}
		
	// Get the post, if it exists
		$marketpost = (int) get_input('marketpost');
		if ($post = get_entity($marketpost)) {
			
			if ($post->canEdit()) {
				
				$area2 = elgg_view_title(elgg_echo('market:upload'));
				$area2 .= elgg_view("market/forms/upload", array('entity' => $post));
				$body = elgg_view_layout("two_column_left_sidebar", $area1, $area2);
				
			}
			
		}
		
	// Display page
		page_draw(sprintf(elgg_echo('market:upload'),$post->title),$body);
		
?>
