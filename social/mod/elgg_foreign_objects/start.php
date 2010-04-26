<?php

function foreign_object_create_object($notification, $subtype, $group, $description=false) {
	$query = array('link'=>$notification->object_link);
	$objs = elgg_get_entities_from_metadata(array('types'=>'object','subtypes'=>$subtype,'metadata_name_value_pairs'=>$query));
	if ($objs) {
		error_log("foreign objects: object exists".$notification->object_link);
		return @current($objs);
	}
	error_log("foreign objects: create".$notification->object_link.":".$description);
	$newObject = new ElggObject();
	$newObject->subtype = $subtype;
	$newObject->access_id = ACCESS_PUBLIC;
	//$newObject->owner_guid = 0;
	$newObject->title = $notification->object_name;
	if (isset($description)) {
		error_log("save description");
		$newObject->description = $description;
	}
	error_log("foreign objects: create2".$newObject->title.":".$newObject->description);
	$newObject->link = $notification->object_link;
	$newObject->icon_link = $notification->object_icon;
	$newObject->notification = $notification->getGUID();
	if ($group) {
		//$newObject->container_guid = $group->getGUID();
	}
	$newObject->save();
	$newObject->foreign = true;
	return $newObject;
}
function foreign_object_create_group($params) {

	//error_log("create group");
	$newGroup = new ElggGroup();
	$newGroup->name = $params['container_name'];
	$newGroup->access_id = ACCESS_PUBLIC;
	$newGroup->owner_guid = 0;
	$newGroup->save();
	$newGroup->link = $params['container_link'];
	$newGroup->icon_link = $params['container_icon'];
	$newGroup->foreign = true;
	//error_log("group created");
	return $newGroup;
}

function foreign_objects_parse_atom($entry) {
	$title = @current($entry->xpath("atom:title"));
	$object = @current($entry->xpath("activity:object/atom:id"));
	$published = @current($entry->xpath("atom:published"));
	$updated = @current($entry->xpath("atom:updated"));
	$author_name = @current($entry->xpath("atom:author/atom:name"));
	if (!$author_name)
		$author_name = @current($entry->xpath("//atom:author/atom:name"));
	$object_name = @current($entry->xpath("activity:object/atom:title"));
	$container_type = @current($entry->xpath("activity:target/activity:object-type"));
	$container_icon = @current($entry->xpath("activity:target/atom:link[attribute::rel='photo']/@href"));
	$object_icon = @current($entry->xpath("activity:object/atom:link[attribute::rel='preview']/@href"));
	$container_name = @current($entry->xpath("activity:target/atom:title"));
	$container_link = @current($entry->xpath("activity:target/atom:link[attribute::rel='alternate']/@href"));
	$object_link = @current($entry->xpath("activity:object/atom:link[attribute::rel='alternate']/@href"));
	$object_type = @current($entry->xpath("activity:object/activity:object-type"));
	$subject= @current($entry->xpath("atom:author/atom:id"));
	if (!$subject)
		$subject= @current($entry->xpath("atom:id"));
	$subject_link= @current($entry->xpath("atom:author/atom:link[attribute::rel='alternate']/@href"));
	if (!$subject_link)
		$subject_link= @current($entry->xpath("atom:link[attribute::rel='alternate']/@href"));
	$subject_icon= @current($entry->xpath("//atom:author/atom:link[attribute::rel='preview']/@href"));
	$verbs = $entry->xpath("activity:verb");
	$id = @current($entry->xpath("atom:id"));
	$last_verb = array_pop($verbs);
	$params = array('subject'=>$subject_link,
                                'object'=>$object_link,
                                'object_type'=>$object_type,
                                'verb'=>$last_verb,
                                'subject_name'=>$author_name,
                                'subject_icon'=>$subject_icon,
                                'container_type'=>$container_type,
                                'container_icon'=>$container_icon,
                                'object_icon'=>$object_icon,
                                'container_name'=>$container_name,
                                'container_link'=>$container_link,
                                'object_name'=>$object_name,
                                'title'=>$title,
                                'id'=>$id,
                                'published'=>strtotime($published),
                                'updated'=>strtotime($updated));
	return $params;
}


function fo_getdate($str_time) {
	return strtotime($str_time);
	$ftime = strptime($str_time, DateTime::ATOM);
	$unxTimestamp = mktime(
                    $ftime['tm_hour'],
                    $ftime['tm_min'],
                    $ftime['tm_sec'],
                    $ftime['tm_mon'] ,
                    $ftime['tm_mday'],
                   $ftime['tm_year']+1900
                 ); 
	return $unxTimestamp;
}
/*
 * pshb_river_update_hook
 *
 * hook to intercept river updates and distribute them on pshb
 */
function foreign_objects_notification_hook($hook, $entity_type, $returnvalue, $params) {
	global $CONFIG;
	if ($hook === 'foreign_notification' && $entity_type === 'foreign_notification') {
	error_log('**::'.$CONFIG->wwwroot);
	$entry = $params['entry'];
	$params = foreign_objects_parse_atom($entry);
	//foreign_objects_parse_atom($entry);
	$subject_link = $params['subject'];
	$object_link = $params['object'];
	$published = $params['published'];
	$updated = $params['updated'];
	$verb = $params['verb'];
	$title = $params['title'];
	$subscriber = $params['subscriber'];
	$query = array('atom_id'=>$params['id']);
	$notifications = elgg_get_entities_from_metadata(array('types'=>'object','subtypes'=>'foreign_notification','metadata_name_value_pairs'=>$query));
	if ($notifications) {
		error_log("notification already received".$params['id']);
		return;
	}
	//error_log("notification new received".$params['id']);
	$newObject = new ElggObject();
	$newObject->access_id = ACCESS_PUBLIC;
	$newObject->subtype = 'foreign_notification';
	$newObject->title = $title;
	$container_type = $params['container_type'];
	//error_log($params['container_type']);
	//error_log($params['container_link']);
	if ($newObject->save()) {
		$newObject->subject_link = $subject_link;
		$newObject->object_link = $object_link;
		$newObject->atom_id = $params['id'];
		$newObject->object_name = $params['object_name'];
		$newObject->object_type = $params['object_type'];
		$newObject->object_icon = $params['object_icon'];
		$newObject->subject_name = $params['subject_name'];
		$newObject->subject_icon = $params['subject_icon'];
		$newObject->container_name = $params['container_name'];
		$newObject->container_link = $params['container_link'];
		$newObject->container_icon = $params['container_icon'];
		$newObject->container_type = $params['container_type'];
		$newObject->published = $published;
		$newObject->verb = $verb;
		//error_log("check to create group");
		$group = false;
		if (($container_type == "http://elgg.org/activitystreams/types/group/" || $container_type == "http://activitystrea.ms/schema/1.0/group") && $params['container_link']) {
			$query = array('link'=>$params['container_link']);
			//error_log("about to create group");
			$groups = elgg_get_entities_from_metadata(array('types'=>'group','metadata_name_value_pairs'=>$query));
			if ($groups) {
				$group = @current($groups);
				error_log("foreign objects: group exists");
			} else {
				$group = foreign_object_create_group($params);
				error_log("foreign objects: created group");
			}
		}
		if ($params['object_type'] == "http://activitystrea.ms/schema/1.0/event") {
			$entry->registerXPathNamespace('cal', 'urn:ietf:params:xml:ns:xcal');
			$start_date = @current($entry->xpath("//activity:object/cal:dtstart"));
			$end_date = @current($entry->xpath("//activity:object/cal:dtend"));
			$description = @current($entry->xpath("//activity:object/atom:summary"));
			$obj = foreign_object_create_object($newObject, 'event_calendar', $group, $description);
			if (isset($start_date))
				$obj->start_date = fo_getdate($start_date);
			if (isset($end_date))
				$obj->end_date = fo_getdate($end_date);
			$start_date = getdate($obj->start_date);
			$end_date = getdate($obj->end_date);
			$obj->start_time = ($start_date['hours']*60)+$start_date['minutes'];
			$obj->end_time = ($end_date['hours']*60)+$end_date['minutes'];
			if (($obj->start_time == 0) && ($obj->end_time == 0))
				$obj->allday = true;
		}

		if ($params['object_type'] == "http://elgg.org/activitystreams/types/object/page") {
			$description = @current($entry->xpath("//activity:object/atom:summary"));
			$obj = foreign_object_create_object($newObject, 'page', $group, $description);
		}
		if ($params['object_type'] == "http://elgg.org/activitystreams/types/object/file" || $params['object_type'] == "http://activitystrea.ms/schema/1.0/file") {
			$description = @current($entry->xpath("//activity:object/atom:summary"));
			$download_link = @current($entry->xpath("//activity:object/atom:link[attribute::rel='enclosure']/@href"));
			$download_mime = @current($entry->xpath("//activity:object/atom:link[attribute::rel='enclosure']/@type"));
			$obj = foreign_object_create_object($newObject, 'file', $group, $description);
			$obj->download_link = $download_link;
			$obj->mimetype = $download_mime;
		}

		if ($params['object_type'] == "http://elgg.org/activitystreams/types/object/page_top") {
			$description = @current($entry->xpath("//activity:object/atom:summary"));
			$obj = foreign_object_create_object($newObject, 'page_top', $group, $description);
		}
		if ($params['object_type'] == "http://elgg.org/activitystreams/types/object/bookmarks" || $params['object_type'] == "http://activitystrea.ms/schema/1.0/bookmark") {
			$description = @current($entry->xpath("//activity:object/atom:summary"));
			$obj = foreign_object_create_object($newObject, 'bookmarks', $group, $description);
			error_log("BOOKMARK ARRIVED:".$description.":".$obj->description);
			$obj->address = @current($entry->xpath("//activity:object/atom:link[attribute::rel='related']/@href"));
		}
		if ($params['object_type'] == "http://elgg.org/activitystreams/types/object/blog" || $params['object_type'] == "http://activitystrea.ms/schema/1.0/article") {
			$description = @current($entry->xpath("//activity:object/atom:content"));
			$obj = foreign_object_create_object($newObject, 'blog', $group, $description);
		}

		if (!$obj)
			$obj = $newObject;
		//error_log(" ** notification:".$subject_link);
		if (add_to_river('foreign_objects/river', 'foreign_notification', $newObject->getGUID(), $obj->getGUID(), ACCESS_PUBLIC, $updated, 0, true))
			error_log(" ** river ok:".$params['id']);
	}
    }
	
}

function foreign_objects_init() {
	register_entity_type('object', 'foreign_notification');
        elgg_extend_view('css','foreign_objects/css');

	register_plugin_hook('foreign_notification', 'foreign_notification', 'foreign_objects_notification_hook');
	//register_page_handler('pshb','pshb_page_handler');
	
}

register_elgg_event_handler('init','system','foreign_objects_init');

?>
