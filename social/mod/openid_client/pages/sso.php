<?php
require_once(dirname(dirname(__FILE__)).'/models/model.php');
global $CONFIG;

$sso = get_plugin_setting('sso','openid_client');
if (!isloggedin() && ($sso == 'yes')) {
	openid_client_handle_login();
} else {
	forward();
}
exit;
//	$url = $CONFIG->wwwroot.'action/openid_client/login';
//	$ts = time();
//	$token = generate_action_token($ts);
//	$fields = array(
//		'__elgg_token'=>$token,
//		'__elgg_ts'=>$ts,
//		'passthru_url'=>'',
//		'externalservice'=>'',
//		'username'=>urlencode($openid_url),
//	);
//
//	//url-ify the data for the POST
//	foreach($fields as $key=>$value) {
//		$fields_string .= $key.'='.$value.'&'; 
//	}
//	rtrim($fields_string,'&');
//	
//	//open connection
//	$ch = curl_init();
//	
//	//set the url, number of POST vars, POST data
//	curl_setopt($ch,CURLOPT_URL,$url);
//	//curl_setopt($ch,CURLOPT_POST,count($fields));
//	curl_setopt($ch,CURLOPT_POST,true);
//	curl_setopt($ch,CURLOPT_POSTFIELDS,$fields_string);
//	curl_setopt($ch,CURLOPT_RETURNTRANSFER,false);	
//	curl_setopt($ch,CURLOPT_FAILONERROR,true);
//	//curl_setopt($ch,CURLOPT_HEADER, true);
//	curl_setopt($ch,CURLOPT_FOLLOWLOCATION,true);
//	
//	//execute post
//	curl_exec($ch);
//	
//	//print_r (curl_getinfo($ch));
//	
//	//print $result;
//	
//	//close connection
//	curl_close($ch);

?>