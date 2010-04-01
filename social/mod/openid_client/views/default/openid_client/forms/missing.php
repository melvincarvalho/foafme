<?php

/**
 * Elgg openid_client missing data page
 * 
 * @package openid_client
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Kevin Jardiner <kevin@radagast.biz>
 * @copyright Curverider Ltd 2008-2009
 * @link http://elgg.com/
 * 
 * @uses the following values in $vars:
 *
 * 'openid_url'         the OpenID
 * 'email'              the user's email (if known)
 * 'fullname'           the user's full name (if known)
 * 'email_confirmation' whether the email address needs to be confirmed
 * 'code'               a magic code that associates this data with a real user
 */
 
$emailLabel = elgg_echo('openid_client:email_label');
$nameLabel = elgg_echo('openid_client:name_label');
$submitLabel = elgg_echo('openid_client:submit_label');
$cancelLabel = elgg_echo('openid_client:cancel_label');

$missing_email = elgg_echo('openid_client:missing_email');
$missing_name = elgg_echo('openid_client:missing_name');
$and = elgg_echo('openid_client:and');
$email_form = "<table><tr><td>$emailLabel</td><td><input type=".'"text" size="50" name="email" value=""></td></tr></table>';
$name_form = "<table><tr><td>$nameLabel</td><td><input type=".'"text" size="50" name="name" value=""></td></tr></table>';
$email_hidden = '<input type="hidden" name="email" value="'.$vars['email'].'"  />'."\n";
$name_hidden = '<input type="hidden" name="name" value="'.$vars['fullname'].'"  />'."\n";

if (!$vars['email'] && !$$vars['fullname']) {
	$missing_fields = $missing_email.' '.$and.' '.$missing_name;
	$visible_fields = $email_form.'<br />'.$name_form;
	$hidden_fields = '';
} elseif (!$vars['email']) {
	$missing_fields = $missing_email;
	$visible_fields = $email_form;
	$hidden_fields = $name_hidden;
} elseif (!$vars['fullname']) {
	$missing_fields = $missing_name;
	$visible_fields = $name_form;
	$hidden_fields = $email_hidden;
}

$hidden_fields .= '<input type="hidden" name="openid_code" value="'.$vars['openid_code'].'"  />'."\n";

$instructions = sprintf(elgg_echo('openid_client:missing_info_instructions'),$missing_fields);

$action = $CONFIG->wwwroot.'action/openid_client/missing';
$security_token = elgg_view('input/securitytoken');
	 
$body .= <<< END
	$instructions
	<form action="$action" method="post">
	$security_token
    <p>
        $visible_fields
    </p>
    <p>
        $hidden_fields
        <input type="submit" name="submit" value="$submitLabel" />
        <input type="submit" name="cancel" value="$cancelLabel" />
    </p>
</form>
	            
END;

echo elgg_view('page_elements/contentwrapper',array('body'=>$body));

?>