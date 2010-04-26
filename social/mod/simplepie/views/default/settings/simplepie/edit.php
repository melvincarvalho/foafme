<?php
  global $CONFIG;
  
  $compat_url = $CONFIG->wwwroot . 'mod/simplepie/sp_compatibility_test.php';
  $permit_url = $CONFIG->wwwroot . 'mod/simplepie/permissions.php';

?>

<p>
<a href="<?php echo $compat_url; ?>">Compatibility Test</a>
</p>

<p>
<a href="<?php echo $permit_url; ?>">Permissions Test for Cache</a>
</p>
