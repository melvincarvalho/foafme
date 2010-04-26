<?php
/**
 * @package Elgg
 * @subpackage Core
 * @author Curverider Ltd
 * @link http://elgg.org/
 */

if (isset($vars['items']) && is_array($vars['items'])) {
	$i = 0;
	if (!empty($vars['items'])) {
		foreach($vars['items'] as $item) {
			// echo elgg_view_river_item($item);
			if (get_entity($item->object_guid) && elgg_view_exists($item->view,'default')) {
				echo elgg_view('activitystreams/riveritem',array('item'=>$item));

			}

			$i++;
			if ($i >= $vars['limit']) {
				break;
			}
		}
	}
}
?>
