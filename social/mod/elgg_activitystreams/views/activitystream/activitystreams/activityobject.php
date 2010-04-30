<?php
	$url = $vars['url'];
	$name = $vars['name'];
	$entity = $vars['entity'];
?>
<activity:<?php echo $name; ?>>
<?php
	// check or generate link
	if (in_array('link', $vars) && $vars['link']) {
		$link = $vars['link'];
	}
	else {
		$link = htmlspecialchars($entity->getURL());
	}
	// check or generate id
	if (in_array('id', $vars) && $vars['id']) {
		$id = $vars['id'];
	}
	else {
		$id = $vars['url'].$entity->getGUID();
	}
	// check or generate type
	if (in_array('type', $vars) && $vars['type']) {
		$type = $vars['type'];
	}
	else {
		$type = $entity->type."/".$entity->getSubtype();
	}
	switch($type) {
		case 'object/blog':
			$type = "http://activitystrea.ms/schema/1.0/article";
			echo '<content><![CDATA['.$entity->description.']]></content>';
			break;
		case 'object/bookmarks':
			$type = "http://activitystrea.ms/schema/1.0/bookmark";
                  	echo '<link rel="related" type="text/html" href="'.$entity->address.'" />';
			echo '<summary><![CDATA['.$entity->description.']]></summary>';
			break;
		case 'object/file':
			$type = "http://activitystrea.ms/schema/1.0/file";
                  	echo '<link rel="enclosure" type="'.$file->mimetype.'" href="'.$vars['url'].'mod/file/download.php?file_guid='.$entity->getGUID().'" />';
			echo '<summary><![CDATA['.$entity->description.']]></summary>';
			break;

		case 'object/event_calendar':
			$type = "http://activitystrea.ms/schema/1.0/event";
			//$dayshift = mktime(0,0,0,0,1,0);
                  	echo '<cal:dtstart>'.date(DateTime::ATOM,$entity->start_date).'</cal:dtstart>';
			$end_date = false;
			if ($entity->end_date)
				$end_date = $entity->end_date;
			elseif ($entity->end_time)
				$end_date = $entity->start_date + (60*($entity->end_time-$entity->start_time));
			if ($end_date)
 	                 	echo '<cal:dtend>'.date(DateTime::ATOM,$end_date).'</cal:dtend>';
			echo '<summary><![CDATA['.$entity->description.']]></summary>';
			break;

		case 'user':
		case 'user/':
			$type = "http://activitystrea.ms/schema/1.0/person";
                  	echo '<link rel="photo" href="'.htmlspecialchars($entity->getIcon('tiny')).'" type="image/png" />';
			break;
		case 'group':
		case 'group/':
                  	echo '<link rel="photo" href="'.htmlspecialchars($entity->getIcon('tiny')).'" type="image/png" />';
			$type = "http://activitystrea.ms/schema/1.0/group";
			break;
		default:
			$type = "http://elgg.org/activitystreams/types/".$type;
	}

?>
                  <activity:object-type><?php echo $type; ?></activity:object-type>
                  <id><?php echo $id; ?></id>
                  <title><?php echo $entity->title?$entity->title:$entity->name; ?></title>
                  <link rel="alternate" type="text/html" href="<?php echo $link; ?>" />
                  <link rel="preview" href="<?php echo htmlspecialchars($entity->getIcon('tiny')); ?>" type="image/png" />
		  <!-- <summary>blah</summary> -->
                </activity:<?php echo $name; ?>>

