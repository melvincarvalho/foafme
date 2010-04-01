<?php

/**
 * Elgg openid_client sync data page
 * 
 * @package openid_client
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Kevin Jardiner <kevin@radagast.biz>
 * @copyright Curverider Ltd 2008-2009
 * @link http://elgg.com/
 * 
 * @uses the following values in $vars:
 *
 * 'userid'             the user's GUID
 * 'new_email'          the user's new email
 * 'new_name'           the user's new full name
 * 'email_confirmation' whether the email address needs to be confirmed
 */
 
$emailLabel = elgg_echo('openid_client:email_label');
$nameLabel = elgg_echo('openid_client:name_label');
$submitLabel = elgg_echo('openid_client:submit_label');
$cancelLabel = elgg_echo('openid_client:cancel_label');
$noSyncLabel = elgg_echo('openid_client:nosync_label');
$instructions = elgg_echo('openid_client:sync_instructions');

$new_email = $vars['new_email'];
$new_name = $vars['new_name'];
$email_confirmation = $vars['email_confirmation'];

$user = get_user($vars['userid']);

$old_email = $user->email;
$old_name = $user->name;
$openid_url = $user->alias;

if ($new_email && $new_email != $old_email) {
	$change_fields .= '<table><tr><td><label for="emailchange"><input type="checkbox"'
	    .' id="emailchange" name="emailchange" value="yes" />'
	    ." $emailLabel</label></td><td>$old_email => $new_email</td></tr></table>\n";
	if (!$email_confirmation) {
		// the email address is from a green server, so we can change the email without a confirmation message
		// add an invitation code however to prevent this form from being forged
		// the user ident and new email address can then securely be stored in the database invitation table
		// rather than the form
		$details = openid_client_create_invitation('c',$openid_url,$vars['userid'],$new_email,$new_name);
		$form_stuff = '<input type="hidden" name="i_code" value="'.$details->code.'" />';
	} else {
		// the email will be confirmed anyway so it is safe to put it in the form
		$form_stuff .= <<< END
        <input type="hidden" name="new_email" value="$new_email" />
END;
    }
			
}
if ($new_name && $new_name != $old_name) {
	$change_fields .= '<table><tr><td><label for="namechange"><input type="checkbox"'
	    .' id="namechange" name="namechange" value="yes" />'
	    ."$nameLabel</label></td><td>$old_name => $new_name</td></tr></table>\n";
}

$action = $CONFIG->wwwroot.'action/openid_client/sync';
$security_token = elgg_view('input/securitytoken');
	
$body .= <<< END
	$instructions
	<form action="$action" method="post">
	$security_token
    <p>
        $change_fields
    </p>
    <p>
    	<label for="nosync"><input type="checkbox" id="nosync" name="nosync" value="yes" />$noSyncLabel</label>
    	<br /><br />
    	$form_stuff
        <input type="hidden" name="new_name" value="$new_name" />
        <input type="submit" name="submit" value="$submitLabel" />
        <input type="submit" name="cancel" value="$cancelLabel" />
    </p>
</form>
            
END;

echo elgg_view('page_elements/contentwrapper',array('body'=>$body));
	
?>