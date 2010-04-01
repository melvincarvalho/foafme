<?php

// let admins configure the OpenID client

require_once(dirname(dirname(__FILE__)).'/models/model.php');

admin_gatekeeper();

$always_sync = get_input('always_sync');
$sso = get_input('sso','no');
$default_server = trim(get_input('default_server'));
$greenlist = trim(get_input('greenlist'));
$yellowlist = trim(get_input('yellowlist'));
$redlist = trim(get_input('redlist'));

set_plugin_setting('default_server',$default_server,'openid_client');
if ($always_sync) {
	set_plugin_setting('always_sync',$always_sync,'openid_client');
} else {
	set_plugin_setting('always_sync','no','openid_client');
}
if ($sso) {
	set_plugin_setting('sso',$sso,'openid_client');
} else {
	set_plugin_setting('sso','no','openid_client');
}		
set_plugin_setting('greenlist',$greenlist,'openid_client');
set_plugin_setting('yellowlist',$yellowlist,'openid_client');
set_plugin_setting('redlist',$redlist,'openid_client');

system_message(elgg_echo('openid_client:admin_response'));

forward($CONFIG->wwwroot . "pg/openid_client/admin");

