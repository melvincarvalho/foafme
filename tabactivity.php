<?php

//-----------------------------------------------------------------------------------------------------------------------------------
//
// Filename   : tabactivity.php                                                                                                  
// Date       : 15th October 2009
//
//
// Copyright 2008-2009 foaf.me
//
// This program is free software: you can redistribute it and/or modify
// it under the terms of the GNU Affero General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
// GNU Affero General Public License for more details.
//
// You should have received a copy of the GNU Affero General Public License
// along with this program. If not, see <http://www.gnu.org/licenses/>.
//
// "Everything should be made as simple as possible, but no simpler."
// -- Albert Einstein
//
//-----------------------------------------------------------------------------------------------------------------------------------

// Include the SimplePie library, and the one that handles internationalized domain names.
require_once('config.php');
require_once('db.class.php');
require_once('lib/libActivity.php');
require_once('lib/Authentication.php');
require_once('simplepie/1.1.3/simplepie.inc');
require_once('simplepie/1.1.3/idn/idna_convert.class.php');

$auth = new Authentication($GLOBALS['config']);
$agent = $auth->getAgent();

if (!empty($_REQUEST['webid'])) {
    $pageAgent = new Authentication_AgentARC($GLOBALS['config'], $_REQUEST['webid']);
    $agent = $pageAgent->getAgent();
}

$a1 = replace_with_rss($agent['holdsAccount']);
$a2 = replace_with_rss($agent['accountProfilePage']);
$a3 = (array)$agent['weblog'];

$feedArray = array_merge(  (array)$a1, (array)$a2, (array) $a3 );
$feedArray = array_unique ($feedArray);

if ( !empty($feedArray) ) {
// Initialize some feeds for use.
    $feed = new SimplePie();
    $feed->set_feed_url($feedArray);
    $no_feed = FALSE;

    // When we set these, we need to make sure that the handler_image.php file is also trying to read from the same cache directory that we are.
    $feed->set_favicon_handler('./handler_image.php');
    $feed->set_image_handler('./handler_image.php');

    // Initialize the feed.
    $feed->init();

    // Make sure the page is being served with the UTF-8 headers.
    $feed->handle_content_type();

} else {
//  $feed->set_feed_url( "http://example.com" );
    $no_feed = TRUE;
    $feed = NULL;
}

// Begin the (X)HTML page.
?>
<h2>Activity</h2>


<?php if ( ($no_feed) || ($feed->error) ): ?>
<p>No Activity Discovered Yet...</p>
<?php endif ?>


<?php if ($feed): ?>

    <?php
    // Let's loop through each item in the feed.
    foreach($feed->get_items() as $item):

    // Let's give ourselves a reference to the parent $feed object for this particular item.
        $feed = $item->get_feed();
        ?>

                <div class="chunk">
                    <?php $icon = $feed->get_favicon(); ?>
                    <?php if (!empty($icon)) { ?>
                    <img src="<?php echo $feed->get_favicon(); ?>" width="16" height="16" class="activity-favicon" alt="[icon]" />
                    <?php } ?>
                    <h4><a href="<?php echo $item->get_permalink(); ?>"><?php echo html_entity_decode($item->get_title(), ENT_QUOTES, 'UTF-8'); ?></a></h4>
                    <!-- get_content() prefers full content over summaries -->
                            <?php echo $item->get_content(); ?>

                            <?php if ($enclosure = $item->get_enclosure()): ?>
                    <div>
                                    <?php echo $enclosure->native_embed(array(
                                    // New 'mediaplayer' attribute shows off Flash-based MP3 and FLV playback.
                                    'mediaplayer' => '../demo/for_the_demo/mediaplayer.swf'
                                    )); ?>
                    </div>
                            <?php endif; ?>

                    <p class="footnote">Source: <a href="<?php echo $feed->get_permalink(); ?>"><?php echo $feed->get_title(); ?></a> | <?php echo $item->get_date('j M Y | g:i a'); ?></p>
                </div>

    <?php endforeach ?>

	<?php endif ?>

