<?php

/** 
 * install.php
 *
 * Copyright 2008-2009 foaf.me
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 * 
 * "Everything should be made as simple as possible, but no simpler." 
 * -- Albert Einstein
 *
 */

require_once("config.php");
require_once("db.class.php");

$db = new db_class();
$db->connect('localhost', $config['db_user'], $config['db_pwd'], $config['db_name']);

// create foaf table if not exist
$r = $db->insert_sql('CREATE TABLE IF NOT EXISTS `foaf` (
  `id` int(11) NOT NULL auto_increment,
  `username` varchar(255) NOT NULL,
  `rdf` blob NOT NULL,
  `rdf2` blob NULL,
  `acl` blob NULL,
  `URI` varchar(255) NULL,
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
	$db->select(" ALTER TABLE `foaf` ADD `acl` BLOB NULL AFTER `rdf2` ");
}

// upgrade path
//
// 1. initial, base table foaf
// 2. add column webid
$r = $db->select('SELECT COLUMN_NAME, DATA_TYPE, IS_NULLABLE, COLUMN_DEFAULT  FROM INFORMATION_SCHEMA.COLUMNS  WHERE table_name = "foaf"  AND COLUMN_NAME = "webid"');
$numrows = $db->row_count;
if ($numrows == 0) {
	$db->select(" ALTER TABLE `foaf` ADD `URI` varchar(255) NULL AFTER `acl` ");
}


echo "foaf table created in db $config[db_name]";
?>

