<?php
/**
 * Elgg captcha plugin
 *
 * @package ElggVisualCaptcha
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Brett Profitt
 * @copyright Curverider Ltd 2008-2009
 * @link http://elgg.com/
 */

function visual_captcha_init() {
	global $CONFIG;
	require_once dirname(__FILE__) . '/visual_captcha_lib.php';

	// register the goodness.
	run_function_once('visual_captcha_runonce');

	// @todo pull these into setting options
	$CONFIG->visual_captcha_images_match = 4;
	$CONFIG->visual_captcha_images_show = 8;

	// Register page handler for captcha functionality
	register_page_handler('vc_image', 'visual_captcha_page_handler');

	// Add our CSS
	elgg_extend_view('css', 'visual_captcha/css');

	// Register a function that provides some default actions to check for captchas
	// Other plugins can register a similar action to append to the array of actions
	// returned in visual_captcha_actionlist_hook().
	register_plugin_hook('actionlist', 'captcha', 'visual_captcha_actionlist_hook');

	// clean out our unused captchas during cron garbage collection
	register_plugin_hook('gc', 'system', 'visual_captcha_gc');

	// Emit a hook to grab a list of actions to intecept,
	// then register a that action with our captcha verification function
	$actions = array();
	$actions = trigger_plugin_hook('actionlist', 'captcha', null, $actions);

	if (($actions) && (is_array($actions))) {
		foreach ($actions as $action) {
			register_plugin_hook('action', $action, 'visual_captcha_verify_action_hook');
		}
	}
}

/**
 * Visual captcha runonce.  Adds subtypes and custom classes and resets the stored images
 * in case we're upgrading.
 * @return unknown_type
 */
function visual_captcha_runonce() {
	global $CONFIG;

	$ignore_access = elgg_set_ignore_access(TRUE);

	// force remove all other images in case we're upgrading.
	$images = elgg_get_entities(array(
		'type' => 'object',
		'subtype' => 'visual_captcha_image',
		'limit' => 100
	));

	foreach ($images as $image) {
		$image->delete();
	}

	// register an image
	add_subtype('object', 'visual_captcha_image', 'ElggVisualCaptchaImage');

	// register our default images
	$img_dir = dirname(__FILE__) . '/graphics/';

	if (!$handle = opendir($img_dir)) {
		return FALSE;
	}

	while (FALSE !== ($file = readdir($handle))) {
		if ($file != '.' && $file != '..') {
			$location = $img_dir . $file;
			$hint = strtolower(str_replace('.png', '', $file));

			$image = new ElggVisualCaptchaImage();
			$image->setImageLocation($location);
			$image->setLanguageHint($hint, 'simple');

			$image->save();
		}
	}

	elgg_set_ignore_access($ignore_access);
}

/**
 * Serve up icons for image based on image token.
 *
 * @param array $page
 */
function visual_captcha_page_handler($page) {
	global $CONFIG;

	if (isset($page[0])) {
		$image_token = str_replace('.png', '', $page[0]);
		$image = visual_captcha_get_image_entity_by_image_token($image_token);
		$image->display();
	}
}

/**
 * Verify a click order vs an instance token.
 *
 * @param string $instance_token
 * @param string $click_order
 * @return bool
 */
function visual_captcha_verify($instance_token, $click_order) {
	try {
		$captcha = new ElggVisualCaptcha($instance_token);
	} catch (Exception $e) {
		register_error($e->getMessage());
		forward($_SERVER['HTTP_REFERER']);
	}

	$verified = $captcha->verifyClickOrder($click_order);

	// can only use an instance once.
	$captcha->delete();

	if (!$verified) {
		register_error(elgg_echo('visual_captcha:captcha_fail'));
		forward($_SERVER['HTTP_REFERER']);
	}

	return $verified;
}

/**
 * Clean out unused visual captcha entities.
 */
function visual_captcha_gc($hook, $entity_type, $returnvalue, $params) {
	global $CONFIG, $DB_QUERY_CACHE, $DB_PROFILE, $ENTITY_CACHE;

	if ($params['period'] != 'weekly') {
		return $returnvalue;
	}

	$ia = elgg_set_ignore_access(TRUE);

	$options = array(
		'type' => 'object',
		'subtype' => 'visual_captcha'
	);

	while ($captchas) {
		foreach ($captchas as $captcha) {
			$DB_QUERY_CACHE = $DB_PROFILE = $ENTITY_CACHE = array();

			$captcha->delete();
		}
	}

	
	elgg_set_ignore_access($ia);
}

/**
 * Listen for the action plugin hook and check the captcha.
 *
 * @param unknown_type $hook
 * @param unknown_type $entity_type
 * @param unknown_type $returnvalue
 * @param unknown_type $params
 */
function visual_captcha_verify_action_hook($hook, $entity_type, $returnvalue, $params) {
	$instance_token = get_input('visual_captcha_token');
	$click_order = get_input('visual_captcha_click_order');

	return visual_captcha_verify($instance_token, $click_order);
}

/**
 * This function returns an array of actions the captcha will expect a captcha for, other plugins may
 * add their own to this list thereby extending the use.
 *
 * @param unknown_type $hook
 * @param unknown_type $entity_type
 * @param unknown_type $returnvalue
 * @param unknown_type $params
 */
function visual_captcha_actionlist_hook($hook, $entity_type, $returnvalue, $params) {
	if (!is_array($returnvalue)) {
		$returnvalue = array();
	}

	$returnvalue[] = 'register';
	$returnvalue[] = 'user/requestnewpassword';

	return $returnvalue;
}

register_elgg_event_handler('init', 'system', 'visual_captcha_init');
