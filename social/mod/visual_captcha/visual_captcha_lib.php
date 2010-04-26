<?php
/**
 * Elgg visual captcha helper functions and classes
 *
 * @package ElggVisualCaptcha
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Brett Profitt
 * @copyright Brett Profitt 2008-2009
 * @link http://elgg.org/
 */

/**
 * Returns an image entity based on its image token.
 *
 * @param str $image_token
 * @return ElggVisualCaptchaImage
 */
function visual_captcha_get_image_entity_by_image_token($image_token) {
	$images = elgg_get_entities_from_metadata(array(
		'type' => 'object',
		'subtype' => 'visual_captcha_image',
		'metadata_value' => "$image_token",
		'limit' => 1
	));

	if ($images) {
		return $images[0];
	}
	return FALSE;
}

/**
 * Class to simplify displaying of images.
 */
class ElggVisualCaptchaImage extends ElggObject {
	protected function initialise_attributes() {
		parent::initialise_attributes();

		// override the default file subtype.
		$this->attributes['subtype'] = 'visual_captcha_image';

		// images must always be public
		$this->attributes['access_id'] = ACCESS_PUBLIC;
	}

	/**
	 * Sets image location for this file
	 * @param str $location
	 * @return bool
	 */
	public function setImageLocation($location) {
		return $this->image_location = $location;
	}

	/**
	 * Set the language hint for this image.
	 *
	 * @param str $hint
	 * @param str hint difficulty (simple, difficult, abstract)
	 * @return bool
	 */
	public function setLanguageHint($hint, $type = 'simple') {
		$name = "vc_language_hint_$type";
		return $this->$name=$hint;
	}

	/**
	 * Get the language hint for this image.
	 *
	 * @param str $hint
	 * @param str hint difficulty (simple, difficult, abstract)
	 * @return bool
	 */
	public function getLanguageHint($type = 'simple') {
		$name = "vc_language_hint_$type";
		return $this->$name;
	}

	/**
	 * Binds this image to a captcha instance token.
	 * Returns a display token to be used in the page handler for this image.
	 *
	 * @param str $captcha_token
	 * @return str image display token
	 */
	public function bindInstanceToken($instance_token) {
		$image_token = md5(rand());
		if (create_metadata($this->getGUID(), "vc_instance_token_$instance_token", $image_token, 'text', 0, ACCESS_PUBLIC, TRUE)) {
			return $image_token;
		}
		return FALSE;
	}

	/**
	 * Unbinds this image from a captcha instance token.
	 *
	 * @param str $instance_token
	 * @return bool
	 */
	public function unbindInstanceToken($instance_token) {
		return remove_metadata($this->getGUID(), "vc_instance_token_$instance_token");
	}

	/**
	 * Returns the url for this image based upon the token instance.
	 *
	 * @param str $instance_token
	 * @return str Url of image
	 */
	public function getImgURL($instance_token) {
		global $CONFIG;

		return "{$CONFIG->site->url}pg/vc_image/{$this->getImgToken($instance_token)}.png";
	}

	public function getImgToken($instance_token) {
		$key = "vc_instance_token_$instance_token";
		return $this->$key;
	}

	/**
	 * Displays this image to a browser.
	 */
	public function display() {
		header("Content-type: image/png");
		header('Expires: ' . date('r',time() + 864000));
		header("Pragma: public");
		header("Cache-Control: public");

		if ($h = fopen($this->image_location, 'rb')) {
			while (!feof($h)) {
				$contents = fread($h, 8192);
			}

			header('Content-length: ' . strlen($contents));
			echo $contents;
		}
		exit;
	}
}

/**
 * The Elgg Visual Captcha object handles creating a captcha instance token,
 * creating a click order, and creating the images to display.
 *
 */
class ElggVisualCaptcha extends ElggObject {
	public $images = array();

	public $click_order_info = array();

	/**
	 * Sets up the attributes for this class.
	 *
	 * @return bool
	 */
	protected function initialise_attributes() {
		parent::initialise_attributes();

		// override the default file subtype.
		$this->attributes['subtype'] = 'visual_captcha';

		// captcha must always be public
		$this->attributes['access_id'] = ACCESS_PUBLIC;
	}


	/**
	 * Create a new captcha instance or load an existing one.
	 *
	 * @param str $token
	 * @return bool on success
	 */
	public function __construct($token = NULL) {
		// create a new instance token or load the passed one.
		if ($token) {
			// passing the token because we want that saved as metadata so can't use
			// as standard member.
			$this->__load_instance($token);
		} else {
			// init the normal elgg entity
			parent::__construct(NULL);
			$this->save();
			$this->__generate_token();
		}
	}

	/**
	 * Removes all references to instance in image and plugin settings.
	 *
	 * @return bool
	 */
	public function delete() {
		$ia = elgg_set_ignore_access(TRUE);
		foreach ($this->images as $image) {
			$image->unbindInstanceToken($this->token);
		}

		$return = parent::delete();
		elgg_set_ignore_access($ia);

		return $return;
	}

	/**
	 * Returns an array of translated language hint strings in the correct click order.
	 *
	 * @return array
	 */
	public function getLanguageHintStrings() {
		$strings = array();
		foreach ($this->click_order_info as $image_info) {
			if ($image = get_entity($image_info['guid'])) {
				$strings[] = elgg_echo("visual_captcha:language_hint:{$image_info['language_hint']}");
			}
		}

		return $strings;
	}

	/**
	 * Verfy the click order for this instance.
	 *
	 * @param string $click_order as a comma separated string.
	 * @return bool
	 */
	public function verifyClickOrder($click_order) {
		$image_tokens = explode(',', $click_order);

		foreach ($this->click_order_info as $i => $info) {
			if ($info['token'] != $image_tokens[$i]) {
				return FALSE;
			}
		}

		return TRUE;
	}

	/**
	 * Generates a token, binds images to the token, and generates an image click order
	 *
	 * @return str instance token
	 */
	private function __generate_token() {
		global $CONFIG;

		// generate the captcha instance token
		$instance_token = md5(mt_rand());
		$this->token = $instance_token;
		$this->images = array();
		$this->click_order_info = array();

		// always simple for now.
		$language_hint_type = 'simple';

		// some mysql servers seem to return duplicates on RAND() even when using group by
		// doing it the hard way.
		$options = array(
			'type' => 'object',
			'subtype' => 'visual_captcha_image',
			'limit' => 1,
			'order_by' => 'RAND()'
		);

		$max = $CONFIG->visual_captcha_images_show;
		$count = 0;
		$guids = array();
		$match_imgs = array();

		while ($count < $max) {
			$img = elgg_get_entities($options);
			$img = $img[0];
			$match_imgs[] = $img;
			$guids[] = $img->getGUID();

			$options['wheres'] = array('e.guid NOT IN (' . implode(',', $guids) . ')');
			$count++;
		}

		$click_order = array();

		foreach ($match_imgs as $img) {
			if ($token = $img->bindInstanceToken($instance_token)) {
				$this->images[] = $img;
			} else {
				throw new Exception('visual_token: Cannot bind image token!');
			}

			// only generate info for the number of matches in config
			if (count($click_order) < $CONFIG->visual_captcha_images_match) {
				$language_hint = $img->getLanguageHint($language_hint_type);
				if ($token && $language_hint) {
					$click_order[] = array(
						'guid' => $img->getGUID(),
						'language_hint' => $language_hint,
						'language_hint_type' => $language_hint_type,
						'token' => $token,
					);
				}
			}
		}

		// mix things up
		shuffle($this->images);

		// save as serialized to ensure the correct order on load
		// but leave it available to be used as a property (click_order_info)
		$this->click_order_info = $click_order;
		$this->click_order_serialized = serialize($click_order);

		return $instance_token;
	}

	/**
	 * Loads an instance based on token.
	 *
	 * @return bool
	 */
	private function __load_instance($token) {
		$ia = elgg_set_ignore_access(TRUE);

		$instance = elgg_get_entities_from_metadata(array(
			'type' => 'object',
			'subtype' => 'visual_captcha',
			'metadata_name_value_pair' => array('name' => 'token', 'value' => $token)
		));

		if (is_array($instance) && !empty($instance)) {
			// yeah...we're loading ourself over ourself.
			parent::__construct($instance[0]->getGUID());
		} else {
			throw new Exception('visual_captch: Unknown token instance!');
		}

		$images = elgg_get_entities_from_metadata(array(
			'type' => 'object',
			'subtype' => 'visual_captcha_image',
			'metadata_name' => "vc_instance_token_{$token}",
			'limit' => 100,
			'order_by' => 'RAND()',
			'group_by' => 'e.guid'
		));

		if (!$images) {
			throw new Exception('visual_captch: Unknown token instance images!');
		}

		// make images and click order info available.
		$this->images = $images;
		$this->click_order_info = unserialize($this->click_order_serialized);

		elgg_set_ignore_access($ia);
	}
}
