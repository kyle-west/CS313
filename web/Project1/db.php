<?php
/**************************************************************
* DATABASE CONNECTION
* Original by Scott Burton, modified by Kyle West
*
* Connect to the DB and set a local variable for later access
**************************************************************/

$db = NULL;
try {
	// default Heroku Postgres configuration URL
	$dbUrl = getenv('DATABASE_URL');
	if (!isset($dbUrl) || empty($dbUrl)) {
		$dbUrl = "postgres://postgres:7510@localhost:5432/cs313";
	}
	// Get the various parts of the DB Connection from the URL
	$dbopts = parse_url($dbUrl);
	$dbHost = $dbopts["host"];
	$dbPort = $dbopts["port"];
	$dbUser = $dbopts["user"];
	$dbPassword = $dbopts["pass"];
	$dbName = ltrim($dbopts["path"],'/');
	$db = new PDO("pgsql:host=$dbHost;port=$dbPort;dbname=$dbName", $dbUser, $dbPassword);
	$db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
}
catch (PDOException $ex) {
	echo "Error connecting to DB. Details: $ex";
	die();
}

?>
