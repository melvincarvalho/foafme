<?php 
//-----------------------------------------------------------------------------------------------------------------------------------
//
// Filename   : libActivity.php                                                                                                  
// Version    : 0.1
// Date       : 12th October 2009
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

function get_openlink_acct($acct)
{
	$parser = ARC2::getRDFParser();

	$parser->parse($acct);

	$triples = $parser->getTriples();

	foreach ($triples as $row)
	{
		if (strcmp($row[p], "http://xmlns.com/foaf/0.1/accountServiceHomepage")==0)
			return convert_to_rss($row[o]);
	}
}

function convert_to_rss($acct)
{
	if (strstr($acct, 'http://identi.ca/') && (strstr($acct,'/rss')==FALSE))
		$acct = $acct . '/rss';		
	else
	{
		if (strstr($acct, 'http://www.last.fm/'))
			$acct = 'http://ws.audioscrobbler.com/1.0/' . substr( $acct, strlen('http://www.last.fm/') ) . '/recenttracks.rss';
		else
		{
			if (strstr($acct, 'http://en.wikipedia.org/wiki/User:'))
				$acct = 'http://en.wikipedia.org/w/index.php?title=Special:Contributions&feed=rss&target=' . substr($acct, strlen('http://en.wikipedia.org/wiki/User:'));
			else
			{
				if ( (strstr($acct, 'mailto:')) || (strstr($acct, 'skype:')) || (strstr($acct, 'http://www.linkedin.com/')) || (strstr($acct, 'http://www.facebook.com/')) || (strstr($acct, 'http://test.foaf-ssl.org/')) || (strstr($acct, 'http://puszcza.gnu.org.ua/')) || (strstr($acct, 'http://savannah.gnu.org/')) || (strstr($acct, 'http://www.thesixtyone.com/')) )
					$acct = NULL;
				else
				{
					if (strstr($acct, 'http://myopenlink.net/dataspace/person/'))
						$acct = get_openlink_acct($acct);
					else
					{
						if (strstr($acct, 'http://www.flickr.com/people/'))
							$acct = 'http://www.flickr.com/photos/' .  substr( $acct, strlen('http://www.flickr.com/people/') ) ;
						else
						{
							if (strstr($acct, 'http://www.ohloh.net/')  && (strstr($acct,'/messages.rss')==FALSE))
							{
								$acct = $acct . '/messages.rss';
							}
						}
					}

				}
			}
		}
	}

	return($acct);
}

function replace_with_rss($accts)
{
	$ret = NULL;

	if ($accts)
	{
		foreach ($accts as $acct)
		{
			$acct = convert_to_rss($acct);

			if ($acct)
				$ret = safe_array_merge($ret, array($acct));
		}
	}

	return $ret;
}

?>
