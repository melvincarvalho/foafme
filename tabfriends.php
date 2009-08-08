<?

if ( $headedLoaded != true ) {
	include('head.php'); 
	include('header.php'); 
}


// Authenticate
require_once('lib/libAuthentication.php');

// init
$friends = 2;

// Have we found a webid?
if (!empty($_REQUEST['webid'])) {

	// get webid details
	$auth = get_agent($_REQUEST['webid']);
	$friends = count($auth['agent']['knows']);

} 
?>


	<table id="friendstable" about="<?= $_REQUEST['webid'] ?>#me">
	<tr>
		<td></td>
		<td>Name</td><td>URL</td>
	</tr>

	<? for ($i=0; $i<$friends; $i++) { ?>


		<? if (empty($_REQUEST['webid'])) {  ?>

		<tr typeof="foaf:Person" about="<?= $agent ?>#friend<?= $i ?>" >
			<td>Friend: </td>
			<td><input size="12" id="friend<?= $i ?>" property="foaf:name" onchange="makeTags()" type="text" name="friend<?= $i ?>name" /></td>
			<td><input size="12" rel="rdfs:seeAlso" onchange="makeTags()" type="text" name="friend<?= $i ?>" /></td>

		<? } else { $v = $auth['agent']['knows'][$i]; $about =  $v['about']?$v['about']  : $agent . "#friend" . $i ; ?>

		<tr typeof="foaf:Person" about="<?= $about ?>" >
			<td>Friend: </td>
			<td><span id="friend<?= $i ?>" property="foaf:name"><?= $v['name'] ?></span></td>
			<td><span href="<?= $v['webid'] ?>" rel="rdfs:seeAlso" ><?= $v['webid'] ?></a></td>
			<td about="<?= $agent ?>#me"" rel="foaf:knows" href="<?= $agent ?>#friend<?= $i ?>"><a  id="delfriend<?= $i ?>" href="javascript:del('delfriend<?= $i ?>')" >x</a></td>
		<? } ?>

	</tr>

	<? } ?>


	</table>
	<a id="addf" href="#" onclick="javascript:addf(this)">Add</a>

<?
if ( $headedLoaded != true ) {
	include('footer.php'); 
}
?>


