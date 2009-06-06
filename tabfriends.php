<?
// Include the SimplePie library, and the one that handles internationalized domain names.
require_once('lib/libAuthentication.php');

$auth = $_SESSION['auth'];

if (!empty($_REQUEST['webid'])) {
  $auth = get_agent($_REQUEST['webid']);

  print "<h3>Friends</h3>";

  if (!empty($auth['agent']['knows'])) {

    foreach ($auth['agent']['knows'] as $k => $v) {
      print "<a href='http://" . $_SERVER['HTTP_HOST'] . str_replace('tabfriends', 'index', $_SERVER['PHP_SELF']) . "?webid=$v[webid]'>$v[name]</a><br/>";
    }
  } else {
    print "No friends discovered yet";
  }

} else {
?>
                          <table id="friendstable">
                          <tr><td></td><td>Name</span></td><td>URL</td></tr>
                          <tr typeof="foaf:Person" about="friend1" ><td>Add: </td><td><input size="12" id="friend1" property="foaf:name" onChange="makeTags()" type="text" name="friend1name" /></td><td><input size="12" rel="rdfs:seeAlso" id="friend1" onChange="makeTags()" type="text" name="friend1" /></td></tr>
                          <tr typeof="foaf:Person" about="friend2" ><td>Add: </td><td><input size="12" id="friend2" property="foaf:name" onChange="makeTags()" type="text" name="friend2name" /></td><td><input size="12" rel="rdfs:seeAlso" id="friend2" onChange="makeTags()" type="text" name="friend2" /></td></tr>
                          </table>
                          <a href="#" onclick="javascript:addf()">Add</a>

<?
}
?>


