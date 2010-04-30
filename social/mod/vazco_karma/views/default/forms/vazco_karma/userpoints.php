<?php 
global $CONFIG;
$user_login = $vars['user_login'];
$user = get_user_by_username($user_login);
$karma = new vazco_karma();
$points = $karma->getUserPoints($user);
$userlink = "<a href=\"".$user->getUrl()."\">".$user->username."</a>";
?>
<div class="contentWrapper">
	<form action="<?php echo $vars['url']; ?>action/vazco_karma/points" method="post">
		<p><?php echo elgg_echo('vazco_karma:userpoints:points:desc');?></p>
		<p><b><?php echo sprintf(elgg_echo('vazco_karma:userpoints:current'),$userlink, $points);?></b></p>
		<p>
				<?php echo elgg_echo("vazco_karma:userpoints:points"); ?>
		</p>
		<p>
				<?php echo elgg_view("input/text",array(
															'internalname' => 'points',
				)); ?>
		</p>
		<input type="hidden" name="user_guid" value="<?php echo $user->guid;?>">
		<input type="submit" class="submit_button" value="<?php echo elgg_echo("save"); ?>" />
	</form>
</div>