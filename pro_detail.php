<?php
ob_start();
session_start();
include("db/config.php");
include("db/function_xss.php");
include("db/functions.php");
// Checking Admin or Manager is logged in or not
if( ($_SESSION['type']['user_role'] != 'Admin') && ($_SESSION['type']['user_role']!= 'Manager') ){
	header('location: '.ADMIN_URL.'/index.php');
	exit;
}
echo fill_product_list($pdo) ; 
?>