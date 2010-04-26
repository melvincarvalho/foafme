<?php
	admin_gatekeeper();
	$dest_url = get_input('atom_url');
	if (pshb_subscribeto($dest_url)) {
		system_message(elgg_echo('pshb:subscribe:success'));
	}
	else {
		register_error(elgg_echo('pshb:subscribe:failure').$dest_url);
	}
	forward("pg/pshb/subscribe");
?>
