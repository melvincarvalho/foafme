<?php

	/**
	 * Elgg vazco_topbar plugin
	 * 
	 * @author Michal Zacher [michal.zacher@gmail.com]
	 * @website www.elggdev.com
	 */

if (isloggedin()) {?>
	<div id="elgg_topbar_container_middle">
		<a href="<?php echo $vars['url']; ?>action/logout"><small><?php echo elgg_echo('logout'); ?></small></a>
	</div>
<?php }else{
	//pokaz panel logowania
		if ($vars['disable_security']!=true)
		{
			$ts = time();
			$token = generate_action_token($ts);
			$security_header = elgg_view('input/hidden', array('internalname' => '__elgg_token', 'value' => $token));
			$security_header .= elgg_view('input/hidden', array('internalname' => '__elgg_ts', 'value' => $ts));
		}
?>
		<div id="elgg_topbar_container_middle">			
			<form id="loginform_top" action="<?php echo $vars['url']; ?>action/login" method="POST" >
			<a class="loginbox_top_link" href="<?php echo $vars['url'];?>account/register.php"><?php echo elgg_echo('register');?></a>
				<a class="loginbox_top_link" href="<?php echo $vars['url'];?>account/forgotten_password.php"><?php echo elgg_echo('user:password:lost');?></a>
				<?php echo $security_header; ?>
				<small><?php echo elgg_echo('username');?></small>
				<input type="text"   name="username" value="" id="username"/>
				<small><?php echo elgg_echo('password');?></small>
				<input type="password"   name="password" value="" id="password"/> 
				<input id="login_remember" type="checkbox" value="true" name="persistent"/>
				<?php echo elgg_echo('user:persistent');?>
				<input class="login_button" type="submit" src="" value="<?php echo elgg_echo('login:short');?>"/>

 				<!-- <a href="<?php echo $vars['url']; ?>account/register.php"><?php echo elgg_echo('register:short');?></a>--> 
			</form>
		</div>
<?php 	
	}
?>