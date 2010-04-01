<?php

     /**
	 * Elgg Facebook Connect login button
	 * 
	 * @package Elgg
	 * @subpackage fbconnect
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Kevin Jardine
	 * @copyright Curverider Ltd 2009
	 * @link http://elgg.org/
	 */

// creates a button that forwards to the login action
	 
?>
<script src="http://static.ak.connect.facebook.com/js/api_lib/v0.4/FeatureLoader.js.php" type="text/javascript"></script>
<div id="facebooklogin-box"><fb:login-button onlogin="facebook_onlogin();"></fb:login-button></div>
<script type="text/javascript">
function facebook_onlogin() {
	document.location.href = "<?php echo $vars['url'] ?>action/fbconnect/login";
}
FB.init("<?php echo get_plugin_setting('api_key', 'fbconnect'); ?>", "<?php echo $vars['url']; ?>mod/fbconnect/xd_receiver.html"); 
</script>
