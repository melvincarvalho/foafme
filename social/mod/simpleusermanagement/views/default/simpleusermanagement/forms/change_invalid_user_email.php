<?php

    /**
     * Elgg simpleusermanagement change invalid user email
     *
     * @package simpleusermanagement
     * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
     * @author Pjotr Savitski
     * @copyright (C) Pjotr Savitski
     * @link http://code.google.com/p/simpleusermanagement/
	 **/

     $label_user_email = elgg_echo('simpleusermanagement:new_user_email');
     $user_guid = elgg_view('input/hidden', array('internalname' => 'user_guid'));
     $user_email = elgg_view('input/text', array('internalname' => 'new_email'));
     $submit = elgg_view('input/submit', array('value' => elgg_echo('simpleusermanagement:change_email')));

     $form_body = <<< END
     <div>
         <div class="simpleusermanagement_form_title">$label_user_email</div>
		 $user_email
		 $user_guid
		 $submit
	 </div>
END;

    echo elgg_view('input/form', array('action' => "{$vars['url']}action/simpleusermanagement/change_user_email", 'body' => $form_body));
?>
