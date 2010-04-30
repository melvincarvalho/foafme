<?php

	/**
	 * A simple view to provide the user with group filters and the number of group on the site
	 **/
	 
	 $members = $vars['count'];
	 if(!$num_groups)
	 	$num_groups = 0;
	 	
	 $filter = $vars['filter'];
	 
	 //url
	 $url = $vars['url'] . "mod/members/index.php";
	 $url_ext = $vars['url'] . "pg/vazco_gmap/";
	 $url_ext2 = $vars['url'] . "pg/vazco_karma/";

?>
<div id="elgg_horizontal_tabbed_nav">

<ul>
<?php if (is_plugin_enabled('vazco_gmap')){?>
	<li <?php if($filter == "map") echo "class='selected'"; ?>><a href="<?php echo $url_ext; ?>members/extend/?filter=map"><?php echo elgg_echo('members:sort:map'); ?></a></li>
<?php }?>
	<li <?php if($filter == "karma") echo "class='selected'"; ?>><a href="<?php echo $url_ext2; ?>members/extend/?filter=karma"><?php echo elgg_echo("members:sort:karma")?></a></li>

	<li <?php if($filter == "newest") echo "class='selected'"; ?>><a href="<?php echo $url; ?>?filter=newest"><?php echo elgg_echo("members:sort:newest")?></a></li>
	<li <?php if($filter == "pop") echo "class='selected'"; ?>><a href="<?php echo $url; ?>?filter=pop"><?php echo elgg_echo("members:sort:popular")?></a></li>
	<li <?php if($filter == "active") echo "class='selected'"; ?>><a href="<?php echo $url; ?>?filter=active"><?php echo elgg_echo("members:sort:active")?></a></li>
</ul>
</div>

<div class="group_count">
	<?php
		echo $members . " " . elgg_echo("members:active");
	?>
</div>