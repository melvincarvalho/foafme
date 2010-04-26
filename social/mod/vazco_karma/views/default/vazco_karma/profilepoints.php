<?php
global $CONFIG;
if ($vars['size'] == 'large'){ 
	$karma = new vazco_karma();
	$user = $vars['entity'];
	if ($karma->showPointsOnProfile()){
		$points = $karma->getUserPoints($user);
		$rank = $karma->getUserRank($user);
?>
	<div class="karma_profile_points">
		<div><span class="karma_profile_header"><?php echo elgg_echo('vazco_karma:profile:points');?></span> <span><?php echo $points;?></span></div>
		<div><span class="karma_profile_header"><?php echo elgg_echo('vazco_karma:profile:rank');  ?></span> <span><?php echo $rank;?></span></div>
		<?php if (isadminloggedin() || $user->guid == get_loggedin_userid()){?>
		<div class="vazco_points_history"><a href="<?php echo $CONFIG->wwwroot;?>pg/vazco_karma/history/<?php echo $user->username;?>"><?php echo elgg_echo('vazco_karma:history:menu');?></a></div>
		<?php }?>
	</div>
<?php }
}?>
