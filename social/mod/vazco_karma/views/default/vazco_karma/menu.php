<?php
	/**
	 * Elgg Pages: Add group menu
	 * 
	 * @package ElggPages
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Curverider Ltd
	 * @copyright Curverider Ltd 2008-2009
	 * @link http://elgg.com/
	 */
	if (isadminloggedin()){
?>
	<a href="<?php echo $vars['url']; ?>pg/vazco_karma/userpoints/<?php echo $vars['entity']->username; ?>/"><?php echo elgg_echo('vazco_karma:givepoints'); ?></a>
<?php }?>