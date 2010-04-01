<?php
require_once(dirname(dirname(__FILE__)).'/models/model.php');

// let admins configure the OpenID client

admin_gatekeeper();
	
set_context('admin');
 
$title = elgg_echo('openid_client:admin_title');
 
$content = elgg_view_title($title);
 
$content .= elgg_view("openid_client/forms/admin",
    array(
        'default_server'    => get_plugin_setting('default_server','openid_client'),
        'always_sync'       => get_plugin_setting('always_sync','openid_client'),
    	'sso'       		=> get_plugin_setting('sso','openid_client'),
        'greenlist'         => get_plugin_setting('greenlist','openid_client'),
        'yellowlist'        => get_plugin_setting('yellowlist','openid_client'),
        'redlist'           => get_plugin_setting('redlist','openid_client'),
 ));

 
$body = elgg_view_layout("two_column_left_sidebar", '', $content);

page_draw($title, $body);
