<?php
 /**
  * Elgg Chat plugin
  *
  * @license GNU Public License version 3
  * @author Felix Stahlberg <fstahlberg@gmail.com>
  * @link http://www.xilef-software.de/en/projects/scripts/elggchat
  * @see http://www.phpfreechat.net/
  */

/**
 * Initialisation. Register page handler and extend some views.
 */
function chat_init() {
  global $CONFIG;
  // Add topbar icon
  extend_view('elgg_topbar/extend', 'chat/topbar');
  // Add link for users not logged in to access the chat
  if (!get_plugin_setting('strict_access', 'chat') && !isloggedin()) {
    if (get_plugin_setting('use_popup', 'chat')) {
      add_menu(elgg_echo('Chat'), "javascript:chat_open('" . $CONFIG->wwwroot . "pg/chat')");
    } else {
      add_menu(elgg_echo('Chat'), $CONFIG->wwwroot . 'pg/chat');
    }
  }
  // Add styles
  extend_view('css', 'chat/css');
  // Add javascript stuff
  extend_view('metatags','chat/metatags');
  // Register page handler and translations
  register_page_handler('chat', 'chat_page_handler');
  register_translations($CONFIG->pluginspath . "chat/languages/");
}

/**
 * Sole pagehandler, which handles embbeded *and* popuped pages.
 */
function chat_page_handler($page) {
  @include(dirname(__FILE__) . "/pfc/index.php");
}

/**
 * Returns if there is a actual query for the current user
 */
function chat_is_query() {
  return isset($_COOKIE['chat_elgg_notify_status']) &&
    $_COOKIE['chat_elgg_notify_status'] == 'notify';
}

register_elgg_event_handler('init', 'system', 'chat_init');

?>
