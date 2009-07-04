<?php

require_once("config.php");
require_once("db.class.php");

$db = new db_class();
$db->connect('localhost', $config['db_user'], $config['db_pwd'], $config['db_name']);

// create foaf table if not exist
$r = $db->insert_sql('CREATE TABLE IF NOT EXISTS `foaf` (
  `id` int(11) NOT NULL auto_increment,
  `username` varchar(255) NOT NULL,
  `rdf` blob NOT NULL,
  `rdf2` blob NOT NULL,
  `acl` blob NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1000 ;');


// upgrade path
// 
// 1. initial, base table foaf
// 2. add column acl
$r = $db->select('SELECT COLUMN_NAME, DATA_TYPE, IS_NULLABLE, COLUMN_DEFAULT  FROM INFORMATION_SCHEMA.COLUMNS  WHERE table_name = "foaf"  AND COLUMN_NAME = "acl"');
$numrows = $db->row_count;
if ($numrows == 0) {
	$db->select(" ALTER TABLE `foaf` ADD `acl` BLOB NOT NULL AFTER `rdf2` ");
}


echo "foaf table created in db $config[db_name]";
?>

