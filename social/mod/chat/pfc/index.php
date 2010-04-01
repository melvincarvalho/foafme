<?php
/**
  * Elgg Chat plugin
  *
  * @license GNU Public License version 3
  * @author Felix Stahlberg <fstahlberg@gmail.com>
  * @link http://www.xilef-software.de/en/projects/scripts/elggchat
  * @see http://www.phpfreechat.net/
  */
 
// Start Elgg Engine
require_once(dirname(dirname(dirname(dirname(__FILE__)))) . "/engine/start.php");

if (get_plugin_setting('strict_access', 'chat')) {
  gatekeeper();
}

/*
 * PhpFreeChat Parameters
 */
global $CONFIG;
require_once dirname(__FILE__)."/src/phpfreechat.class.php";
$params = array();
$params['title'] = elgg_echo('Chat');
$params['nick'] = $_SESSION['user']->username;  // setup the intitial nickname
$params['isadmin'] = isadminloggedin();
$params['serverid'] = 'phpfreechat'; // calculate a unique id for this chat
$params['debug'] = false;
if (get_plugin_setting('container_type', 'chat') == 'Mysql') {
  $params['container_type'] = 'Mysql';
  $params['container_cfg_mysql_host'] = $CONFIG->dbhost;
  $params['container_cfg_mysql_port'] = 3306;
  $params['container_cfg_mysql_database'] = $CONFIG->dbname;
  $params['container_cfg_mysql_table'] = $CONFIG->dbprefix . "phpfreechat";
  $params['container_cfg_mysql_username'] = $CONFIG->dbuser;
  $params['container_cfg_mysql_password'] = $CONFIG->dbpass;
}
$params['theme'] = get_plugin_setting('theme', 'chat');
$params['frozen_nick'] = (get_plugin_setting('strict_access', 'chat') == 1);
$params['channels'] = explode(',', get_plugin_setting('channels', 'chat'));

$chat = new phpFreeChat($params);

if (get_plugin_setting('use_popup', 'chat')) {
  include dirname(dirname(__FILE__)) . '/popup.inc.php';
} else {
  // Format Page
  $body = elgg_view_layout('one_column', $chat->printChat(true));

  // Draw it
  echo page_draw(elgg_echo('Chat'), $body);
}

?>
