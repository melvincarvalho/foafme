<?php
       chdir (dirname(__FILE__) . "/../..");

       require 'lib/libAuthentication.php';
       header("Content-Type: text/plain; charset=utf-8");
       $auth = getAuth();
       if ($auth['isAuthenticated'])
               print $auth['agent']['webid'];
       else
               print '-';
       # PHP end tag intentionally omitted.
