<?php
 /**
  * Elgg Chat plugin
  *
  * @license GNU Public License version 3
  * @author Felix Stahlberg <fstahlberg@gmail.com>
  * @link http://www.xilef-software.de/en/projects/scripts/elggchat
  * @see http://www.phpfreechat.net/
  */
	 
if (get_plugin_setting('strict_access', 'chat')) {
  gatekeeper();
}

// a bit ugly.. nevermind, there is nothing difficult/important here..
if (get_plugin_setting('use_popup', 'chat')) {
  echo '<a href="#" onclick="' .
    "chat_open('" . $vars['url'] . 'pg/chat\')"';
} else {
  echo '<a href="' . $vars['url'] . 'pg/chat"';
}

echo ' id="chat_open_chat_link" class="chat_open' . (chat_is_query() ? '_query' : '') . 
  ' usersettings" title="' . elgg_echo('chat:open') . '">' . elgg_echo('Chat') . '</a>';
?>
