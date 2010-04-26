<?php

	$english = array(	
		/*Settings*/
			/*Points*/
			'vazco_karma:settings:login' => 'Login settings',
			'vazco_karma:settings:period:notlogin' => 'A period in days user has to login to not to receive penalty:',
			'vazco_karma:settings:points:notlogin' => 'Penalty for not logging in for a given amount of time (you should put negative points here):',
			'vazco_karma:settings:period:login'=>'A period in days user can log in to receive reward:',
			'vazco_karma:settings:points:login'=>'Reward for logging in frequently:',
			'vazco_karma:settings:points:wire'=>'Reward/Penalty for posting on the wire:',
			'vazco_karma:settings:points:photo'=>'Reward/Penalty for uploading a photo:',
			'vazco_karma:settings:points:photo:change'=>'Reward/Penalty for editing a photo:',
			'vazco_karma:settings:points:blog:change'=>'Reward/Penalty for editing a blog:',
			'vazco_karma:settings:points:blog:add' => 'Reward/penalty for adding a blog post:',			
			'vazco_karma:settings:points:invite'=>'Reward/Penalty for inviting new users:',
			'vazco_karma:settings:activity' => 'Activity settings',
			'vazco_karma:settings:inbox:send' => 'Reward/penalty for sending messages:',
			'vazco_karma:settings:inbox:receive' => 'Reward/penalty for receiving messages:',
			'vazco_karma:settings:polls' => 'Reward/penalty for voting in polls:',
			'vazco_karma:settings:rating:self' => 'Reward/penalty for being rated:',
			'vazco_karma:settings:rating:others' => 'Reward/penalty for rating users:',
			'vazco_karma:settings:misc' => 'Miscellaneous settings',
			'vazco_karma:settings:points:group:users' => 'Reward/penalty for every user of your group:',
			'vazco_karma:settings:points:group:forum' => 'Reward/penalty for someone posting on your group:',
			'vazco_karma:settings:points:friendof' => 'Reward/penalty for being a friend of someone:',
			'vazco_karma:settings:points:friend' => 'Reward/penalty for someone being your friend:',
			'vazco_karma:settings:points:group:create' => 'Reward/penalty for creating a group:',
			'vazco_karma:settings:points:comment:add' => 'Reward/penalty for posting a comment:',
			'vazco_karma:settings:points:read:discussion' =>'Reward/Penalty for reading a discussion post',
			'vazco_karma:settings:points:read:page' =>'Reward/Penalty for reading a page',
			'vazco_karma:settings:points:read:blog' =>'Reward/Penalty for reading a blog',
			'vazco_karma:settings:points:post:msgboard' =>'Reward/Penalty for posting on a message board',
			'vazco_karma:settings:debugmode' => 'Turn debug mode on (membership of new users will last only 15 minutes)',
			'vazco_karma:settings:rank:admin' => 'Admin always has a highest rank',
	
			/*Settings actual*/
	      	'vazco_karma:settings:showPointsOnProfile' => 'Show karma points on profile page',
			'vazco_karma:settings:showPointsOnListings' => 'Show karma points on user listings',
			'vazco_karma:settings:ranks' => 'Set ranks for users',
			'vazco_karma:settings:ranks:desc' => 'Ranks have to be set in format:<br/>
Rank name|100|icon.gif<br/>
<br/>
where:<br/>
- Rank name is the public name of the rank<br/>
- 100 is the number of points needed to get to this rank<br/>
- icon.gif is the name of the icon from the mod/vazco_karma/rank_icons/ directory (icons are not required). <br/>
<br/>
Ranks have to be set from the lowest to the highest.',
		
	
		/*Comunicates*/
		'vazco_karma:nopointsuser' => 'No user selected, or no points given.',
		'vazco_karma:pointsgiven' => 'User %s was assigned %s points.',
	
		'vazco_karma:givepoints' => 'Manage karma points',
	
		/*Titles*/
		'vazco_karma:userpoints' => 'User points',
		'vazco_karma:userpoints:current' => 'User %s has %s points.',
		'vazco_karma:userpoints:points' => 'Number of points to add/remove:',
		'vazco_karma:userpoints:points:desc' => 'This page allows you to add or remove points for a particular user. Simply put the amount of points you would like to add/remove, and hit save ( assign negative points for points removal).',
	
		/*User's profile page*/
		'vazco_karma:profile:points' => 'Karma points:',
		'vazco_karma:profile:rank' => 'Karma rank:',
		'vazco_karma:exception:wrongparams' => 'Wrong ranks parameter. Ranks need to be in format: RankName|RankPoints',
	
		/*Listing page*/
		'vazco_karma:listing:points' => 'Karma points:',
		'vazco_karma:listing:rank' => 'Rank:',
	
		/*Members list*/
		'members:sort:newest'	=> "Newest",
		'members:sort:popular'	=> "Popular",
		'members:sort:active'	=> "Logged in",
		'members:sort:karma'	=> "Highest in ranks",
		'members:sort:map' =>'Map',	
	
		'vazco_karma:settings:updateranks' => 'Update user points (usefull when mounting the plugin)',
		'vazco_karma:updaterankssuccess' => 'Karma points updated succesfully',
	
		/*History of points*/
		'vazco_karma:history:menu' => 'View history',
		'vazco_karma:history' => 'Points history',
		'vazco_karma:history:user' => 'User: <b>%s</b>',
		'vazco_karma:history:total' => 'Total number of points: <b>%s</b>',
	
		'vazco_karma:history:notlogin' => 'For not logging in frequently',
		'vazco_karma:history:login'=>'For logging in frequently:',
		'vazco_karma:history:wire'=>'For posting on the wire:',
		'vazco_karma:history:photo'=>'For uploading a photo:',
		'vazco_karma:history:photo:change'=>'For editing a photo:',
		'vazco_karma:history:blog:change'=>'For editing a blog:',
		'vazco_karma:history:blog:add' => 'For adding a blog posts:',		
		'vazco_karma:history:invite'=>'For inviting new users:',
		'vazco_karma:history:inbox:send' => 'For sending messages:',
		'vazco_karma:history:inbox:receive' => 'For receiving messages:',
		'vazco_karma:history:polls' => 'For voting in polls:',
		'vazco_karma:history:rating:self' => 'For being rated:',
		'vazco_karma:history:rating:others' => 'For rating users:',
		'vazco_karma:history:group:users' => 'For every user of your group:',
		'vazco_karma:history:group:forum' => 'For someone posting on your group:',
		'vazco_karma:history:friendof' => 'For being a friend of someone:',
		'vazco_karma:history:friend' => 'For someone being your friend:',
		'vazco_karma:history:group:create' => 'For creating new groups:',
		'vazco_karma:history:read:discussion' =>'For reading a discussion post',
		'vazco_karma:history:read:page' =>'For reading a page',
		'vazco_karma:history:read:blog' =>'For reading a blog',
		'vazco_karma:history:post:msgboard' =>'For posting on a message board',	
	
		'vazco_karma:history:misc' => 'Other:',	
		'vazco_karma:menu:history' => 'My points',
		'vazco_karma:history:comments' => 'For commenting:',
	);
					
	add_translation("en",$english);

?>
