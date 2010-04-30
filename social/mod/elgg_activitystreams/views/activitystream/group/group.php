<?php
/**
 * Elgg default group view
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
<content type="html"><![CDATA[<?php echo (autop($vars['entity']->description)); ?>]]></content>
<?php
		$owner = $vars['entity']->getOwnerEntity();
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
</entry>
<?php

                $group_guid = $vars['entity']->getGUID();
                $limit = 20;  // TODO: make configurable

                $offset = (int) get_input('offset', 0);

                $sql = "SELECT {$CONFIG->dbprefix}river.id, {$CONFIG->dbprefix}river.type, {$CONFIG->dbprefix}river.subtype, {$CONFIG->dbprefix}river.action_type, {$CONFIG->dbprefix}river.access_id, {$CONFIG->dbprefix}river.view, {$CONFIG->dbprefix}river.subject_guid, {$CONFIG->dbprefix}river.object_guid, {$CONFIG->dbprefix}river.posted FROM {$CONFIG->dbprefix}river INNER JOIN {$CONFIG->dbprefix}entities AS entities1 ON {$CONFIG->dbprefix}river.object_guid = entities1.guid INNER JOIN {$CONFIG->dbprefix}entities AS entities2 ON entities1.container_guid = entities2.guid WHERE entities2.guid = $group_guid OR {$CONFIG->dbprefix}river.object_guid = $group_guid ORDER BY posted DESC limit {$offset},{$limit}";

                $riveritems = get_data($sql);
		
		echo elgg_view('river/item/list',array(
                        'limit' => $limit,
                        'offset' => $offset,
                        'items' => $riveritems,
                        'pagination' => false
                ));

?>

