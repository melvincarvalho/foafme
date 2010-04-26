<?php
/**
 *	Tasks Plugin
 *	@package Tasks
 *	@author Liran Tal <liran@enginx.com>
 *	@license GNU General Public License (GPL) version 2
 *	@copyright (c) Liran Tal of Enginx 2009
 *	@link http://www.enginx.com
 **/
echo elgg_view('pshb_subscription/listing', $vars);
/*
if (get_input('search_viewtype') == "full") {
	echo elgg_view("pages/pageprofile", $vars);
} else {
	if (get_input('viewtype') == "gallery") {
		echo elgg_view('tasks/gallery', $vars); 
	} else if (get_input('viewtype') == "smartlisting"){
		echo elgg_view("tasks/smartlisting", $vars);
	} else {
		echo elgg_view("tasks/listing", $vars);
	}
}*/

?>
