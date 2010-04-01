<?php
require_once(dirname(dirname(__FILE__)).'/models/model.php');

admin_gatekeeper();

set_context('openid');

$store = new OpenID_ElggStore();
$store->resetAssociations();
$store->resetNonces();

print "OpenID store reset";
