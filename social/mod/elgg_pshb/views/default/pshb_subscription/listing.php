<?php
/**
 * ElggEntity default view.
 *
 * @package Elgg
 * @subpackage Core
 * @author Curverider Ltd
 * @link http://elgg.org/
 */

if ($vars['full']) {
	echo elgg_view('export/entity', $vars);
} else {
	try {
	$icon = elgg_view(
			'graphics/icon', array(
			'entity' => $vars['entity'],
			'size' => 'small',
		)
	);
	} catch(Exception $e) {
	$icon = "";
	}
	$entity =  $vars['entity'];
	if ($entity->title)
		$title = $entity->title;
	else
		$title = $entity->topic;
              /*  $newObject->subscriber_id = $this->subscriber_id;
                $newObject->hub = $this->hub;
                $newObject->topic = $this->topic;
                $newObject->secret = $this->secret;
                $newObject->status = $this->status;
                $newObject->post_fields = serialize($this->post_fields);*/
	$hub = $entity->hub;
	$status = $entity->status;

	/*$title = $vars['entity']->title;
	if (!$title) {
		$title = $vars['entity']->name;
	}
	if (!$title) {
		$title = get_class($vars['entity']);
	}*/

	$controls = "";
	if ($vars['entity']->canEdit() || isadminloggedin()) {
		$delete = elgg_view('output/confirmlink', array(
			'href' => "{$vars['url']}action/pshb/delete_subscription?guid={$vars['entity']->guid}", 
			'text' => elgg_echo('delete')
		));
		$controls .= " ($delete)";
	}

	$info = "<div><p><b><a href=\"" . $vars['entity']->getUrl() . "\">" . $title . "</a></b> $controls </p></div>";
	$info .= '<b>hub:</b> ' .$hub."   ";
	$info .= '<b>status:</b> ' .elgg_echo('pshb:state:'.$status);

	if (get_input('search_viewtype') == "gallery") {
		$icon = "";
	}

	$owner = $vars['entity']->getOwnerEntity();
	$ownertxt = elgg_echo('unknown');
	if ($owner) {
		$ownertxt = "<a href=\"" . $owner->getURL() . "\">" . $owner->name ."</a>";
	}

	$info .= "<div>".sprintf(elgg_echo("entity:default:strapline"),
		friendly_time($vars['entity']->time_created),
		$ownertxt
	);

	$info .= "</div>";

	$info = "<span title=\"" . elgg_echo('entity:default:missingsupport:popup') . "\">$info</span>";
	$icon = "<span title=\"" . elgg_echo('entity:default:missingsupport:popup') . "\">$icon</span>";

	echo elgg_view_listing($icon, $info);
}
