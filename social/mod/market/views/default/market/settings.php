<?php
	/**
	 * Elgg Market Plugin
	 * @package market (forked from webgalli's Classifieds Plugin)
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author slyhne
	 * @copyright TechIsUs
	 * @link www.techisus.dk
	 */

	echo elgg_view_title(elgg_echo('market:categories:settings'));

?>

	<div class="contentWrapper">

<?php

	echo elgg_view(
						'input/form',
						array(
							'action' => $vars['url'] . 'action/market/save',
							'method' => 'post',
							'body' => elgg_view('market/forms/settingsform',$vars)
						)
					);

?>

</div>
