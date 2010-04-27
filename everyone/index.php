<?php

$r = array('REMOTE_USER'=>isset($_SERVER['REMOTE_USER'])?$_SERVER['REMOTE_USER']:NULL);
foreach ($_SERVER as $k=>$v) {
   if (substr($k, 0, 11) == 'SSL_CLIENT_') {
       $r[$k] = $v;
   }
}

header('Content-type: text/plain');
print_r($r);
 
?>
