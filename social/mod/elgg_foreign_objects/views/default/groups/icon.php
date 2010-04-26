<?php

	/**
	 * Elgg group icon
	 * 
	 * @package ElggGroups
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Curverider Ltd
	 * @copyright Curverider Ltd 2008-2010
	 * @link http://elgg.com/
	 * 
	 * @uses $vars['entity'] The user entity. If none specified, the current user is assumed.
	 * @uses $vars['size'] The size - small, medium or large. If none specified, medium is assumed. 
	 */

	$group = $vars['entity'];
	
	if ($group instanceof ElggGroup) {
	
	// Get size
	if (!in_array($vars['size'],array('small','medium','large','tiny','master','topbar')))
		$vars['size'] = "medium";
			
	// Get any align and js
	if (!empty($vars['align'])) {
		$align = " align=\"{$vars['align']}\" ";
	} else {
		$align = "";
	}
	
	if ($icontime = $vars['entity']->icontime) {
		$icontime = "{$icontime}";
	} else {
		$icontime = "default";
	}
	
	
?>

<div class="groupicon">
<?php 
if ($vars['entity']->foreign) {
	$url = $vars['entity']->link;
	$icon_url = str_replace('tiny',$vars['size'], $vars['entity']->icon_link);
}
else {
	$url = $vars['entity']->getURL();
	$icon_url = $vars['entity']->getIcon($vars['size']);
}
	
?>
<a href="<?php echo $url; ?>" class="icon" ><img src="<?php echo $icon_url; ?>" border="0" <?php echo $align; ?> title="<?php echo $name; ?>" <?php echo $vars['js']; ?> /></a>
</div>

<?php

	}

?>
