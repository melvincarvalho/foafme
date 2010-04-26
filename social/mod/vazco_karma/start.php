<?php

	/**
	 * Elgg members plugin
	 * This plugin has some interesting options for users; see who is online, site members, 
	 * 
	 * @package Elggmembers
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Curverider Ltd <info@elgg.com>
	 * @copyright Curverider Ltd 2008-2009
	 * @link http://elgg.com/
	 */
	require_once(dirname(__FILE__)."/models/model.php");
	
		function vazco_karma_init() {
			global $CONFIG;
			extend_view('css','vazco_karma/css');
			//Extend hover-over menu	
			extend_view('profile/menu/adminlinks','vazco_karma/menu');
			//show points and rank on profile
			extend_view('profile/icon','vazco_karma/profilepoints');
			//show points and rank on user listings
			extend_view('profile/status','vazco_karma/listingpoints');
			extend_view('object/page','vazco_karma/read/pages',501);
			extend_view('object/page_top','vazco_karma/read/pages',501);
			extend_view('object/blog','vazco_karma/read/blog',501);
			extend_view('forum/viewposts','vazco_karma/read/discussion',501);

			//register actions
			register_action("vazco_karma/points",false, $CONFIG->pluginspath . "vazco_karma/actions/points.php");
			register_action("vazco_karma/updateranks",false, $CONFIG->pluginspath . "vazco_karma/actions/updateranks.php");
			
			//handlers
			register_elgg_event_handler('login', 'user', 'vazco_karma_login_handler', 1);
			register_elgg_event_handler('create','object','vazco_karma_object_created_handler',2);
			register_elgg_event_handler('update','object','vazco_karma_object_updated_handler',2);
			register_elgg_event_handler('create','group','vazco_karma_group_created_handler',2);
			register_elgg_event_handler('create','friend','vazco_karma_friend_created_handler',400);
			register_elgg_event_handler('create','friendrequest','vazco_karma_friend_created_handler');
			register_elgg_event_handler('create','annotation','vazco_karma_annotation_handler');
			register_elgg_event_handler('delete','annotation','vazco_karma_annotation_handler');
			register_elgg_event_handler('delete', 'friend', 'vazco_karma_friend_deleted_handler');
			register_elgg_event_handler('delete', 'friendrequest', 'vazco_karma_friend_deleted_handler');
			register_elgg_event_handler('join','group','vazco_karma_group_join');
			register_elgg_event_handler('leave','group','vazco_karma_group_leave');
			register_plugin_hook('action','rate/add','vazco_karma_rate_handle',600);
			register_plugin_hook('action','poll/vote','vazco_karma_polls_handle',1);
			register_elgg_event_handler('create', 'user', 'vazco_karma_invite_handler');
			register_plugin_hook('action', 'comments/add', 'vazco_karma_add_comment_handler',800);
			register_plugin_hook('action', 'groups/addpost', 'vazco_karma_add_comment_handler',800);
			register_plugin_hook('action', 'messageboard/delete', 'vazco_karma_delete_msgboard',800);
			
			//make sure non-admin users can change the rank_points of other users
			register_plugin_hook('permissions_check:metadata', 'user', 'vazco_karma_metadata_permissions',1);
			
			register_elgg_event_handler('pagesetup','system','vazco_karma_submenus',500);
		}
		
		function vazco_karma_submenus() {
			global $CONFIG;
			$context = get_context();
			if ( ($context == 'profile' || $context == 'settings') && ( isadminloggedin() || page_owner() == get_loggedin_userid())){
				add_submenu_item(elgg_echo('vazco_karma:menu:history'), $CONFIG->wwwroot . "pg/vazco_karma/history/".page_owner_entity()->username);
			}
		}
		function vazco_karma_add_comment_handler($event, $object_type, $object)
		{
			$user = get_loggedin_user();
			$karma = new vazco_karma();
			$karma->handleAddComment($user);
			return true;
		}	

		function vazco_karma_metadata_permissions($event, $object_type, $object, $vars){
			if (isset($vars['metadata']['name']) && ( $vars['metadata']['name'] == 'rank_points'
			|| $vars['metadata']['name'] == 'notloginPoints'
			|| $vars['metadata']['name'] == 'loginPoints'
			|| $vars['metadata']['name'] == 'photoPoints'
			|| $vars['metadata']['name'] == 'photoChangePoints'
			|| $vars['metadata']['name'] == 'blogChangePoints'
			|| $vars['metadata']['name'] == 'invitePoints'
			|| $vars['metadata']['name'] == 'blogAddPoints'
			|| $vars['metadata']['name'] == 'groupCreatePoints'
			|| $vars['metadata']['name'] == 'wirePoints'
			|| $vars['metadata']['name'] == 'inboxSendPoints'
			|| $vars['metadata']['name'] == 'inboxReceivePoints'
			|| $vars['metadata']['name'] == 'readDiscussion'
			|| $vars['metadata']['name'] == 'readPage'
			|| $vars['metadata']['name'] == 'readBlog'
			|| $vars['metadata']['name'] == 'postMsgBoard'
			|| $vars['metadata']['name'] == 'rank_points'
			)){
				return true;
			}
			//return the original value of the hook (true/false in this case)
			return $object;
		}
		function vazco_karma_rate_handle($event, $object_type, $object){
			$rated_guid = (int) get_input('guid');
			$rated_entity = get_entity($rated_guid);
			$rated = $rated_entity->getOwnerEntity();
			$rating_entity = get_loggedin_user();
			$rating = $rating_entity->getOwnerEntity();

			if ($rating_entity instanceof ElggUser)
				$rating = $rating_entity;
			
			if ($rated_entity instanceof ElggUser)
				$rated = $rated_entity;

			$karma = new vazco_karma();
			if ($rating instanceof ElggUser && $rated instanceof Elgguser && $rating->getGUID() != $rated->getGUID()){
				$karma->handleRating($rated,$rating);
			}
		}
		function vazco_karma_polls_handle($event, $object_type, $object){
			$karma = new vazco_karma();
			$karma->handlePolls();
		}
		function vazco_karma_group_join($event, $object_type, $object){
			$group = $object['group'];
			$groupOwner = get_entity($group->owner_guid);
			$user = $object['user'];
			$karma = new vazco_karma();
			$karma->handleGroupJoin($user, $groupOwner);
		}
		
		function vazco_karma_group_leave($event, $object_type, $object){
			$group = $object['group'];
			$groupOwner = get_entity($group->owner_guid);
			$user = $object['user'];
			$karma = new vazco_karma();
			$karma->handleGroupLeave($user, $groupOwner);
		}
		
		function vazco_karma_invite_handler($event, $object_type, $object){
			if (($object) && ($object instanceof ElggUser)) {
				$friend_guid = (int) get_input('friend_guid',0);
				if ($friend_guid != 0){
					$user = get_entity($friend_guid);
					$karma = new vazco_karma();
					$karma->handleInviteFriend($user);
				}
			}
		}
		
		function vazco_karma_friend_deleted_handler($event, $object_type, $object){
			$karma = new vazco_karma();
			$inviter = get_entity($object->guid_one);
			$invited_user = get_entity($object->guid_two);
			$karma->handleFriendRelationshipDelete($inviter, $invited_user);
		}
		
		function vazco_karma_friend_created_handler($event, $object_type, $object){
			if ($object instanceof ElggRelationship) {
				$karma = new vazco_karma();
				$inviter = get_entity($object->guid_one);
				$invited_user = get_entity($object->guid_two);
				$karma->handleFriendRelationshipCreate($inviter, $invited_user);
			}
		}
		
		function vazco_karma_object_updated_handler($event, $object_type, $object){
			$user = get_loggedin_user();
			if ($object){
					$karma = new vazco_karma();
					$subtype = $object->subtype;
					switch($subtype){
						case get_subtype_id('object', 'image'):
							$karma->handleImageUpdate($user);
							break;
						case get_subtype_id('object', 'blog'):
							$karma->handleBlogUpdate($user);
							break;
					}
				}
		}
		function vazco_karma_delete_msgboard($event, $object_type, $object){
			$annotation_id = (int) get_input('annotation_id');
			$message = get_annotation($annotation_id);
			$user = get_entity($message->owner_guid);
			$karma = new vazco_karma();
			$karma->handleDeleteMsgBoard($user);
		}
		
		function vazco_karma_annotation_handler($event, $object_type, $object){
			$karma = new vazco_karma();
			$subtype = $object->name;			
			if ($event == 'create'){
				switch($subtype){
						case 'group_topic_post':
							//get the owner of the group that owns the post
							$user_guid = $object->getOwner()->getOwner();
							$user = get_entity($user_guid);
							$karma->handleGroupForumPostAdd($user);
							break;
						case 'messageboard':
							//get the owner of the group that owns the post
							$user_guid = $object->getOwner()->getOwner();
							$user = get_entity($user_guid);
							$karma->handlePostMsgBoard($user);
							break;
				}
			}
		}
		
		

		function vazco_karma_object_created_handler($event, $object_type, $object)
		{
			$user = get_loggedin_user();
			if ($object){
				$karma = new vazco_karma();
				$subtype = $object->subtype;
				switch($subtype){
					case get_subtype_id('object', 'thewire'):
						$karma->handleWireCreate($user);
						break;
					case get_subtype_id('object', 'image'):
						$karma->handleImageCreate($user);
						break;
					case get_subtype_id('object','messages'):
						$karma->handleInbox($object);
						break;
					case get_subtype_id('object', 'blog'):
							$karma->handleBlogCreate($user);
							break;
				}
			}
		}
		function vazco_karma_group_created_handler($event, $object_type, $object)
		{
			$user = get_loggedin_user();
	
			$karma = new vazco_karma();
			$karma->handleCreateGroup($user);
		}

		function vazco_karma_login_handler($event, $object_type, $object){
			$karma = new vazco_karma();
			$karma->handleLogin($object);
		}
		function vazco_karma_page_handler($page) {
			global $CONFIG;
			if (isset($page[0])) 
			{
				switch($page[0]) 
				{
					case "userpoints":  //view list of albums owned by container
						$user_login = $page[1];
						include($CONFIG->pluginspath . "vazco_karma/userpoints.php");
						break;
					case "history":  //view list of albums owned by container
						$user_login = $page[1];
						include($CONFIG->pluginspath . "vazco_karma/history.php");
						break;
					case "members":  //view list of albums owned by container
						if (isset($page[1])){						
							switch($page[1]){ 
								case "extend":
									echo elgg_view('vazco_karma/members');
							}
						}
					break;						
				}
			}
		}	
	
		register_page_handler('vazco_karma','vazco_karma_page_handler');		
		register_elgg_event_handler('init','system','vazco_karma_init');

?>