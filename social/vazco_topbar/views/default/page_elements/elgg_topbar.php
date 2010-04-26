<?php

	/**
	 * Elgg vazco_topbar plugin
	 * 
	 * @author Michal Zacher [michal.zacher@gmail.com]
	 * @website www.elggdev.com
	 */
?>

<?php
     if (isloggedin() || logoutbar_enabled()) {
?>

<div id="elgg_topbar" <?php if (!isloggedin()){?> class="elgg_topbar_loggedout"<?php }?>>
<?php if (isloggedin()){
		$joinicontools = get_plugin_setting('joinicontools','vazco_topbar');
		$joinsettings = get_plugin_setting('joinsettings','vazco_topbar');
		$elgglogo = get_plugin_setting('elgglogo','vazco_topbar');
		$homebutton = get_plugin_setting('homebutton','vazco_topbar');
	?>

	<div id="elgg_topbar_container_left">
	<?php 
	if ($homebutton != 'no'){
			?>
			<div class="toolbarlinks">
					<a href="<?php echo $vars['url']; ?>" class="pagelinks"><?php echo elgg_echo('vazco_topbar:home'); ?></a>
				</div>
			<?php 
		}
	?>
		<div class="toolbarimages">
			<?php if ($elgglogo != 'no'){?>
				<a href="http://www.elgg.org" target="_blank"><img src="<?php echo $vars['url']; ?>_graphics/elgg_toolbar_logo.gif" /></a>
			<?php }	?>
			<?php 
			if ($joinicontools == 'no'){?>
				<a href="<?php echo $_SESSION['user']->getURL(); ?>">
				<?php 
				if (is_plugin_enabled('vazco_avatar') && vazco_avatar::hasFlashAvatar($_SESSION['user'])){
					echo elgg_view('vazco_avatar/flashicon',array('size' => 'topbar', 'entity' => $_SESSION['user']));
				}else{
				?>
				<img class="user_mini_avatar" src="<?php echo $_SESSION['user']->getIcon('topbar'); ?>"></a>
			<?php
				} 
			}?>			
		</div>
	        <?php
				if ($joinicontools == 'no'){
				?>
					<div class="toolbarlinks">
						<a href="<?php echo $vars['url']; ?>pg/dashboard/" class="pagelinks"><?php echo elgg_echo('dashboard'); ?></a>
					</div>
				<?php
			        echo elgg_view("navigation/topbar_tools");
				}
	        ?>
	        	
	        	
	   <div class="toolbarlinks2">		
			<?php
			if ($joinicontools != 'no'){
					echo elgg_view('vazco_topbar/topbar_tools');
				?>
				<div class="toolbarlinks">
					<a href="<?php echo $vars['url']; ?>pg/dashboard/" class="pagelinks"><?php echo elgg_echo('dashboard'); ?></a>
				</div>
				<?php 
			}
			//allow people to extend this top menu
			echo elgg_view('elgg_topbar/extend', $vars);
			if ($joinsettings == 'no'){
			?>
			<a href="<?php echo $vars['url']; ?>pg/settings/" class="usersettings"><?php echo elgg_echo('settings'); ?></a>
			<?php
			}
			?>
			<?php if (isadminloggedin()){?>
			<a href="<?php echo $vars['url']; ?>pg/admin/plugins" class="usersettings"><?php echo elgg_echo('admin'); ?></a>
			<?php }?>
		</div>
	</div>
	
	
	<div id="elgg_topbar_container_right">
			<a href="<?php echo $vars['url']; ?>action/logout"><small><?php echo elgg_echo('logout'); ?></small></a>
	</div>
	
	<div id="elgg_topbar_container_search">
	<form id="searchform" action="<?php echo $vars['url']; ?>search/" method="get">
		<input type="text" size="21" name="tag" value="Search" onclick="if (this.value=='Search') { this.value='' }" class="search_input" />
		<input type="submit" value="Go" class="search_submit_button" />
	</form>
	</div>
<?php }else{?>
	<div id="elgg_topbar_container_search">
		<?php echo elgg_view("vazco_topbar/loginbox");?>
	</div>
	<?php }?>
	</div><!-- /#elgg_topbar -->
	
	<div class="clearfloat"></div>
	
<?php
    }
?>