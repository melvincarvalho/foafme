<?php
/**
 * Elgg RSS output pageshell
 *
 * @package Elgg
 * @subpackage Core
 * @link http://elgg.org/
 *
 */

header("Content-Type: text/xml");

// allow caching as required by stupid MS products for https feeds.
header('Pragma: public', TRUE);

echo "<?xml version='1.0'  encoding='utf-8' ?>\n";

// Set title
if (empty($vars['title'])) {
	$title = $vars['config']->sitename;
} else if (empty($vars['config']->sitename)) {
	$title = $vars['title'];
} else {
	$title = $vars['config']->sitename . ": " . $vars['title'];
}

error_log("activitystream retreived!");

// Remove RSS from URL
$url = str_replace('?view=activitystream','', full_url());
$url = str_replace('&view=activitystream','', $url);
$last_date = get_input("river_last", time());
$page_owner = page_owner_entity();
if ($page_owner instanceof ElggUser || $page_owner instanceof ElggGroup)
	$subject = $page_owner->name;
else
	$subject = $vars['config']->sitename;

?>
<feed xmlns="http://www.w3.org/2005/Atom" xmlns:activity="http://activitystrea.ms/schema/1.0/" xmlns:georss="http://www.georss.org/georss" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:cal="urn:ietf:params:xml:ns:xcal">
	<activity:subject><![CDATA[<?php echo $title; ?>]]></activity:subject>
	<link href="<?php echo htmlentities($url); ?>" />
	<link rel="hub" href="<?php echo activitystreams_get_hub(); ?>" />
	<?php '<link rel="salmon" href="<?php echo salmon_get_endpoint(); ?>" />'; ?>
	<link rel="self" href="<?php echo htmlentities(full_url()); ?>" />
	<updated><? echo date(DateTime::ATOM,$last_date); ?></updated>
	<?php echo elgg_view('extensions/channel'); ?>
	<?php

		echo $vars['body'];

	?>
</feed>
