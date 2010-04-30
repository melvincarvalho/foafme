<?php
function activitystreams_get_hub() {
	$hub = get_plugin_setting("hub", "activitystreams");
	if (!$hub)
		$hub = "http://lorea.cc:8123/";
        return $hub;
}

function activitystreams_init() {
	extend_view("metatags","activitystreams/metatags");
}

register_elgg_event_handler('init','system','activitystreams_init');


?>
