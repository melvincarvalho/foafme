<?php

	/**
	 * Elgg Market Plugin
	 * @package market (forked from webgalli's Classifieds Plugin)
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author slyhne
	 * @copyright TechIsUs
	 * @link www.techisus.dk
	 */

	// Display an error
?>
<div class="contentWrapper">
  <p>
  <?php echo elgg_echo('market:tomany:text'); ?>
  </p>
  <p>
  <a href="<?php echo $CONFIG->root; ?>terms.php" rel="facebox"><?php echo elgg_echo('market:terms:title'); ?></a>
  </p>
</div>
