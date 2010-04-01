<?php

/**
 * Elgg openid_client admin page
 * 
 * @package openid_client
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Kevin Jardiner <kevin@radagast.biz>
 * @copyright Curverider Ltd 2008-2009
 * @link http://elgg.com/
 * 
 */

if ($vars['always_sync'] == 'yes') {
	$sync_checked = 'checked="checked"';
} else {
	$sync_checked = '';
}

if ($vars['sso'] == 'yes') {
	$sso_checked = 'checked="checked"';
} else {
	$sso_checked = '';
}

$default_server = $vars['default_server'];

$greenlist = $vars['greenlist'];
$yellowlist = $vars['yellowlist'];
$redlist = $vars['redlist'];

$action = $CONFIG->wwwroot.'action/openid_client/admin';

$default_server_title = elgg_echo('openid_client:default_server_title');
$default_server_instructions1 = elgg_echo('openid_client:default_server_instructions1');
$default_server_instructions2 = elgg_echo('openid_client:default_server_instructions2');

$server_sync_title = elgg_echo('openid_client:server_sync_title');
$server_sync_instructions = elgg_echo('openid_client:server_sync_instructions');
$server_sync_label = elgg_echo('openid_client:server_sync_label');

$sso_title = elgg_echo('openid_client:sso_title');
$sso_instructions = elgg_echo('openid_client:sso_instructions');
$sso_label = elgg_echo('openid_client:sso_label');

$lists_title = elgg_echo('openid_client:lists_title');

$lists_instruction1 = elgg_echo('openid_client:lists_instruction1');
$lists_instruction2 = elgg_echo('openid_client:lists_instruction2');
$lists_instruction3 = elgg_echo('openid_client:lists_instruction3');
$lists_instruction4 = elgg_echo('openid_client:lists_instruction4');
$lists_instruction5 = elgg_echo('openid_client:lists_instruction5');
$lists_instruction6 = elgg_echo('openid_client:lists_instruction6');

$green_list_title = elgg_echo('openid_client:green_list_title');
$yellow_list_title = elgg_echo('openid_client:yellow_list_title');
$red_list_title = elgg_echo('openid_client:red_list_title');

$ok_button_label = elgg_echo('openid_client:ok_button_label');

$security_token = elgg_view('input/securitytoken');

$body = <<<END
<div class="admin_statistics">
<form action="$action" method="post">
$security_token
<h3>$default_server_title</h3>
<p>$default_server_instructions1</p>
<p>$default_server_instructions2</p>
<p><input type="text" size="60" name="default_server" value="$default_server" /></p>
<h3>$server_sync_title</h3>
<p>$server_sync_instructions</p>
<p><input type="checkbox" name="always_sync" value="yes" $sync_checked />
$server_sync_label</p>
<h3>$sso_title</h3>
<p>$sso_instructions</p>
<p><input type="checkbox" name="sso" value="yes" $sso_checked />
$sso_label</p>
<h3>$lists_title</h3>
<p>$lists_instruction1</p>
<p>$lists_instruction2</p>
<p>$lists_instruction3</p>
<p>$lists_instruction4</p>
<p>$lists_instruction5</p>
<p>$lists_instruction6</p>
<h3>$green_list_title</h3>
<p><textarea name="greenlist" rows="5" cols="60">$greenlist</textarea></p>
<h3>$yellow_list_title</h3>
<p><textarea name="yellowlist" rows="5" cols="60">$yellowlist</textarea></p>
<h3>$red_list_title</h3>
<p><textarea name="redlist" rows="5" cols="60">$redlist</textarea></p>
<input type="submit" name="submit" value="$ok_button_label" />
</form>
</div>
END;

print $body;

?>