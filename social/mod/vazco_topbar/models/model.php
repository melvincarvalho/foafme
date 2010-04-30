<?php

function getUnreadMessages(){ 
	$userId = get_loggedin_userid();
	$limit = 5;
    // Get the user's inbox, this will be all messages where the 'toId' field matches their guid 
	$messages = get_entities_from_metadata_multi(array("toId" =>$userId, "readYet" => 0), "object", "messages", $userId, $limit, 0);
	return $messages;
}


class vazco_topbar{
}
?>