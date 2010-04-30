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

	// Get the specified market post
		$marketguid = (int) get_input('marketguid');
?>
<br>
<center><img src="<?php echo $CONFIG->wwwroot; ?>mod/market/icon.php?marketguid=<?php echo $marketguid; ?>&size=master" width="600"></center>
<br>
