<?php

	/**
	 * Elgg vazco_topbar plugin
	 * 
	 * @author Michal Zacher [michal.zacher@gmail.com]
	 * @website www.elggdev.com
	 */
	 
		$menu = get_register('menu');
		
		//var_export($menu);

		if (is_array($menu) && sizeof($menu) > 0) {
			$alphamenu = array();
			foreach($menu as $item) {
				$alphamenu[$item->name] = $item;
			}
			ksort($alphamenu);
		$joinsettings = get_plugin_setting('joinsettings','vazco_topbar');
?>

<ul class="topbardropdownmenu">
    <li class="drop">
    <a href="<?php echo $_SESSION['user']->getURL(); ?>" class="menuitemtools"><img class="user_mini_avatar avatar_modified" src="<?php echo $_SESSION['user']->getIcon('topbar'); ?>"><?php echo(elgg_echo('vazco_topbar:profile:icon')); ?></a>
	  <ul>
	  <?php if ($joinsettings != 'no'){?>
	  <li><a href="<?php echo $vars['url']; ?>pg/settings/"><?php echo elgg_echo('settings');?></a></li>
      <?php
	  }
			foreach($alphamenu as $item) {
    			echo "<li><a href=\"{$item->value}\">" . $item->name . "</a></li>";
			} 
     ?>
      </ul>
    </li>
</ul>

<script type="text/javascript">
  $(function() {
    $('ul.topbardropdownmenu').elgg_topbardropdownmenu();
  });
</script>

<?php
		}
?>
