<?php

require_once(dirname(dirname(dirname(__FILE__))) . '/mod/pshb/lib/publisher.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/mod/pshb/lib/PuSHSubscriber.inc');

/***************************************************
 * Subscriber interfaces
 */
class ElggPshbSubscription implements PuSHSubscriptionInterface {
	public $domain;
	public $subscriber_id;
	public $hub;
	public $topic;
	public $secret;
	public $status;
	public $post_fields;
	public $entity;
	// storage backend for subscriptions
	public function __construct($domain, $subscriber_id, $hub, $topic, $secret, $status = '', $post_fields = '') {
		$this->domain = $domain;
		$this->subscriber_id = $subscriber_id;
		$this->hub = $hub;
		$this->topic = $topic;
		$this->secret = $secret;
		$this->status = $status;
		$this->post_fields = $post_fields;
		$this->entity = null;
	}
	public function save() {
		error_log("pshb: save!");
		if ($this->entity) {
			$newObject = $this->entity;
		}
		else {
			error_log("pshb: new!");
			$newObject = new ElggObject();
			$newObject->subtype = 'pshb_subscription';
			$newObject->access_id = ACCESS_PUBLIC;
			if (!$newObject->save())
				error_log("could not save");
			$this->entity = $newObject;
		}
		$newObject->domain = $this->domain;
		$newObject->subscriber_id = $this->subscriber_id;
		$newObject->hub = $this->hub;
		$newObject->topic = $this->topic;
		$newObject->secret = $this->secret;
		$newObject->status = $this->status;
		$newObject->post_fields = serialize($this->post_fields);
		error_log("saved".$this->domain.":".$this->subscriber_id.":".serialize($this->post_fields));

	}

	public static function load($domain, $subscriber_id) {
		$metadata_pairs = array('domain'=>$domain, 'subscriber_id'=>$subscriber_id);
		$entities = elgg_get_entities(array('types'=>'object', 'subtypes'=>'pshb_subscription'));
		error_log("pshb count:".count($entities));
		$entities = elgg_get_entities_from_metadata(array('metadata_name_value_pairs'=>$metadata_pairs, 'types'=>'object', 'subtypes'=>'pshb_subscription'));
		if (!$entities) {
			error_log("pshb: not load!".$domain.":".$subscriber_id.":".count($entities).$entities[0]);
			return null;
		}
		$s = $entities[0];
		error_log("pshb: load!".count(unserialize($s->post_fields)));
		$subscriber = new ElggPshbSubscription($s->domain, $s->subscriber_id, $s->hub, $s->topic, $s->secret, $s->status, unserialize($s->post_fields));
		$subscriber->entity = $s;
		return $subscriber;
	}

	public function delete() {
		if ($subscriber->entity) {
			$subscriber->entity->delete();
			$subscriber->entity = null;
		}
	}
}

class ElggPshbEnvironment implements PuSHSubscriberEnvironmentInterface {
	// A message to be displayed to the user on the current page load.
	public function msg($msg, $level = 'status') {
		system_message($msg);
		error_log("pshb msg: ".$msg);
	}
	// A log message to be logged to the database or the file system
	public function log($msg, $level = 'status') {
		error_log("pshb log: ".$msg);
	}
}

/***************************************************
 * Elgg hooks
 */

/*
 * pshb_get_hub
 *
 * get the hub address, at the moment configured on the activitystreams mod
 */
function pshb_get_hub() {
	return activitystreams_get_hub();
}

/*
 * pshb_river_update_hook
 *
 * hook to intercept river updates and distribute them on pshb
 */
function pshb_river_update_hook($hook, $entity_type, $returnvalue, $params) {
	global $CONFIG;
	$hub_url = pshb_get_hub();
	$p = new Publisher($hub_url);
	$object_guid = $params['object_guid'];
	$subject_guid = $params['subject_guid'];
	$object = get_entity($object_guid);
	$subject = get_entity($subject_guid);
	// ensure only public stuff gets notified away
	if ($object->access_id != ACCESS_PUBLIC || $subject->access_id != ACCESS_PUBLIC)
		return $returnvalue;

	// notify user endpoint
	if ($subject && $subject instanceof ElggUser) {
		$p->publish_update($subject->getURL()."?view=activitystream");
			error_log("pshb:user was successfully published to $hub_url");
	}

	// notify group endpoint
	if ($object) {
		$container = get_entity($object->container_guid);
		if ($container instanceof ElggGroup) {
			$p->publish_update($container->getURL()."?view=activitystream");
			error_log("pshb:group was successfully published to $hub_url");
		}
		elseif  ($object instanceof ElggGroup) {
			$p->publish_update($object->getURL()."?view=activitystream");
			error_log("pshb:group was successfully published to $hub_url");
		}
	}

	// notify network endpoint
	$topic_url = $CONFIG->wwwroot."mod/riverdashboard/?view=activitystream";
	if ($p->publish_update($topic_url)) {
		error_log("pshb:$topic_url was successfully published to $hub_url");
	} else {
		error_log("pshb:Ooops...");
		//print_r($p->last_response());
	}
}

/*
 * pshb_pubsub_notification
 *
 * a pshb notification has been received
 */
function pshb_pubsub_notification($raw, $domain, $subscriber_id) {
	// Parse $raw and store the changed items for the subscription identified
	// by $domain and $subscriber_id
	//error_log("pshb: something arrived!". $raw);
	$subscriber = ElggPshbSubscription::load($domain, $subscriber_id);
	$xml = @ new SimpleXMLElement($raw);
	// try to update subscriber title
	$subject_text = @current($xml->xpath("//activity:subject"));
	if ($subject_text) {
		$subscriber->entity->title = $subject_text;
		$subscriber->entity->save();
	}
        $xml->registerXPathNamespace('atom', 'http://www.w3.org/2005/Atom');
        $xml->registerXPathNamespace('activity', 'http://activitystrea.ms/schema/1.0/');
	$entries = $xml->xpath("//atom:entry");
	foreach($entries as $entry) {
        	$entry->registerXPathNamespace('atom', 'http://www.w3.org/2005/Atom');
        	$entry->registerXPathNamespace('activity', 'http://activitystrea.ms/schema/1.0/');
		//error_log(' * an entry arrived:'.$id.'\n'.$subject.' -'.$last_verb.'-> '.$object);
		//error_log(' * links:'.$subject_link.'\n'.$object_link);
		//error_log(' * times:'.$published.'\n'.$updated);
		$params = array('entry'=>$entry, 'subscriber'=>$subscriber->entity);
		trigger_plugin_hook('foreign_notification', 'foreign_notification', $params);
	}
        /*if ($hub = @current($xml->xpath("//atom:link[attribute::rel='hub']"))) {
          $hub = (string) $hub->attributes()->href;
        }
        if ($self = @current($xml->xpath("//atom:link[attribute::rel='self']"))) {
          $self = (string) $self->attributes()->href;
        }*/

}

/*
 * pshb_pubsub_page
 *
 * standard phsb response method.
 */
function pshb_pubsub_page($subscriber_id) {
	error_log("pshb_request".$subscriber_id);
      $domain = 'elgg_subs';

      $sub = PuSHSubscriber::instance($domain, $subscriber_id, 'ElggPshbSubscription', new ElggPshbEnvironment());
      $sub->handleRequest('pshb_pubsub_notification');
}

/*
 * pshb_test_subscription
 *
 * test subscription to own site
 */
function pshb_subscribeto($url) {
	$subscription_id = sha1($url . get_site_secret());
	return pshb_test_subscription($subscription_id, $url);
}

/*
 * pshb_test_subscription
 *
 * test subscription to own site
 */
function pshb_test_subscription($subscription_id, $url) {
	global $CONFIG;
	error_log('subscribe:'.$url);
	error_log('subscribe:'.$subscription_id);
	$metadata_pairs = array('subscriber_id'=>$subscription_id);
	$entities = elgg_get_entities_from_metadata(array('metadata_name_value_pairs'=>$metadata_pairs, 'types'=>'object', 'subtypes'=>'pshb_subscription'));

	if ($entities) {
	foreach ($entities as $entity) {
		$entity->delete();
	}
	}

	$sub = PuSHSubscriber::instance('elgg_subs', $subscription_id, 'ElggPshbSubscription', new ElggPshbEnvironment());
	if ($xml = $sub->subscribe($url,
			$CONFIG->wwwroot . "pg/pshb/". $subscription_id)) {
		$subscription = ElggPshbSubscription::load('elgg_subs', $subscribtion_id);
		if ($subscription) {
		$subscription->entity->title = @current($xml->xpath("//activity:subject"));
		$subscription->entity->save();
		}
		return true;
	}
	else {
		return false;
	}
}

/*
 * pshb_page_handler
 *
 * elgg page handler
 */
function pshb_page_handler($page) {
	global $CONFIG;
	// test subscription
	if ($page[0] == 'subscribe') {
	        include($CONFIG->pluginspath . "pshb/subscribe.php");
		//pshb_test_subscription("3", "https://n-1.artelibredigital.net/mod/riverdashboard/?view=activitystream");
		return;
	}
	// normal handling
	elgg_set_input_from_uri();
	$subscription_id = $page[0];
	pshb_pubsub_page($subscription_id);
}

function pshb_init() {
	global $CONFIG;
	register_action("pshb/subscribe",false, $CONFIG->pluginspath . "pshb/actions/pshb_subscribe.php");
	register_action("pshb/delete_subscription",false, $CONFIG->pluginspath . "pshb/actions/delete_subscription.php");
	if (get_context() =='admin')
                        add_submenu_item ( elgg_echo ( 'pshb:managesubscriptions' ), $CONFIG->wwwroot . 'pg/pshb/subscribe' );

	register_plugin_hook('river_update', 'river_update', 'pshb_river_update_hook');
	register_page_handler('pshb','pshb_page_handler');
	
}

register_elgg_event_handler('init','system','pshb_init');

?>
