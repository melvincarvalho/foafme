<?php
	/**
	 * Elgg Market Plugin
	 * @package market (forked from webgalli's Classifieds Plugin)
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author slyhne
	 * @copyright TechIsUs
	 * @link www.techisus.dk
	 */

	$list = elgg_view('market/list',$vars);
	if (!empty($list)) {
?>

	<div class="blog_categories">
		<?php echo $list; ?>
	</div>

<?php

	}

?>
