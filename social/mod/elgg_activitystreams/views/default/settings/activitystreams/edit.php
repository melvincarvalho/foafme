<?php
/**
 *	Barter Plugin
 *	@package Barters
 **/

	$hub = activitystreams_get_hub();
	
?>
<p>
	<?php echo elgg_echo('activitystreams:hub'); ?>
	<?php echo elgg_view('input/text', array('internalname' => 'params[hub]','value' => $hub)); ?>
</p>

