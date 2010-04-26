<?php 
global $CONFIG;
$user_login = $vars['user_login'];
$user = get_user_by_username($user_login);
$karma = new vazco_karma();
$points = $karma->getUserPoints($user);
$userlink = "<a href=\"".$user->getUrl()."\">".$user->username."</a>";

?>
<div class="contentWrapper">
		<p><?php echo sprintf(elgg_echo('vazco_karma:history:user'),$userlink);?></p>
		<p><?php echo sprintf(elgg_echo('vazco_karma:history:total'),$points);?></p>
		<div class="vazco_karma_history">

			<div class="title even"><?php echo elgg_echo('vazco_karma:history:notlogin');?></div><div class="value even"><?php echo $karma->getUserPoints($user,'notloginPoints')?></div>
			<div class="title"><?php echo elgg_echo('vazco_karma:history:login');?></div><div class="value"><?php echo $karma->getUserPoints($user,'loginPoints')?></div>
			<div class="title even"><?php echo elgg_echo('vazco_karma:history:photo');?></div><div class="value even"><?php echo $karma->getUserPoints($user,'photoPoints')?></div>
			<div class="title"><?php echo elgg_echo('vazco_karma:history:photo:change');?></div><div class="value"><?php echo $karma->getUserPoints($user,'photoChangePoints')?></div>
			<div class="title even"><?php echo elgg_echo('vazco_karma:history:blog:change');?></div><div class="value even"><?php echo $karma->getUserPoints($user,'blogChangePoints')?></div>
			<div class="title"><?php echo elgg_echo('vazco_karma:history:invite');?></div><div class="value"><?php echo $karma->getUserPoints($user,'invitePoints')?></div>
			<div class="title even"><?php echo elgg_echo('vazco_karma:history:blog:add');?></div><div class="value even"><?php echo $karma->getUserPoints($user,'blogAddPoints')?></div>
			<div class="title"><?php echo elgg_echo('vazco_karma:history:group:create');?></div><div class="value"><?php echo $karma->getUserPoints($user,'groupCreatePoints')?></div>
			<div class="title even"><?php echo elgg_echo('vazco_karma:history:wire');?></div><div class="value even"><?php echo $karma->getUserPoints($user,'wirePoints')?></div>
			<div class="title"><?php echo elgg_echo('vazco_karma:history:inbox:send');?></div><div class="value"><?php echo $karma->getUserPoints($user,'inboxSendPoints')?></div>
			<div class="title even"><?php echo elgg_echo('vazco_karma:history:inbox:receive');?></div><div class="value even"><?php echo $karma->getUserPoints($user,'inboxReceivePoints')?></div>
			<div class="title"><?php echo elgg_echo('vazco_karma:history:polls');?></div><div class="value"><?php echo $karma->getUserPoints($user,'pollVotePoints')?></div>
			<div class="title even"><?php echo elgg_echo('vazco_karma:history:rating:self');?></div><div class="value even"><?php echo $karma->getUserPoints($user,'ratingSelfPoints')?></div>
			<div class="title"><?php echo elgg_echo('vazco_karma:history:rating:others');?></div><div class="value"><?php echo $karma->getUserPoints($user,'ratingOthersPoints')?></div>
			<div class="title even"><?php echo elgg_echo('vazco_karma:history:group:users');?></div><div class="value even"><?php echo $karma->getUserPoints($user,'groupUserPoints')?></div>
			<div class="title"><?php echo elgg_echo('vazco_karma:history:group:forum');?></div><div class="value"><?php echo $karma->getUserPoints($user,'groupForumPoints')?></div>
			<div class="title even"><?php echo elgg_echo('vazco_karma:history:friendof');?></div><div class="value even"><?php echo $karma->getUserPoints($user,'friendOfPoints')?></div>
			<div class="title"><?php echo elgg_echo('vazco_karma:history:friend');?></div><div class="value"><?php echo $karma->getUserPoints($user,'friendPoints')?></div>
			<div class="title even"><?php echo elgg_echo('vazco_karma:history:comments');?></div><div class="value even"><?php echo $karma->getUserPoints($user,'commentAddPoints')?></div>
			<div class="title"><?php echo elgg_echo('vazco_karma:settings:points:read:discussion');?></div><div class="value"><?php echo $karma->getUserPoints($user,'readDiscussion')?></div>
			<div class="title even"><?php echo elgg_echo('vazco_karma:settings:points:read:page');?></div><div class="value even"><?php echo $karma->getUserPoints($user,'readPage')?></div>
			<div class="title"><?php echo elgg_echo('vazco_karma:settings:points:read:blog');?></div><div class="value"><?php echo $karma->getUserPoints($user,'readBlog')?></div>
			<div class="title even"><?php echo elgg_echo('vazco_karma:settings:points:post:msgboard');?></div><div class="value even"><?php echo $karma->getUserPoints($user,'postMsgBoard')?></div>

			<div class="title"><?php echo elgg_echo('vazco_karma:history:misc');?></div><div class="value"><?php echo $karma->getUserPoints($user,'general')?></div>
			<div class="clearfloat"></div>
		</div>
</div>