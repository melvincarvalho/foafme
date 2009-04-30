<?php

if (!empty($_SESSION['auth']) && $_SESSION['auth']['subjectAltName'] || $_REQUEST['webid'] ) {

	$webid = $_REQUEST['webid'] ? $_REQUEST['webid'] : $_SESSION['auth']['subjectAltName'];

	print "<script src=http://foaf-visualizer.org/embed/widget/?uri=$webid ></script>";

	print '<script>$("a").each(function() { $(this).attr("href", $(this).attr("href").replace("foaf-visualizer.org/?uri=", "' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] . '?webid=") ) } );</script>';

				

?>
<? } else { ?>

			<table>
			    <tr><td><b>Create Profile!</b> </td><td></tr>
			    <tr><td>Username/Nick:</td><td><input id="nick" onChange="makeTags()" property="foaf:nick" type="text" name="nick" /><span class="required">*</span></tr>
			    <tr><td>First Name</td><td><input property="foaf:firstName" id="firstname" onChange="makeTags()" type="text" name="firstName"></td></tr>
			    <tr><td>Last Name</td><td><input property="foaf:givenName" id="surname" onChange="makeTags()" type="text" name="surname"></td></tr>
			    <tr><td>Picture</td><td><input rel="foaf:depiction" id="depiction" onChange="makeTags()" type="text" name="depiction"></td></tr>
				<tr><td>Homepage</td><td><input rel="foaf:homepage" id="homepage" onChange="makeTags()" type="text" name="homepage"/></tr>
			</table>
<? } ?>		
