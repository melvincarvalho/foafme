<?php

    /**
     * Elgg simpleusermanagement invalid users search form
     *
     * @package simpleusermanagement
     * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
     * @author Pjotr Savitski
     * @copyright (C) Pjotr Savitski
     * @link http://code.google.com/p/simpleusermanagement/
	 **/

     $search_form = "";

	 $search_form .= '<div id="search-box">';

     
	 $search_form .= '<b>'.elgg_echo('simpleusermanagement:user_search_box').'</b>';
	 $search_form .= elgg_view('input/text', array('internalname' => 'search_criteria', 'internalid' => 'search_criteria', 'value' => ''));
	 $search_form .= elgg_view('input/submit', array('value' => elgg_echo('simpleusermanagement:search_invalid_users'), 'js' => 'onclick="simpleusermanagementSearchInvalidUsers();"'));
	 $search_form .= '</div>';

	 echo $search_form;

?>
