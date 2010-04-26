<?php

	/**
	 * Elgg Market Plugin
	 * @package market (forked from webgalli's Classifieds Plugin)
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author slyhne
	 * @copyright TechIsUs
	 * @link www.techisus.dk
	 */

	$class = $vars['class'];
	if (!$class) $class = "input-checkboxes";
	
    foreach($vars['options'] as $label => $option) {
        //if (!in_array($option,$vars['value'])) {
        if (is_array($vars['value'])) {
        	$valarray = $vars['value'];
        	$valarray = array_map('strtolower', $valarray);
        	if (!in_array(strtolower($option),$valarray)) {
	            $selected = "";
	        } else {
	            $selected = "checked = \"checked\"";
	        }
        } else {
	    	if (strtolower($option) != strtolower($vars['value'])) {
	            $selected = "";
	        } else {
	            $selected = "checked = \"checked\"";
	        }
        }
        $labelint = (int) $label;
        if ("{$label}" == "{$labelint}") {
        	$label = $option;
        }
        
        if (isset($vars['internalid'])) $id = "id=\"{$vars['internalid']}\""; 
        $disabled = "";
        if ($vars['disabled']) $disabled = ' disabled="yes" '; 
        echo "<label><input type=\"checkbox\" $id $disabled {$vars['js']} name=\"{$vars['internalname']}[]\" value=\"".htmlentities($option, ENT_QUOTES, 'UTF-8')."\" {$selected} class=\"$class\" />".elgg_echo($label)."</label><br />";
    }

?> 
