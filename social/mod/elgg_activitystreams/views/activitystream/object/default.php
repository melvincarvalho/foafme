<?php
/**
 * Elgg default object view
 *
 * @package Elgg
 * @subpackage Core
 * @author Curverider Ltd
 * @link http://elgg.org/
 */

$title = $vars['entity']->title;
if (empty($title)) {
	$subtitle = strip_tags($vars['entity']->description);
	$title = substr($subtitle,0,32);
	if (strlen($subtitle) > 32) {
		$title .= " ...";
	}
}

?>

<item>
<guid isPermaLink='true'><?php echo htmlspecialchars($vars['entity']->getURL()); ?></guid>
<pubDate><?php echo date("r",$vars['entity']->time_created) ?></pubDate>
<link><?php echo htmlspecialchars($vars['entity']->getURL()); ?></link>
<title><![CDATA[<?php echo $title; ?>]]></title>
<description><![CDATA[<?php echo (autop($vars['entity']->description)); ?>]]></description>
<?php
		// following works for both annotations and regular
		// objects, instead of getOwner or getOwnerEntity which have different behaviour.
		$owner = get_user($vars['entity']->owner_guid);
		if ($owner) {
?>
<dc:creator><?php echo $owner->name; ?></dc:creator>
<?php
		}
?>
<?php
		if (
			($vars['entity'] instanceof Locatable) &&
			($vars['entity']->getLongitude()) &&
			($vars['entity']->getLatitude())
		) {
			?>
			<georss:point><?php echo $vars['entity']->getLatitude(); ?> <?php echo $vars['entity']->getLongitude(); ?></georss:point>
			<?php
		}
?>
<?php echo elgg_view('extensions/item'); ?>
</item>
