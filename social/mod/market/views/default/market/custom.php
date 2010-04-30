<?php
	/**
	 * Elgg Market Plugin
	 * @package market (forked from webgalli's Classifieds Plugin)
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author slyhne
	 * @copyright TechIsUs
	 * @link www.techisus.dk
	 * Choises: N/A, Factory new, Unused, Like New, Excellent, Good, Fair, Poor, Defect
	 */

	if (isset($vars['entity']) && $vars['entity'] instanceof ElggEntity) {
		$custom_selected = $vars['entity']->custom;
	}
	$custom_choices = string_to_tag_array(get_plugin_setting('market_custom_choices', 'market'));
	if (empty($custom_choices)) $custom_choices = array();
	if (empty($custom_selected)) $custom_selected = array(); 

	if (!empty($custom_choices)) {
		if (!is_array($custom_choices)) $custom_choices = array($custom_choices);
		

		echo "<label>" . elgg_echo('market:custom:select') . "&nbsp;";
		echo elgg_view('market/input/pulldown',array(
							'options' => $custom_choices,
							'value' => $custom_selected,
							'internalname' => 'marketcustom'
							));
		echo "</label>";
		echo "</p>";

	}

?>
