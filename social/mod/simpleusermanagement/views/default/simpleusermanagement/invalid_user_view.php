<?php

    /**
     * Elgg simpleusermanagement disabled user view
     *
     * @package simpleusermanagement
     * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
     * @author Pjotr Savitski
     * @copyright (C) Pjotr Savitski
     * @link http://code.google.com/p/simpleusermanagement/
     **/    

    if ($vars['user'] && $vars['user'] instanceof ElggUser) {
        // Drfaine entity
        $invalid_user = $vars['user'];
        $useractivationbyemail_enabled = $vars['useractivation_byemail_enabled'];
        $ts = time();
        $token = generate_action_token($ts);

        $single_addition = '<div class="simpleusermanagement_single_user_listing">';
        $single_addition .= '<div class="simpleusermanagement_single_user_parameter"><span>' . elgg_echo('username') . ':</span> ' . $invalid_user->username . '</div>';
        $single_addition .= '<div class="simpleusermanagement_single_user_parameter"><span>' . elgg_echo('simpleusermanagement:user_created') . ':</span> ' . date('d.m.Y', $invalid_user->getTimeCreated()) . '</div>';
        $single_addition .= '<div class="simpleusermanagement_single_user_parameter"><span>' . elgg_echo('name') . ':</span> ' . $invalid_user->name . '</div>';
        $single_addition .= '<div class="simpleusermanagement_single_user_parameter"><span>' . elgg_echo('email') . ':</span> ' . $invalid_user->email . '</div>';
        $single_addition .= '<div class="simpleusermanagement_single_user_actioncontrols">';
        // Activate
        $single_addition .= elgg_view('output/confirmlink', array(
            'href' => $CONFIG->wwwroot . 'action/simpleusermanagement/activate_user?user_guid=' . $invalid_user->guid . '&__elgg_token=' . $token . '&__elgg_ts=' . $ts,
            'text' => elgg_echo('simpleusermanagement:button_activate'),
            'confirm' => sprintf(elgg_echo('simpleusermanagement:activate_user_confirm'), $invalid_user->name),
        ));
        // Delete
        $single_addition .= '&nbsp;&nbsp;';
        $single_addition .= elgg_view('output/confirmlink', array(
            'href' => $CONFIG->wwwroot . 'action/simpleusermanagement/delete_pending_user?user_guid=' . $invalid_user->guid . '&__elgg_token=' . $token . '&__elgg_ts=' . $ts,
            'text' => elgg_echo('simpleusermanagement:button_delete'),
            'confirm' => sprintf(elgg_echo('simpleusermanagement:delete_pending_user_confirm'), $invalid_user->name),
		));
		// Change email address
		$single_addition .= '&nbsp;&nbsp;';
		$single_addition .= '<a href="#" onclick="simpleusermanagementShowEmailChange(' . $invalid_user->guid . ', \'' . $invalid_user->email . '\');">' . elgg_echo('simpleusermanagement:change_email') . '</a>';
        // Resend email
        if ($useractivationbyemail_enabled) {
            $single_addition .= '&nbsp;&nbsp;';
            $single_addition .= elgg_view('output/confirmlink', array(
                'href' => $CONFIG->wwwroot . 'action/simpleusermanagement/resend_activation_email?user_guid=' . $invalid_user->guid . '&__elgg_token=' . $token . '&__elgg_ts=' . $ts,
                'text' => elgg_echo('simpleusermanagement:button_resend_activation_email'),
                'confirm' => sprintf(elgg_echo('simpleusermanagement:simpleusermanagement:resend_activation_email_confirm'), $invalid_user->name),
            ));
        }
        $single_addition .= '</div>';
        $single_addition .= '</div>';
        echo $single_addition;
    }
?>
