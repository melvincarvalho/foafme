<?php
	/**
	 * Elgg Market Plugin
	 * @package market (forked from webgalli's Classifieds Plugin)
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author slyhne
	 * @copyright TechIsUs
	 * @link www.techisus.dk
	 */

	$linkstr = '';
	if (isset($vars['entity']) && $vars['entity'] instanceof ElggEntity) {
		
		$marketcategories = $vars['entity']->universal_marketcategories;
		if (!empty($marketcategories)) {
			if (!is_array($marketcategories)) $marketcategories = array($marketcategories);
			foreach($marketcategories as $category) {
				$link = $vars['url'] . 'search?tagtype=universal_marketcategories&tag=' . urlencode($category);
				if (!empty($linkstr)) $linkstr .= ', ';
				$linkstr .= '<a href="'.$link.'">' . elgg_echo($category) . '</a>';
			}
		}
		
	}
	echo $linkstr;

?>
