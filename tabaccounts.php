<?
// Include the SimplePie library, and the one that handles internationalized domain names.
require_once('lib/libAuthentication.php');

$auth = $_SESSION['auth'];

if (!empty($_REQUEST['webid'])) {
  $auth = get_agent($_REQUEST['webid']);


  $a1 = replace_with_rss($auth['agent']['holdsAccount']);
  $a2 = replace_with_rss($auth['agent']['accountProfilePage']);
 
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
    print "<h3>Your Account Settings</h3>";
    print "Coming soon:  <br/><br/>Protect account with SSL certificate<br/> Edit profile (please use tabulator at the moment)<br/> Privacy control<br/>";
    print "<h3>Active Tabs</h3>";
    print "Me<br/>Friends<br/>Accounts<br/>Activity";

} else {
?>
                          <table>
                          <table id="accountstable">
                          <tr><td></td><td>External Account URL</td></tr>
                          <tr typeof="foaf:OnlineAccount"><td>OpenID: </td><td><input size="20" rel="foaf:openid" id="account1" onChange="makeTags()" type="text" name="account1" /></td></tr>
                          <tr typeof="foaf:OnlineAccount"><td>Account: </td><td><input size="20" rel="foaf:holdsAccount" id="account1" onChange="makeTags()" type="text" name="account1" /></td></tr>
                          <tr typeof="foaf:OnlineAccount"><td>Account: </td></td><td><input size="20" rel="foaf:holdsAccount" id="account2" onChange="makeTags()" type="text" name="accounts2" /></td></tr>    
                          <table>
                          <a href="#" onclick="javascript:adda()">Add</a>
                          </table>


<?
}
?>


