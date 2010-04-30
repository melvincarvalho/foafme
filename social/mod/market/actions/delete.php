<?php

	/**
	 * Elgg Market Plugin
	 * @package market (forked from webgalli's Classifieds Plugin)
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author slyhne
	 * @copyright TechIsUs
	 * @link www.techisus.dk
	 */

	// Make sure we're logged in (send us to the front page if not)
		if (!isloggedin()) forward();

	// Get input data
		$guid = (int) get_input('marketpost');
		
	// Make sure we actually have permission to edit
		$market = get_entity($guid);
		if ($market->getSubtype() == "market" && $market->canEdit()) {
	
		// Get owning user
				$owner = get_entity($market->getOwner());
				
		// Delete the images

		$prefix = "market/".$guid;
		
				$tiny = $prefix."tiny.jpg";
				$small = $prefix."small.jpg";
				$medium = $prefix."medium.jpg";
				$large = $prefix."large.jpg";
				$master = $prefix.".jpg";
				
				if ($tiny) {

					$delfile = new ElggFile();
					$delfile->owner_guid = $owner->guid;
					$delfile->setFilename($tiny);
					$delfile->delete();
				}

				if ($small) {

					$delfile = new ElggFile();
					$delfile->owner_guid = $owner->guid;
					$delfile->setFilename($small);
					$delfile->delete();
				}

				if ($medium) {

					$delfile = new ElggFile();
					$delfile->owner_guid = $owner->guid;
					$delfile->setFilename($medium);
					$delfile->delete();
				}

				if ($large) {

					$delfile = new ElggFile();
					$delfile->owner_guid = $owner->guid;
					$delfile->setFilename($large);
					$delfile->delete();
				}

				if ($master) {

					$delfile = new ElggFile();
					$delfile->owner_guid = $owner->guid;
					$delfile->setFilename($master);
					$delfile->delete();
				}

/*				if (!$file->delete()) {
					register_error(elgg_echo("file:deletefailed"));
				} else {
					system_message(elgg_echo("file:deleted"));
				}
*/

		// Delete the market post
				$rowsaffected = $market->delete();
				if ($rowsaffected > 0) {
		
		// Success message
					system_message(elgg_echo("market:deleted"));
				} else {
					register_error(elgg_echo("market:notdeleted"));
				}
				
		// Forward to the main market page
				forward("mod/market/?username=" . $owner->username);
		}
		
?>
