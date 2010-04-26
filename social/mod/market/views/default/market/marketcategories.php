<?php
	/**
	 * Elgg Market Plugin
	 * @package market (forked from webgalli's Classifieds Plugin)
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author slyhne
	 * @copyright TechIsUs
	 * @link www.techisus.dk
	 */

	if (isset($vars['entity']) && $vars['entity'] instanceof ElggEntity) {
		$selected_marketcategory = $vars['entity']->marketcategory;
	}
	$marketcategories = string_to_tag_array(get_plugin_setting('market_categories', 'market'));
	if (empty($marketcategories)) $marketcategories = array();
	if (empty($selected_marketcategory)) $selected_marketcategory = array(); 

	if (!empty($marketcategories)) {
		if (!is_array($marketcategories)) $marketcategories = array($marketcategories);
		

		echo "<label>" . elgg_echo('market:categories:choose') . "&nbsp;";
		echo elgg_view('market/input/pulldown',array(
			'options' => $marketcategories,
			'value' => $selected_marketcategory,
			'internalname' => 'marketcategory'
									));
		echo "</label>";
		echo "</p>";

	}

?>
