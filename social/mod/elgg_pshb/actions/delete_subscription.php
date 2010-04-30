<?php
        admin_gatekeeper();

		$guid = get_input('guid');
		if ($entity = get_entity($guid)) {
			
			if ($entity->canEdit() || isadminloggedin()) {
				
				if ($entity->delete()) {
					
					system_message(elgg_echo("pshb:delete:success"));
					forward("pg/pshb/subscribe");					
					
				}
				
			}
			
		}
		
		register_error(elgg_echo("bookmarks:delete:failed"));
		forward("pg/pshb/subscribe");					

?>
