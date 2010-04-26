<?php

	$english = array(
		
		'vazco_topbar:settings:linklist' => '<b>Define the links for the topbar</b><br/>
		<br/>
		<b>To add a new tool box, use format:</b><br/>
		|| Tool box name | Link address | type<br/>
		Types are:<br/>
		0 - visible for everyone<br/>
		1 - visible for logged in users<br/>
		2 - visible for admins only<br/>
		Types are not required, default type is 0
		<b>To add elements to the toolbox, use format:</b><br/>
		Link name | Link address | type<br/><br/>
		Placing addresses on boxes is not required:<br/>
		|| Tool box name<br/>
		You have to place address (even empty) if you want to set box type though:<br/>
		|| Tool box name | | 1<br/>',
		'vazco_topbar:title' =>	'User links',
	
		'vazco_topbar:settings:loginbar' => "Show Toolbar with login form for not logged users",
		'vazco_topbar:settings:loginbox' => "Show login box on main page",
		'login:short' => 'Login',
		'vazco_topbar:settings:loginremark' => '[ You can\'t turn off login box and toolbar at once. There will be always at least one active login option. ]',
	
		/*Plugin settings*/
		'vazco_topbar:settings:joinicontools' => 'Join user\'s profile icon and tools',
		'vazco_topbar:settings:joinsettings' => 'Move account settings to "my profile" dropdown',
		'vazco_topbar:settings:elgglogo' => 'Show Elgg logo in the topbar',
		'vazco_topbar:settings:topbar' => 'Show/hide topbar elements',
		'vazco_topbar:preview' => 'Preview the main page',
		'vazco_topbar:preview:description' => '(save your plugin changes before previewing)',
		'vazco_topbar:settings:homebutton' => 'Show home button',
		'vazco_topbar:settings:userlinks' => 'Allow users to define their own links',
	
		/*Topbar texts*/
		'vazco_topbar:profile:icon' => 'My profile',
		'vazco_topbar:editprofile' => 'Edit profile',
		'vazco_topbar:userslinks' => 'User links',
		'vazco_topbar:home' => 'Home',
		'vazco_topbar:welcomemessage' => 'Welcome,',
		'vazco_topbar:profile:editprofile' => 'Edit profile',
		'vazco_topbar:profile:editicon' => 'Edit icon',
		'vazco_topbar:profile:settings' => 'Settings',
	
		/*Administration*/
		'vazco_mainpage:menu:short' => 'Mainpage widgets',
		'defaultwidgets:menu:dashboard:short' => 'Pulpit widgets',
		'defaultwidgets:menu:profile:short' => 'Profile widgets',
		'defaultwidgets:menu:user:short' => 'Users',
		'defaultwidgets:menu:forms:short' => 'Forms',
		'vazco_avatar:menu:short' => 'User avatars',
		'vazco_ads:menu:short' => 'Advertisements',
		'vazco_spotlight:menu:short' => 'Spotlight',
		'vazco_gifts:menu:short' => 'Gift list',
		'vazco_topbar:tidypics:short' => 'Tidypics',
		'vazco_topbar:menu:short' => 'Topbar',
		'vazco_moderation:menu:short' => 'Moderation',
		'vazco_pages:menu:short' => 'Pages',

		'vazco_topbar:title:administration' =>	'Topbar links',
	
		/*User links texts*/
		'vazco_topbar:link:desc' => 'Set link\'s target parameter to:',
		'vazco_topbar:link:self' => 'Self',
		'vazco_topbar:link:blank' => 'Blank',
		'vazco_topbar:link:nofollow' => 'Give link a nofollow attribute',
		'vazco_topbar:boxname' => 'Box name: ',
		'vazco_topbar:boxaddress' => 'URL:',
		'vazco_topbar:boxtype' => 'Visible for:',
		'vazco_topbar:linkname' => 'Name:',
		'vazco_topbar:linkaddress' => 'URL:',
		'vazco_topbar:linktype'	=> 'Visible for:',
		'vazco_topbar:type:0' => 'everyone',
		'vazco_topbar:type:1' => 'logged in',
		'vazco_topbar:type:2' => 'admin',
		'vazco_topbar:showlinks' => 'show links',
		'vazco_topbar:hidelinks' => 'hide links',
		
		/*Template*/
		'vazco_topbar:settings:template' => 'Choose topbar\'s template:',
		'vazco_topbar:template:blue' => 'Blue',
		'vazco_topbar:template:violet' => 'Violet',
		'vazco_topbar:template:red' => 'Red',
		'vazco_topbar:template:ocean' => 'Ocean',
		'vazco_topbar:template:green' => 'Green',
		'vazco_topbar:settings:template:notactive' => '[ You can get templates for your topbar <a href="http://www.elggdev.com/vazco_topbar_template">here</a> ]',
		'vazco_topbar:messages' => 'Messages: %s',
		'vazco_topbar:nomessages' => 'My mail',
	);
					
	add_translation("en",$english);
?>
