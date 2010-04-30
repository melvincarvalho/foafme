<?php
	global $CONFIG;
	admin_gatekeeper();
	//take params from request
	$params = get_input('params', array());
	foreach($params as $name=>$value){
		set_plugin_setting($name,$value,'vazco_topbar');	
	}
	
	$boxes = $_POST['boxes'];
	$links = $_POST['links'];
	$boxname = $_POST['boxname'];
	$boxaddress = $_POST['boxaddress'];
	$boxtype = $_POST['boxtype'];
	$linkname = $_POST['linkname'];
	$linkaddress = $_POST['linkaddress'];
	$linktype = $_POST['linktype'];
	
	$linksboxes = "";
	for($i=0;$i<$boxes;$i++)
	{
		if(!empty($boxname[$i])){
			$linksboxes .="||".$boxname[$i]."|".$boxaddress[$i]."|".$boxtype[$i]."\n";
			
		}
		for($j=0;$j<$links;$j++)
		{
			if(!empty($linkname[$i][$j]))
				$linksboxes .=$linkname[$i][$j]."|".$linkaddress[$i][$j]."|".$linktype[$i][$j]."\n";
		}
	
	}
	
	set_plugin_setting('linklist',$linksboxes,'vazco_topbar');

elgg_view_regenerate_simplecache();
elgg_filepath_cache_reset();
	
forward($_SERVER['HTTP_REFERER']);
?>