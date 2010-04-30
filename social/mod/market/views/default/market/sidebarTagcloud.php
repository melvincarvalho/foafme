<?php
	/**
	 * Elgg Market Plugin
	 * @package market (forked from webgalli's Classifieds Plugin)
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author slyhne
	 * @copyright TechIsUs
	 * @link www.techisus.dk
	 */

if (is_plugin_enabled('tag_cumulus')){
?>

<div class="sidebarBox">

<h3 style="color:#333333;"><?php echo elgg_echo('tags') ?></h3>

        <!-- display cumulus photos -->

<?php

	echo display_tag_cumulus(0,50,'tags','object','market','','');
?>

<div class="clearfloat"></div>
</div>
<?php

}

?>
