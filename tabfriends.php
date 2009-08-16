<?

// This tab can act as a standalone page or be included from a containter
//
// If included from a container the header and footer are not repeated


// $headerLoaded is imported from the containter
// determines whether we were called standalone or included
if ( $headerLoaded != true ) {
	include('head.php'); 
	include('header.php'); 
	$headerLoaded = false;
}


// Authenticate
require_once('lib/libAuthentication.php');

// init
$friends = 2;

// Have we found a webid?
$webid = $_REQUEST['webid'];
$webidbase = preg_replace('/#.*/', '', $webid);
if (!empty($webid)) {

	// get webid details
	$auth = get_agent($webid);
	$friends = count($auth['agent']['knows']);

} 
?>


<script type="text/javascript">
<!--
// function to add a friend
function addf(el) {

	// empty list 
	// @TODO more robust detection
	if ($("#friendstable tr:last td:last input").attr("name") == "friend1") {

		var about = $("#friendstable tr:last").attr("about");
		var lastFriend = about != undefined? about.replace(/.*friend/, "") : -1;
		lastFriend++;
		//alert (lastFriend)

		var clone = $("#friendstable tr:last").clone();
		clone.attr({about : '#friend' + lastFriend });

		clone.appendTo("#friendstable");
		return;
	}

	// edit in place
	var last = $("#friendstable tr:last");
	if (last == null) {
	} else {
		var about = $("#friendstable tr:last").attr("about");
		var lastFriend = about != undefined? about.replace(/.*friend/, "") : -1;
		lastFriend++;
		//alert (lastFriend)
		$("#friendstable tr:last").after("<tr about='<?= $webidbase ?>#friend"+lastFriend+"' typeof='foaf:Person' property='foaf:knows'><td>Friend</td><td><span property=foaf:name></span></td><td><a rel=refs:seeAlso></a></td><td about=<?= $webid ?> ref=foaf:knows href=<?= $webidbase ?>#friend"+lastFriend+" ><a>x</a></td></tr>");

		sparul();
	}
}
// -->
</script>

	<table id="friendstable" about="<?= $webid ?>">
	<tr>
		<td></td>
		<td>Name</td><td>URL</td>
	</tr>

	<? for ($i=0; $i<$friends; $i++) { ?>


		<? if (empty($webid)) {  ?>

		<tr typeof="foaf:Person" about="<?= $webidbase ?>friend<?= $i ?>" >
			<td>Friend: </td>
			<td><input size="12" id="friend<?= $i ?>" property="foaf:name" onchange="makeTags()" type="text" name="friend<?= $i ?>name" /></td>
			<td><input size="12" rel="rdfs:seeAlso" onchange="makeTags()" type="text" name="friend<?= $i ?>" /></td>

		<? } else { $v = $auth['agent']['knows'][$i]; $about =  $v['about']?$v['about']  : $webidbase . "#friend" . $i ; ?>

		<tr typeof="foaf:Person" about="<?= $about ?>" >
			<td><a href="?webid=<?= $v['webid'] ?>">Friend</a>: </td>
			<td><span id="friend<?= $i ?>" property="foaf:name"><?= $v['name'] ?></span></td>
			<td><span href="<?= $v['webid'] ?>" rel="rdfs:seeAlso" ><?= $v['webid'] ?></span></td>
			<td about="<?= $webid ?>" rel="foaf:knows" href="<?= $webidbase ?>#friend<?= $i ?>"><a  id="delfriend<?= $i ?>" href="javascript:del('delfriend<?= $i ?>')" >x</a></td>
		<? } ?>

	</tr>

	<? } ?>


	</table>
	<br/>
	<a id="addf" href="#" onclick="javascript:addf(this)">Add</a>

<?

// $headerLoaded is imported from the containter
// determines whether we were called standalone or included
if ( $headerLoaded != true ) {
	include('footer.php'); 
}
?>


