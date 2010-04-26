<?php

	// Load Elgg engine
	require_once(dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))) . "/engine/start.php");
	//get filter
		$filter = get_input('filter','');		
	// Get the current page's owner
		$page_owner = page_owner_entity();
		if ($page_owner === false || is_null($page_owner)) {
			$page_owner = $_SESSION['user'];
			set_page_owner($page_owner->getGUID());
		}
		
	//get filter
		$limit = get_input('limit', 20);
		$offset = get_input('offset', 0);
	
	// search options
		$tag = get_input('tag');
		
	//search members
		$area1 = elgg_view("members/search");
		
	//user name search
		if($search_name)
			$area1 .= search_for_user($search_name, $limit, 0, "", false);
			
	//user search on tag
		if($search_tag)
			$area1 .= list_user_search($search_tag, $limit);
		
	// count members
		$members = get_number_users();
		
	// title
	    $area2 = elgg_view_title(elgg_echo("members:members").'<a name="members_sort"></a>');
	    
	//get the correct view based on filter
		switch($filter){
			case "karma":
				$karma = new vazco_karma();
				$content = $karma->getListOfUsersByRanks();
			break;
			
			case 'default':
			$content = list_entities("user","",0,10,false);
			break;
		}

		$area2 .= elgg_view('page_elements/contentwrapper',array('body' => elgg_view("members/members_sort_menu", array("count" => $members, "filter" => $filter)) . $content, 'subclass' => 'members'));

    //select the correct canvas area

	    $body = elgg_view_layout("two_column_left_sidebar", '', $area2,$area1);
		
	// Display page
		page_draw(sprintf(elgg_echo('members:members'),$page_owner->name),$body);
		
?>