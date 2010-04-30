<?php
	/**
	 * Elgg Market Plugin
	 * @package market (forked from webgalli's Classifieds Plugin)
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author slyhne
	 * @copyright TechIsUs
	 * @link www.techisus.dk
	 */

	// If there are any posts to view, view them
		if (is_array($vars['posts']) && sizeof($vars['posts']) > 0) {
			
			foreach($vars['posts'] as $post) {
				
				echo elgg_view_entity($post);
				
			}
			
		}

?>
