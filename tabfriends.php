<?
// Include the SimplePie library, and the one that handles internationalized domain names.
require_once('lib/libAuthentication.php');

$auth = $_SESSION['auth'];

if (isset($_REQUEST['webid'])) {
  $auth = get_agent($_REQUEST['webid']);
}


if (!empty($auth['agent']['knows'])) {

  print "<h3>Friends</h3>";

  foreach ($auth['agent']['knows'] as $k => $v) {
    print "<a href='http://$_SERVER[HTTP_HOST]/index.php?webid=$v[webid]'>$v[name]</a><br/>";
  }

} else {
?>
                          <table id="friendstable">
                          <tr><td></td><td>Name</span></td><td>URL</td></tr>
                          <tr typeof="foaf:Person"><td>Add: </td><td><input size="12" id="friend1" property="foaf:name" onChange="makeTags()" type="text" name="friend1name" /></td><td><input size="12" rel="rdfs:seeAlso" id="friend1" onChange="makeTags()" type="text" name="friend1" /></td></tr>
                          <tr typeof="foaf:Person"><td>Add: </td><td><input size="12" id="friend2" property="foaf:name" onChange="makeTags()" type="text" name="friend2name" /></td><td><input size="12" rel="rdfs:seeAlso" id="friend2" onChange="makeTags()" type="text" name="friend2" /></td></tr>
                          </table>
                          <a href="#" onclick="javascript:addf()">Add</a>

<?
}
?>


