<?php

	/**
	 * Elgg Market Plugin
	 * @package market (forked from webgalli's Classifieds Plugin)
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author slyhne
	 * @copyright TechIsUs
	 * @link www.techisus.dk
	 */

	// Load Elgg engine
	require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");

	// How many classifieds can a user have
	$marketmax = get_plugin_setting('market_max', 'market');
	if(!$marketmax) $marketmax = "999";

	echo "<br><h3>".elgg_echo('market:terms:title')."</h3>";
	echo "<ul>".sprintf(elgg_echo('market:terms'),$marketmax)."</ul>";
	echo "<br>";
?>

