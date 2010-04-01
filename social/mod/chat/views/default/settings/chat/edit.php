<p style="font-weight:bold">Note: After changing the settings you have to type <em>/rehash</em> in the chat so that the new configuration is loaded.</p>
<h4>Container Type</h4>
<p>
  <select name="params[container_type]">
    <option value="File" <?php if ($vars['entity']->container_type == 'File') echo " selected=\"selected\" "; ?>>File</option>
    <option value="Mysql" <?php if ($vars['entity']->container_type == 'Mysql') echo " selected=\"selected\" "; ?>>MySQL</option>
  </select>
</p>
<p>
  Whether the chat stores his data in flat files or in the MySQL database.
</p>
<h4>Access</h4>
<p>
  <select name="params[strict_access]">
    <option value="0" <?php if (!$vars['entity']->strict_access) echo " selected=\"selected\" "; ?>>Lazy access</option>
    <option value="1" <?php if ($vars['entity']->strict_access) echo " selected=\"selected\" "; ?>>Only logged in user</option>
  </select>
<p>
  If you set <em>Lazy access</em> users not logged in can access the chat. This means that everybody can choose his nick even in one session.
</p>
<h4>Behavior</h4>
<p>
  <select name="params[use_popup]">
    <option value="1" <?php if ($vars['entity']->use_popup) echo " selected=\"selected\" "; ?>>Open PopUp</option>
    <option value="0" <?php if (!$vars['entity']->use_popup) echo " selected=\"selected\" "; ?>>Embbeded</option>
  </select>
</p>
<p>Set <em>Open PopUp</em> to open the chat in a new window so that the user are not supposed to stay on the same page. Use <em>Embbeded</em> to embbed the chat in the page. </p> 
<h4>Theme</h4>
<p>
  <select name="params[theme]">
<?php
$act_theme = $vars['entity']->theme;
$themedir = dirname(dirname(dirname(dirname(dirname(__FILE__))))) . '/pfc/themes/';
if (is_dir($themedir)) {
  if ($dh = opendir($themedir)) {
    while (FALSE !== ($theme = readdir($dh))) {
      if ($theme == '.' || $theme == '..' || !is_dir($themedir . $theme)) {
        continue;
      }
      echo '<option value="' . $theme . 
        ($theme == $act_theme ? '" selected="selected' : '') .'">' . $theme . "</option>\n";
    }
    closedir($dh);
  }
}
?>
  </select>
</p>
<p>
  You can use all available PhpFreeChat themes. If you download a new theme, place it in mod/chat/pfc/themes and activate it here afterwards.
</p>
<h4>Default Chatrooms</h4>
<p>
    <input type="text" name="params[channels]" value="<?php echo $vars['entity']->channels ?>" />
</p>
<p>
  Define the default chatrooms. You can comma-seperate futher chatrooms if you like.
</p>
