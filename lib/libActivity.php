<?

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
				if ( (strstr($acct, 'mailto:')) || (strstr($acct, 'skype:')) || (strstr($acct, 'http://www.linkedin.com/')) || (strstr($acct, 'http://www.facebook.com/')) )
					$acct = NULL;
				else
				{
					if (strstr($acct, 'http://myopenlink.net/dataspace/person/'))
						$acct = get_openlink_acct($acct);
					else
					{
						if (strstr($acct, 'http://www.flickr.com/people/'))
							$acct = 'http://www.flickr.com/photos/' .  substr( $acct, strlen('http://www.flickr.com/people/') ) ;
					}

				}
			}
		}
	}

	return($acct);
}

function replace_with_rss($accts)
{
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
