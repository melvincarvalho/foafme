<?php
/**
 * Elgg default user view
 *
 * @package Elgg
 * @subpackage Core
 * @author Curverider Ltd
 * @link http://elgg.org/
 */

?>

<entry>
<id><?php echo $vars['entity']->getURL(); ?></id>
<published><?php echo date(DateTime::ATOM,$vars['entity']->time_created) ?></published>
<updated><?php echo date(DateTime::ATOM,$vars['entity']->time_updated) ?></updated>
<link rel="alternate" type="text/html"><?php echo $vars['entity']->getURL(); ?></link>
<title><![CDATA[<?php echo (($vars['entity']->name)); ?>]]></title>
<description><![CDATA[<?php echo (autop($vars['entity']->description)); ?>]]></description>
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
</entry>
<?php
echo elgg_view_river_items($vars['entity']->getGUID());
?>
