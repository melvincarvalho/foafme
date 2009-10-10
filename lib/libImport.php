<?
//-----------------------------------------------------------------------------------------------------------------------------------
//
// Filename   : libImport.php                                                                                                  
// Version    : 0.1
// Date       : 13th Aug 2009
//
//
//-----------------------------------------------------------------------------------------------------------------------------------


function getImport()
{

	$result = array('referer' => (isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : NULL ));

        // http://irc.sioc-project.org/users/PovAddict
	// if starts with http://irc.sioc-project.org/users/ populate nick and holdsAccount
	if ( (isset($_SERVER['HTTP_REFERER'])) && ( strpos($_SERVER['HTTP_REFERER'], 'http://irc.sioc-project.org/users/') === 0 ) ) {
		$result['holdsAccount'] = $_SERVER['HTTP_REFERER'] . "#user";
		$result['nick'] = str_replace('http://irc.sioc-project.org/users/', '',  $_SERVER['HTTP_REFERER']) ;
	}


	return $result;
}

?>
