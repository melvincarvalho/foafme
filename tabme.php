<?php

require_once('lib/libAuthentication.php');

$auth = $_SESSION['auth'];

if (!empty($_REQUEST['webid'])) {
  $auth = get_agent($_REQUEST['webid']);



  if (!empty($auth['agent']['webid'])) {
    $webid = $auth['agent']['webid'];

    print "<script src=http://foaf-visualizer.org/embed/widget/?uri=$webid ></script>";
  } else {
    print "No profile discovered yet";
  }

				

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
