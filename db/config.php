<?php
// Error Reporting Turn On
ini_set('error_reporting', E_ALL);

// Host Name
$dbhost = 'localhost' ;

// Database Name
$dbname = 'olivergo_agm' ;


$dbuser = 'root'; 

$dbpass = '';


define("BASE_URL", "http://localhost/");

// Defining Admin url , Note : do not change admin folder name otherwise script won't work as expected
define("ADMIN_URL", BASE_URL . "admin");

try {
	$pdo = new PDO("mysql:host={$dbhost};dbname={$dbname}", $dbuser, $dbpass);
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch( PDOException $exception ) {
	echo "Connection error :" . $exception->getMessage();
}
?>