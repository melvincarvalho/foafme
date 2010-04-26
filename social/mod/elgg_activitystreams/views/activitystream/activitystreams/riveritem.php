<?php
	$item = $vars['item'];
	$body = elgg_view($item->view,array('item' => $item),false,false,'default');
	$time = date(DateTime::ATOM,$item->posted);
	if ($entity = get_entity($item->object_guid)) {
	    $url = htmlspecialchars($entity->getURL());
	    $time_created = date(DateTime::ATOM, $entity->time_created);
	if (has_access_to_entity($entity)) {
	$subject = get_entity($item->subject_guid);
	$title = strip_tags($body);
	if ($subject->getSubtype() !== 'foreign_notification') {
	if ($entity instanceof ElggGroup) {
		$container = $entity;
	} else {
		$container = get_entity($entity->container_guid);
		if (!$container) {
			$container = $entity;
		}
	}

?>
        <entry>
                <id><?php echo $url.$item->id; ?></id>
                <published><?php echo $time_created; ?></published>
                <updated><?php echo $time; ?></updated>
                <link rel="alternate" type="text/html"><?php echo $url; ?></link>
                <title><![CDATA[<?php echo $title; ?>]]></title>
                <content type="html"><![CDATA[<?php echo (autop($body)); ?>]]></content>
                <activity:verb>http://activitystrea.ms/schema/1.0/post</activity:verb>
                <activity:verb>http://elgg.org/activitystreams/actions/<?php echo $item->action_type; ?></activity:verb>
<?php
		echo elgg_view('activitystreams/author', array(
				'entity'=>$subject));
		echo elgg_view('activitystreams/activityobject', array(
				'id'=>$url,
				'name'=>'object',
				'entity'=>$entity));
		echo elgg_view('activitystreams/activityobject', array(
				'id'=>htmlspecialchars($container->getURL()),
				'name'=>'target',
				//'link'=>$vars['url']."pg/riverdashboard/element/".$item->id,
				'entity'=>$container));

?>
        </entry>
<?php
	}}}
?>
