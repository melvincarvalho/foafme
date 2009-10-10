<?
// Include the SimplePie library, and the one that handles internationalized domain names.
require_once('lib/libAuthentication.php');

$auth = isset($_SESSION['auth']) ? $_SESSION['auth'] : NULL;

if (!empty($_REQUEST['webid'])) {
  $auth = get_agent($_REQUEST['webid']);


  $a1 = replace_with_rss(isset($auth['agent']['holdsAccount']) ? $auth['agent']['holdsAccount'] : NULL);
  $a2 = replace_with_rss(isset($auth['agent']['accountProfilePage']) ? $auth['agent']['accountProfilePage'] : NULL);
 
  if ( $a1 || $a2 ) {
    $a3 = array_merge(  $a1?$a1:array(), $a2?$a2:array() );
  }

  print "<h3>Online Accounts</h3>";

  if (!empty($a3)) {

    foreach ($a3 as $k => $v) {
      print "<a href='$v'>$v</a><br/>";
    }

  } else {
    print "No online accounts discovered";
  }
    //print "<h3>Your Account Settings</h3>";
    //print "<h3>Active Tabs</h3>";
    //print "Me<br/>Friends<br/>Accounts<br/>Activity";

} else {
?>
                          <table>
                          <table id="accountstable">
                          <tr><td></td><td>External Account URL</td></tr>
                          <tr typeof="foaf:OnlineAccount"><td>OpenID: </td><td><input size="40" rel="foaf:openid" id="account1" onChange="makeTags()" type="text" name="account1" /></td></tr>
                          <tr typeof="foaf:OnlineAccount"><td>Account: </td><td><input size="40" rel="foaf:holdsAccount" id="account2" onChange="makeTags()" type="text" name="account2" value="<?= isset($import['holdsAccount']) ? $import['holdsAccount'] : NULL ?>"/></td></tr>
                          <tr typeof="foaf:OnlineAccount"><td>Account: </td></td><td><input size="40" rel="foaf:holdsAccount" id="account3" onChange="makeTags()" type="text" name="accounts3" /></td></tr>    
                          <table>
                          <a href="#" onclick="javascript:adda()">Add</a>
                          </table>


<?
}
?>


