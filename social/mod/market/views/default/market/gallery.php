<?php

	/**
	 * Elgg Market Plugin
	 * @package market (forked from webgalli's Classifieds Plugin)
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author slyhne
	 * @copyright TechIsUs
	 * @link www.techisus.dk
	 */

		// Get info
		if (isset($vars['entity']) && $vars['entity'] instanceof ElggEntity) {
			$markettype = $vars['entity']->universal_marketcategories;
		}
		$marketguid = $vars['entity']->guid;
		$owner = $vars['entity']->getOwnerEntity();
		//$marketcreated = sprintf(elgg_echo("market:strapline"), date("G:H j/m-Y",$vars['entity']->time_created));
		$ownerlink = "<a href=\"{$owner->getURL()}\">{$owner->name}</a>";
		$info = sprintf(elgg_echo("market:created:gallery"), $ownerlink, date("G:H j/m-Y",$vars['entity']->time_created));
		$by = elgg_echo('by');
		$icon = "<img src=\"" . $CONFIG->wwwroot."mod/market/icon.php?marketguid=".$marketguid."&size=medium\" />";
		$title = $vars['entity']->title;
		if(get_plugin_setting('market_comments', 'market') != 'no'){
    			$num_comments = elgg_count_comments($vars['entity']);
    			$comments = "(" . $num_comments . " " . sprintf(elgg_echo("market:replies")) . ")";
		}

		// Make title fit in thumbs
		if ( strlen ($title) >= 19){
			$title = substr_replace($title, '...', 18);
		}

		// Display everything
		echo "<div class=\"market_gallery_item\">";
		echo "<div class=\"market_gallery_title\">" . elgg_echo($markettype) . ":<br><a href=\"{$vars['entity']->getURL()}\">" . $title . "</a></div>";
		echo "<div class=\"market_gallery_content\">" . elgg_echo('market:price') . " : " . $vars['entity']->price . "<br>" . $comments . "</div>";
		echo "<center><a href=\"{$vars['entity']->getURL()}\">" . $icon ."</a></center>";
		echo "<div class=\"market_gallery_content\">" . $info . "</div>";
		echo "</div>";


?>
