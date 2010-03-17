<?php

//-----------------------------------------------------------------------------------------------------------------------------------
//
// Filename   : rdfexport.php
// Date       : 5th Mar 2009
//
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

//include_once("config.php");
include_once("arc/ARC2.php");

function detect_ie() {
    if (isset($_SERVER['HTTP_USER_AGENT']) &&
            (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false))
        return true;
    else
        return false;
}

function detect_safari() {
    if (isset($_SERVER['HTTP_USER_AGENT']) &&
            (strpos($_SERVER['HTTP_USER_AGENT'], 'Safari') !== false))
        return true;
    else
        return false;
}

function is_valid_url ( $url, $get_headers_func = 'get_headers' ) {
    $url = @parse_url($url);

    if ( ! $url ) {
        return false;
    }

    $url = array_map('trim', $url);
    $url['port'] = (!isset($url['port'])) ? 80 : (int)$url['port'];
    $path = (isset($url['path'])) ? $url['path'] : '';

    if ($path == '') {
        $path = '/';
    }

    $path .= ( isset ( $url['query'] ) ) ? "?$url[query]" : '';

    if ( isset($url['host']) AND isset($url['scheme']) AND ( ($url['scheme']=='http') OR ($url['scheme']=='https') ) AND ($url['host']!=gethostbyname($url['host'])) ) {
        $headers = $get_headers_func("$url[scheme]://$url[host]:$url[port]$path");
        $headers = ( is_array ( $headers ) ) ? implode ( "\n", $headers ) : $headers;
        return ( bool ) preg_match ( '#^HTTP/.*\s+[(200|301|302)]+\s#i', $headers );
    }
    return false;
}

$webid = $_GET['webid'];

if ( (!empty ($webid)) && (is_valid_url($webid)) ) {
    if (detect_ie() or detect_safari()) {

        header('Content-Type: application/xml');

    } else {

        header('Content-Type: application/rdf+xml');
    }

    $parser = ARC2::getRDFParser();

    $parser->parse($webid);

    $index = $parser->getSimpleIndex();

    $doc = $parser->toRDFXML($index);

    print $doc;
}
else {
    print "Webid $webid is not valid<br/>";
}

?>
