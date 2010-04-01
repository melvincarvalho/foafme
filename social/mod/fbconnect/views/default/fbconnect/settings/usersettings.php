<?php
	/**
	 * User settings for fbconnect.
	 * 
	 * @package twitterlogin
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Kevin Jardine
	 * @copyright Curverider 2009
	 * @link http://elgg.org/
	 */

	$options = array(elgg_echo('fbconnect:settings:yes')=>'yes',
		elgg_echo('fbconnect:settings:no')=>'no',
	);
	
	$user = page_owner_entity();
    if (!$user) {    	
    	$user = $_SESSION['user'];
    }
    
    $subtype = $user->getSubtype();

	if( $subtype == 'facebook') {
		$facebook_controlled_profile = $user->facebook_controlled_profile;
	
		if (!$facebook_controlled_profile) {
			$facebook_controlled_profile = 'yes';
		}
?>
	<h3><?php echo elgg_echo('fbconnect:user_settings_title'); ?></h3>
	
	<p><?php echo elgg_echo('fbconnect:user_settings_description'); ?></p>
	
<?php
	echo elgg_view('input/radio',array('internalname' => "facebook_controlled_profile", 'options' => $options, 'value' => $facebook_controlled_profile));
	 } else if (!$subtype) {
	 	$facebook_uid = $user->facebook_uid;
		?>
	<h3><?php echo elgg_echo('fbconnect:facebook_login_title'); ?></h3>
	
	<p><?php echo elgg_echo('fbconnect:facebook_login_description'); ?></p>
	
<?php
		echo '<p>'.elgg_view('input/text',array('internalname' => "facebook_uid", 'value' => $facebook_uid)).'</p>';
	 }
?>