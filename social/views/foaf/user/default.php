<?php
/**
 * Elgg default user view
 *
 * @package Elgg
 * @subpackage Core
 * @author Curverider Ltd
 * @link http://elgg.org/
 */

define('MAX_FRIENDS', 1000);

$friends=(array) ( get_user_friends($vars['page_owner'],$subtype = "",$limit = MAX_FRIENDS ,$offset = 0) );

foreach ($friends as $friend) {
?>

<foaf:knows>
<foaf:Person>
	<foaf:nick><?php echo $friend->username; ?></foaf:nick>
	<foaf:name><?php echo $friend->name; ?></foaf:name>
	<rdfs:seeAlso rdf:resource="<?php echo $vars['url'] . "pg/profile/" . $friend->username . "?view=foaf" ?>" />
</foaf:Person>
</foaf:knows>

<?php } ?>
