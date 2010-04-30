<?php
	/**
	 * Elgg Market Plugin
	 * @package market (forked from webgalli's Classifieds Plugin)
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author slyhne
	 * @copyright TechIsUs
	 * @link www.techisus.dk
	 */

	// Get settings
	$max = $vars['entity']->market_max;
	$adminonly = $vars['entity']->market_adminonly;
	$allowhtml = $vars['entity']->market_allowhtml;
	$numchars = $vars['entity']->market_numchars;
	$pmbutton = $vars['entity']->market_pmbutton;
	$custom = $vars['entity']->market_custom;
	$customchoices = $vars['entity']->market_custom_choices;
	$comments = $vars['entity']->market_comments;
	$marketcategories = $vars['entity']->market_categories;

?>
<p>
<?php echo elgg_echo('market:max:posts'); ?>
<select name="params[market_max]">
  <option value="1" <?php if ($max == 1) echo "selected=\"yes\" "; ?>>1</option>
  <option value="2" <?php if ($max == 2) echo "selected=\"yes\" "; ?>>2</option>
  <option value="3" <?php if ($max == 3) echo "selected=\"yes\" "; ?>>3</option>
  <option value="4" <?php if ($max == 4) echo "selected=\"yes\" "; ?>>4</option>
  <option value="5" <?php if ($max == 5) echo "selected=\"yes\" "; ?>>5</option>
  <option value="10" <?php if ($max == 10) echo "selected=\"yes\" "; ?>>10</option>
  <option value="20" <?php if ($max == 20) echo "selected=\"yes\" "; ?>>20</option>
  <option value="30" <?php if ($max == 30) echo "selected=\"yes\" "; ?>>30</option>
  <option value="0" <?php if (!$max || $vars['entity']->market_max == 0) echo "selected=\"yes\" "; ?>><?php echo elgg_echo('market:unlimited'); ?></option>
</select>	
</p>
<br />
<p>
<?php echo elgg_echo('market:adminonly'); ?> 
<select name="params[market_adminonly]">
  <option value="yes" <?php if($adminonly == 'yes') echo " selected=\"yes\""; ?>><?php echo elgg_echo('option:yes'); ?></option>
  <option value="no" <?php if($adminonly != 'yes') echo " selected=\"yes\""; ?>><?php echo elgg_echo('option:no'); ?></option>
</select> 
</p>
<br />
<p>
<?php echo elgg_echo('market:allowhtml'); ?> 
<select name="params[market_allowhtml]">
  <option value="yes" <?php if($allowhtml == 'yes') echo " selected=\"yes\""; ?>><?php echo elgg_echo('option:yes'); ?></option>
  <option value="no" <?php if($allowhtml != 'yes') echo " selected=\"yes\""; ?>><?php echo elgg_echo('option:no'); ?></option>
</select> 
</p>
<br />
<p>
<?php echo elgg_echo('market:numchars'); ?>
<input name="params[market_numchars]" size="4" value="<?php echo $numchars; ?>" <?php if ($allowhtml != 'no') echo "disabled"; ?>> 
</p>
<br />
<p>
<?php echo elgg_echo('market:pmbutton'); ?> 
<select name="params[market_pmbutton]">
  <option value="yes" <?php if ($pmbutton == 'yes') echo "selected=\"yes\""; ?>><?php echo elgg_echo('option:yes'); ?></option>
  <option value="no" <?php if ($pmbutton != 'yes') echo "selected=\"yes\""; ?>><?php echo elgg_echo('option:no'); ?></option>
</select> 
</p>
<br />
<p>
<?php echo elgg_echo('market:comments'); ?> 
<select name="params[market_comments]">
  <option value="yes" <?php if ($comments != 'no') echo "selected=\"yes\""; ?>><?php echo elgg_echo('option:yes'); ?></option>
  <option value="no" <?php if ($comments == 'no') echo "selected=\"yes\""; ?>><?php echo elgg_echo('option:no'); ?></option>
</select> 
</p>
<br />
<hr>
<?php
	echo elgg_echo('market:categories:explanation');
	echo "<br><br>";
	echo elgg_echo('market:categories:settings:categories');
	echo elgg_view('input/tags',array('value' => $marketcategories, 'internalname' => 'params[market_categories]'));
?>
<br>
<hr>
<p>
<?php echo elgg_echo('market:custom:activate'); ?> 
<select name="params[market_custom]">
  <option value="yes" <?php if ($custom == 'yes') echo "selected=\"yes\""; ?>><?php echo elgg_echo('option:yes'); ?></option>
  <option value="no" <?php if ($custom != 'yes') echo "selected=\"yes\""; ?>><?php echo elgg_echo('option:no'); ?></option>
</select>
</p>
<br>
<?php
	echo elgg_echo('market:custom:choices');
	echo "<br><br>";
	echo elgg_echo('market:custom:settings');
	echo elgg_view('input/tags',array('value' => $customchoices, 'internalname' => 'params[market_custom_choices]'));
?>
