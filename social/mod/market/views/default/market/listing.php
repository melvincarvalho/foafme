<?php
	/**
	 * Elgg Market Plugin
	 * @package market (forked from webgalli's Classifieds Plugin)
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author slyhne
	 * @copyright TechIsUs
	 * @link www.techisus.dk
	 */

		if (isset($vars['entity']) && $vars['entity'] instanceof ElggEntity) {
			$markettype = $vars['entity']->universal_marketcategories;
		}
		$marketguid = $vars['entity']->guid;
		$markettype = elgg_echo($markettype);
		$owner = $vars['entity']->getOwnerEntity();
		$ownerlink = "<a href=\"{$owner->getURL()}\">{$owner->name}</a>";
		$marketcreated = sprintf(elgg_echo("market:created:listing"), $ownerlink, date("G:H j/m-Y",$vars['entity']->time_created));
    		$num_comments = elgg_count_comments($vars['entity']);
		if(get_plugin_setting('market_comments', 'market') != 'no'){
   			$comments =  "| " . $num_comments . " " . sprintf(elgg_echo("market:replies"));
		}
		$pricetxt = elgg_echo('market:price');
		$price = $vars['entity']->price;

		if ($vars['entity']->canEdit()) {
		$edit_link = "<a href=\"".$vars['url']."mod/market/edit.php?marketpost=".$vars['entity']->getGUID()."\">".elgg_echo("edit")."</a>";
		$delete_link = elgg_view("output/confirmlink", array(
						'href' => $vars['url'] . "action/market/delete?marketpost=" . $vars['entity']->getGUID(),
						'text' => elgg_echo('delete'),
						'confirm' => elgg_echo('deleteconfirm'),
									));
		}
		$icon = "<p><a href=\"{$vars['entity']->getURL()}\"><img src=\"".$CONFIG->wwwroot."mod/market/icon.php?marketguid=".$marketguid."&size=small\" class=\"icon\" /></a></p>";
		$info = "<p>{$markettype} : <a href=\"{$vars['entity']->getURL()}\">{$vars['entity']->title}</a>{$comments}</p>";
		$info .= "<p class=\"owner_timestamp\">{$marketcreated}<div class=\"market_links\">{$delete_link} {$edit_link}</div></p>";
		$info .= "<p class=\"owner_timestamp\">{$pricetxt} : {$price}</p>";
		echo elgg_view_listing($icon,$info);
?>
