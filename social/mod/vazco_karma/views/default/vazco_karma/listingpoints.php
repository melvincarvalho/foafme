<?php
$context = get_context();
if ($context == 'members' || $context == 'vazco_karma'){
	$karma = new vazco_karma();
	if ($karma->showPointsOnListings()){
		$user = $vars['entity'];
		$points = $karma->getUserPoints($user);
		$rank = $karma->getUserRank($user);
?>
	<div class="profile_karma">
		<span class="karma_profile_header"><?php echo elgg_echo('vazco_karma:listing:points');?></span> <span class="karma_value"><?php echo $points;?></span>
		<span class="karma_profile_header2"><?php echo elgg_echo('vazco_karma:listing:rank');  ?></span> <span class="karma_value value_rank"><?php echo $rank;?></span>
	</div>
<?php 
	}
}	
?>