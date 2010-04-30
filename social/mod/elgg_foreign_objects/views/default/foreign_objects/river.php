<?php

	$remote = get_entity($vars['item']->subject_guid); // $statement->getSubject();
	$subject_name = $remote->subject_name;
	$object_name = $remote->object_name;
	$subject_link = $remote->subject_link;
	$object_link = $remote->object_link;
	$title = $remote->title;
	//error_log("name:".$subject_name);
	//error_log("object:".$object_name);
	//error_log("body:".$title);
	$icon = '';
	if ($remote->container_icon && ($remote->container_type == 'http://elgg.org/activitystreams/types/group/' || $remote->container_type == 'http://activitystrea.ms/schema/1.0/group')) {
		$icon .= '<a href="'.$remote->container_link.'"><img style="right:0;top:0;position:relative;float:right;display:block;" src="'.$remote->container_icon.'" /></a>';
	}
	if (strpos($title, "href") === false) {
		if ($subject_name && !empty($subject_name))
			$title = $icon.str_replace($subject_name, '<a href="'.$subject_link.'">'.$subject_name.'</a>', $title);
		if ($object_name && !empty($object_name) && $object_name != $subject_name)
			$title = str_replace($object_name, '<a href="'.$object_link.'">'.$object_name.'</a><br />', $title);
	}
	if ($title == $remote->title) {
		$title .= '  by <a href="'.$subject_link.'">'.$subject_name.'</a>';
		$title .= '  to <a href="'.$object_link.'">'.$object_name.'</a>';
	}
	$title = str_replace('more', '', $title);
	$title .= '  <a href="'.$object_link.'">more...</a>';
	$title .= '<div class="clearfloat"></div>';
	$string .= $title;
	//$string .= $remote->container_type;
?>

<?php echo $string; ?>
