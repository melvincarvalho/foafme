<?php
	$body = '<div id="one_column">';
	$body .= elgg_view("page_elements/title",array('title'=>elgg_echo('pshb:managesubscriptions')));
	if (isadminloggedin()) {
		$body .= '<div class="contentWrapper">';
		$body .= elgg_view('form/pshb_subscribe');
		$body .= '</div>';
	}
	$body .= '<div class="contentWrapper">';
	$body .= elgg_list_entities(array('types'=>'object', 'subtypes'=>'pshb_subscription', 'full_view'=>false))."</div></div>";
	echo page_draw('pshb:subscriptions' ,$body);
?>
