<?php

	/**
	 * Elgg Market Plugin
	 * @package market (forked from webgalli's Classifieds Plugin)
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author slyhne
	 * @copyright TechIsUs
	 * @link www.techisus.dk
	 */

	// Load the Elgg framework
	require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");

	// Get the market guid
	$marketguid = (int) get_input('marketguid');

	// Get entity data
	$object = get_entity($marketguid);
	if($object){
		$owner = $object->getOwnerEntity()->guid;
	}
		// Get the size
		$size = strtolower(get_input('size'));
			if (!in_array($size,array('large','medium','small','tiny','master')))
				$size = "medium";

		// Use master if we need the full size
			if ($size == "master")
				$size = "";
		
		// Try and get the icon
	
		$filehandler = new ElggFile();
		$filehandler->owner_guid = $owner;
		$filehandler->setFilename("market/" . $marketguid . $size . ".jpg");
		
		$success = false;
		if ($filehandler->open("read")) {
			if ($contents = $filehandler->read($filehandler->size())) {
				$success = true;
			} 
		}
	
		if (!$success) {
			global $CONFIG;
			//$path = elgg_view('icon/user/default/'.$size);
			//header("Location: {$path}");
			//exit;
			$contents = @file_get_contents($CONFIG->wwwroot . "mod/market/graphics/noimage{$size}.png");
		}

		header("Content-type: image/jpeg");
		header('Expires: ' . date('r',time() + 864000));
		header("Pragma: public");
		header("Cache-Control: public");
		header("Content-Length: " . strlen($contents));
		$splitString = str_split($contents, 1024);
		foreach($splitString as $chunk)
			echo $chunk;

?>
