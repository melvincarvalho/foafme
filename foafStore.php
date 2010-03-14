<?
function dbconnection() {

	$user=$GLOBAL['dbuser'];

//	print "dbhost=$GLOBALS[dbhost], dbuser=$GLOBALS[dbuser], $GLOBALS[dbpass], dbname=$GLOBALS[dbname]<br>";

	if (!mysql_connect($GLOBALS['dbhost'], $GLOBALS['dbuser'], $GLOBALS['dbpass']))	{
		print 'Error: Connecting to dbserver<br>';
		return FALSE;
	}

	if (!mysql_select_db($GLOBALS['dbname'])) {
		print 'Error: ' . mysql_error() . '<br>';
		return FALSE;
	}

	return TRUE;
}

// Runs the supplied query against the database and returns the result set
function dbselectquery($sql) {

	if ($sql) {

	//	print "$sql<br>";

		if ($query=mysql_query($sql)) {

			while($result[]=mysql_fetch_assoc($query));

			if ($result)
				array_pop($result);

			return $result;
		}
		else
			print 'Error: ' . mysql_error() . '<br>';

	}

	return NULL;
}

// Runs the supplied update or insert query against the database.
function dbupdatequery($sql) {

	if ($sql) {

	//	print "$sql<br>";

		if (mysql_query($sql))
			return TRUE;
		
		print 'Error: ' . mysql_error() . '<br>';
	}

	return FALSE;
}

function dbinsertquery($sql) {

	return dbupdatequery($sql);
}

function store_rdf($nickname, $rdf)
{
	dbconnection();

	$sql = " select * from foaf where username like '" . $nickname. "' ";

	$res = dbselectquery($sql);

	$sql = " insert into foaf (id, username, rdf, rdf2) VALUES (NULL, '".$nickname."', '".$rdf."', '".$rdf."')  ";
	foreach ($res as $result) {
		$sql = " update foaf set rdf = '".$rdf."' , rdf2 = '".$rdf."' where username like '".$nickname."'  ";
	}
//	print "$sql";

	$res = dbinsertquery($sql);
}

//Connect to database
$dbhost  = 'localhost';
$dbuser  = 'foaf_foaf';
$dbpass  = 'foaf';
$dbname  = 'foaf_foaf';
?>