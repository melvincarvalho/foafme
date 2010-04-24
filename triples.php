<?php

//-----------------------------------------------------------------------------------------------------------------------------------
//
// Filename   : triples.php
// Date       : 15th October 2009
//
// Copyright 2008-2009 foaf.me
//
// This program is free software: you can redistribute it and/or modify
// it under the terms of the GNU Affero General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
// GNU Affero General Public License for more details.
//
// You should have received a copy of the GNU Affero General Public License
// along with this program. If not, see <http://www.gnu.org/licenses/>.
//
// "Everything should be made as simple as possible, but no simpler."
// -- Albert Einstein
//
//-----------------------------------------------------------------------------------------------------------------------------------

require_once(dirname(__FILE__)."/arc/ARC2.php");
require_once('db.class.php');

$config['store_name'] ='sparql';

if (!empty($_REQUEST['id'])) {
    $whereclause = " where id = " . $_REQUEST['id'];
} else if (!empty($_REQUEST['uri'])) {
    $whereclause = " where URI = '" . $_REQUEST['uri'] . "'";
}

$db = new db_class();
$db->connect('localhost', $config['db_user'], $config['db_pwd'], $config['db_name']);

$res = $db->select(" select * from foaf " . $whereclause );

$store = ARC2::getStore($config);
if (!$store->isSetUp()) {
    $store->setUp();
}

while ($res && ($row = $db->get_row($res))) {
    if (!empty($row) && !empty($row['rdf'])) {

        // get rdf
        $parser = ARC2::getRDFParser();
        $parser->parse($row['URI'], $row['rdf']);

        // convert to triples
        $triples = (array)($parser->getTriples());

        // aggregate triples
        $index = array_merge( (array) $index, $triples );

        // insert into db
        $store->insert($triples, $row['URI'], $keep_bnode_ids = 0);

    }

}


// print as n3
$doc = $parser->toNTriples($index);
echo $doc;
