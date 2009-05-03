<?php

require_once("config.php");
require_once("db.class.php");

$db = new db_class();
$db->connect('localhost', $config['db_user'], $config['db_pwd'], $config['db_name']);
$r = $db->insert_sql('CREATE TABLE IF NOT EXISTS `foaf` (
  `id` int(11) NOT NULL auto_increment,
  `username` varchar(255) NOT NULL,
  `rdf` blob NOT NULL,
  `rdf2` blob NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1000 ;');

echo "foaf table created in db $config[db_name]";
?>
