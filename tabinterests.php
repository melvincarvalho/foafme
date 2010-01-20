<?php 
require_once('head.php');
require_once('header.php');


// Have we found a webid?
if (!empty($_REQUEST['webid'])) {

	// get webid details
	if (!empty($auth)) {
		$auth = get_agent($_REQUEST['webid']);
	}
} 
?>


	<table id="interests" about="<?php echo $_REQUEST['webid'] ?>#me">
	<tr>
		<td></td>
		<td>Name</td><td>URL</td>
	</tr>

	<?php for ($i=0; $i<$friends; $i++) { ?>


		<?php if (empty($_REQUEST['webid'])) {  ?>

		<tr typeof="foaf:Person" about="<?php echo $agent ?>friend<?php echo $i ?>" >
			<td>Friend: </td>
			<td><input size="12" id="friend<?php echo $i ?>" property="foaf:name" onchange="makeTags()" type="text" name="friend<?php echo $i ?>name" /></td>
			<td><input size="12" rel="rdfs:seeAlso" onchange="makeTags()" type="text" name="friend<?php echo $i ?>" /></td>

		<?php } else { $v = $auth['agent']['knows'][$i]; $about =  $v['about']?$v['about']  : $agent . "#friend" . $i ; ?>

		<tr typeof="foaf:Person" about="<?php echo $about ?>" >
			<td>Friend: </td>
			<td><span id="friend<?php echo $i ?>" property="foaf:name"><?php echo $v['name'] ?></span></td>
			<td><span href="<?php echo $v['webid'] ?>" rel="rdfs:seeAlso" ><?php echo $v['webid'] ?></a></td>
			<td about="<?php echo $agent ?>#me"" rel="foaf:knows" href="<?php echo $agent ?>#friend<?php echo $i ?>"><a  id="delfriend<?php echo $i ?>" href="javascript:del('delfriend<?php echo $i ?>')" >x</a></td>
		<?php } ?>

	</tr>

	<?php } ?>


	</table>
	<a id="addf" href="#" onclick="javascript:addi(this)">Add</a>

<?php
                if (realpath(__FILE__) == realpath($_SERVER['SCRIPT_FILENAME'])) {
                   require_once("footer.php");
                }
?>


