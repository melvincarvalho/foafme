<?php

//-----------------------------------------------------------------------------------------------------------------------------------
//
// Filename   : tabme.php                                                                                                  
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

require_once('lib/libAuthentication.php');
require_once('db.class.php');

$db = new db_class();
$db->connect('localhost', $config['db_user'], $config['db_pwd'], $config['db_name']);

$res = $db->select(" select * from foaf ");

while ($res && ($row = $db->get_row($res))) {
    if (!empty($row) && !empty($row['rdf'])) {
        $parser = ARC2::getRDFParser();
        $parser->parse($row['URI'], $row['rdf']);
        $index = array_merge( (array) $index, (array)($parser->getTriples()) );

        $turtle_doc = $parser->toNTriples($index);
        echo $turtle_doc;
    }

}
