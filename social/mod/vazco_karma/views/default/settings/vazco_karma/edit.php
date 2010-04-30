<?php
	global $CONFIG;
	
	$entity =  $vars['entity'];
	$karma = new vazco_karma();
	$ranks = $entity->ranks;
	if (!$ranks) 
		$ranks = $karma->getDefaultRanks();
	
	if (!$entity->showPointsOnProfile) {
	    $entity->showPointsOnProfile = "yes";
    }
?>
<div class="karma_general_settings">
	<p  class="karma_header"><?php echo elgg_echo('vazco_karma:settings:ranks'); ?></p>
	<p><?php echo elgg_echo('vazco_karma:settings:ranks:desc'); ?>
		<?php echo elgg_view('input/longtext', array('internalname' => 'params[ranks]', 'value' => $ranks)); ?>
	</p>
	<p>
	    <?php echo elgg_echo('vazco_karma:settings:rank:admin'); ?> 
	    <select name="params[adminHasHighestRank]">
	        <option value="yes" <?php if ($vars['entity']->adminHasHighestRank == 'yes') echo " selected=\"yes\" "; ?>><?php echo elgg_echo('option:yes'); ?></option>
	        <option value="no" <?php if ($vars['entity']->adminHasHighestRank != 'yes') echo " selected=\"yes\" "; ?>><?php echo elgg_echo('option:no'); ?></option>
	    </select> 
	</p>	
	
	<p>
	    <?php echo elgg_echo('vazco_karma:settings:showPointsOnProfile'); ?> 
	    <select name="params[showPointsOnProfile]">
	        <option value="yes" <?php if ($vars['entity']->showPointsOnProfile != 'no') echo " selected=\"yes\" "; ?>><?php echo elgg_echo('option:yes'); ?></option>
	        <option value="no" <?php if ($vars['entity']->showPointsOnProfile == 'no') echo " selected=\"yes\" "; ?>><?php echo elgg_echo('option:no'); ?></option>
	    </select> 
	</p>
	<p>
	    <?php echo elgg_echo('vazco_karma:settings:showPointsOnListings'); ?> 
	    <select name="params[showPointsOnListings]">
	        <option value="yes" <?php if ($vars['entity']->showPointsOnListings != 'no') echo " selected=\"yes\" "; ?>><?php echo elgg_echo('option:yes'); ?></option>
	        <option value="no" <?php if ($vars['entity']->showPointsOnListings == 'no') echo " selected=\"yes\" "; ?>><?php echo elgg_echo('option:no'); ?></option>
	    </select> 
	</p>
</div>

<div class="karma_login_settings">
	<p class="karma_header"><?php echo elgg_echo('vazco_karma:settings:login')?></p>
	<p><span><?php echo elgg_echo('vazco_karma:settings:period:notlogin'); ?></span>
		<?php echo elgg_view('input/text', array('internalname' => 'params[notloginPeriod]','class' => ' ', 'value' => $entity->notloginPeriod)); ?>
	</p>
	<p><span><?php echo elgg_echo('vazco_karma:settings:points:notlogin'); ?></span>
		<?php echo elgg_view('input/text', array('internalname' => 'params[notloginPoints]','class' => ' ', 'value' => $entity->notloginPoints)); ?>
	</p>
	
	<p><span><?php echo elgg_echo('vazco_karma:settings:period:login'); ?></span>
		<?php echo elgg_view('input/text', array('internalname' => 'params[loginPeriod]','class' => ' ', 'value' => $entity->loginPeriod)); ?>
	</p>
	<p><span><?php echo elgg_echo('vazco_karma:settings:points:login'); ?></span>
		<?php echo elgg_view('input/text', array('internalname' => 'params[loginPoints]','class' => ' ', 'value' => $entity->loginPoints)); ?>
	</p>
</div>



<div class="karma_login_settings">
	<p class="karma_header"><?php echo elgg_echo('vazco_karma:settings:activity')?></p>
	<p><span><?php echo elgg_echo('vazco_karma:settings:points:wire'); ?></span>
		<?php echo elgg_view('input/text', array('internalname' => 'params[wirePoints]','class' => ' ', 'value' => $entity->wirePoints)); ?>
	</p>
	<p><span><?php echo elgg_echo('vazco_karma:settings:points:photo'); ?></span>
		<?php echo elgg_view('input/text', array('internalname' => 'params[photoPoints]','class' => ' ', 'value' => $entity->photoPoints)); ?>
	</p>
	<p><span><?php echo elgg_echo('vazco_karma:settings:points:comment:add'); ?></span>
		<?php echo elgg_view('input/text', array('internalname' => 'params[commentAddPoints]','class' => ' ', 'value' => $entity->commentAddPoints)); ?>
	</p>
	<p><span><?php echo elgg_echo('vazco_karma:settings:points:photo:change'); ?></span>
		<?php echo elgg_view('input/text', array('internalname' => 'params[photoChangePoints]','class' => ' ', 'value' => $entity->photoChangePoints)); ?>
	</p>
	<p><span><?php echo elgg_echo('vazco_karma:settings:points:blog:change'); ?></span>
		<?php echo elgg_view('input/text', array('internalname' => 'params[blogChangePoints]','class' => ' ', 'value' => $entity->blogChangePoints)); ?>
	</p>
	<p><span><?php echo elgg_echo('vazco_karma:settings:points:blog:add'); ?></span>
		<?php echo elgg_view('input/text', array('internalname' => 'params[blogAddPoints]','class' => ' ', 'value' => $entity->blogAddPoints)); ?>
	</p>
	
	<p><span><?php echo elgg_echo('vazco_karma:settings:points:invite'); ?></span>
		<?php echo elgg_view('input/text', array('internalname' => 'params[invitePoints]','class' => ' ', 'value' => $entity->invitePoints)); ?>
	</p>
	<p><span><?php echo elgg_echo('vazco_karma:settings:inbox:send'); ?></span>
		<?php echo elgg_view('input/text', array('internalname' => 'params[inboxSendPoints]','class' => ' ', 'value' => $entity->inboxSendPoints)); ?>
	</p>
	<p><span><?php echo elgg_echo('vazco_karma:settings:inbox:receive'); ?></span>
		<?php echo elgg_view('input/text', array('internalname' => 'params[inboxReceivePoints]','class' => ' ', 'value' => $entity->inboxReceivePoints)); ?>
	</p>
	<p><span><?php echo elgg_echo('vazco_karma:settings:polls'); ?></span>
		<?php echo elgg_view('input/text', array('internalname' => 'params[pollVotePoints]','class' => ' ', 'value' => $entity->pollVotePoints)); ?>
	</p>
	<p><span><?php echo elgg_echo('vazco_karma:settings:rating:self'); ?></span>
		<?php echo elgg_view('input/text', array('internalname' => 'params[ratingSelfPoints]','class' => ' ', 'value' => $entity->ratingSelfPoints)); ?>
	</p>
	<p><span><?php echo elgg_echo('vazco_karma:settings:rating:others'); ?></span>
		<?php echo elgg_view('input/text', array('internalname' => 'params[ratingOthersPoints]','class' => ' ', 'value' => $entity->ratingOthersPoints)); ?>
	</p>
	<p><span><?php echo elgg_echo('vazco_karma:settings:points:group:create'); ?></span>
		<?php echo elgg_view('input/text', array('internalname' => 'params[groupCreatePoints]','class' => ' ', 'value' => $entity->groupCreatePoints)); ?>
	</p>
	
	
	<p><span><?php echo elgg_echo('vazco_karma:settings:points:read:discussion'); ?></span>
		<?php echo elgg_view('input/text', array('internalname' => 'params[readDiscussion]','class' => ' ', 'value' => $entity->readDiscussion)); ?>
	</p>
	<p><span><?php echo elgg_echo('vazco_karma:settings:points:read:page'); ?></span>
		<?php echo elgg_view('input/text', array('internalname' => 'params[readPage]','class' => ' ', 'value' => $entity->readPage)); ?>
	</p>
	<p><span><?php echo elgg_echo('vazco_karma:settings:points:read:blog'); ?></span>
		<?php echo elgg_view('input/text', array('internalname' => 'params[readBlog]','class' => ' ', 'value' => $entity->readBlog)); ?>
	</p>
	<p><span><?php echo elgg_echo('vazco_karma:settings:points:post:msgboard'); ?></span>
		<?php echo elgg_view('input/text', array('internalname' => 'params[postMsgBoard]','class' => ' ', 'value' => $entity->postMsgBoard)); ?>
	</p>
</div>

<div class="karma_misc_settings">
	<p class="karma_header"><?php echo elgg_echo('vazco_karma:settings:misc')?></p>
	<p><span><?php echo elgg_echo('vazco_karma:settings:points:group:users'); ?></span>
		<?php echo elgg_view('input/text', array('internalname' => 'params[groupUserPoints]','class' => ' ', 'value' => $entity->groupUserPoints)); ?>
	</p>
	<p><span><?php echo elgg_echo('vazco_karma:settings:points:group:forum'); ?></span>
		<?php echo elgg_view('input/text', array('internalname' => 'params[groupForumPoints]','class' => ' ', 'value' => $entity->groupForumPoints)); ?>
	</p>
	<p><span><?php echo elgg_echo('vazco_karma:settings:points:friendof'); ?></span>
		<?php echo elgg_view('input/text', array('internalname' => 'params[friendOfPoints]','class' => ' ', 'value' => $entity->friendOfPoints)); ?>
	</p>
	<p><span><?php echo elgg_echo('vazco_karma:settings:points:friend'); ?></span>
		<?php echo elgg_view('input/text', array('internalname' => 'params[friendPoints]','class' => ' ', 'value' => $entity->friendPoints)); ?>
	</p>
</div>
<p>&nbsp;</p>
<p><a href="<?php echo $CONFIG->wwwroot;?>action/vazco_karma/updateranks"><?php echo elgg_echo('vazco_karma:settings:updateranks')?></a></p>