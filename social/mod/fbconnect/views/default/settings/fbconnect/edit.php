<?php

$body = '';

$body .= elgg_echo('fbconnect:settings:api_key:title');
$body .= '<br />';
$body .= elgg_view('input/text',array('internalname'=>'params[api_key]','value'=>get_plugin_setting('api_key', 'fbconnect')));

$body .= '<br /><br />';

$body .= elgg_echo('fbconnect:settings:api_secret:title');
$body .= '<br />';
$body .= elgg_view('input/text',array('internalname'=>'params[api_secret]','value'=>get_plugin_setting('api_secret', 'fbconnect')));

echo $body;
?>