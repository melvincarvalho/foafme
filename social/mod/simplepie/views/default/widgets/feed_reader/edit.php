<?php
	$num_items = $vars['entity']->num_items;
	if (!isset($num_items)) $num_items = 10;

	$excerpt = $vars['entity']->excerpt;
	if (!isset($excerpt)) $excerpt = 0;

	$post_date = $vars['entity']->post_date;
	if (!isset($post_date)) $post_date = 0;

?>

  <p>
    <?php echo elgg_echo("simplepie:feed_url"); ?>
    <input type="text" onclick="this.select();" name="params[feed_url]" value="<?php echo htmlentities($vars['entity']->feed_url); ?>" />  
  </p>

  <p>
<?php echo elgg_echo('simplepie:num_items'); ?>
	
<?php
	echo elgg_view('input/pulldown', array(
			'internalname' => 'params[num_items]',
			'options_values' => array( '3' => '3',
                                 '5' => '5',
			                           '8' => '8',
			                           '10' => '10',
			                           '12' => '12',
			                           '15' => '15',
			                           '20' => '20',
			                         ),
			'value' => $num_items
		));
?>
  </p>

  <p>
<?php 
  echo elgg_view('input/hidden', array('internalname' => 'params[excerpt]', 'js' => 'id="params[excerpt]"', 'value' => $excerpt ));
  echo "<input class='input-checkboxes' type='checkbox' value='' name='excerptcheckbox' onclick=\"document.getElementById('params[excerpt]').value = 1 - document.getElementById('params[excerpt]').value;\" ";
  if ($excerpt) echo "checked='yes'";
  echo " />";
  echo ' ' . elgg_echo('simplepie:excerpt');
?>
  </p>  

  <p>
<?php 
  echo elgg_view('input/hidden', array('internalname' => 'params[post_date]', 'js' => 'id="params[post_date]"', 'value' => $post_date ));
  echo "<input class='input-checkboxes' type='checkbox' value='' name='post_datecheckbox' onclick=\"document.getElementById('params[post_date]').value = 1 - document.getElementById('params[post_date]').value;\" ";
  if ($post_date) echo "checked='yes'";
  echo " />";
  echo ' ' . elgg_echo('simplepie:post_date');
?>
  </p>  
