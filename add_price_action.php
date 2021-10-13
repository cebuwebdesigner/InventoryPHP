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
if(isset($_POST['btn_action']))
{
	if($_POST['btn_action'] == 'load_price')
	{
		echo fill_price($pdo, filter_var($_POST['product_id'], FILTER_SANITIZE_NUMBER_INT), filter_var($_POST['row_no'], FILTER_SANITIZE_NUMBER_INT));
	}
	if($_POST['btn_action'] == 'load_price_quantity')
	{
		echo fill_price_quantity($pdo, filter_var($_POST['product_id'], FILTER_SANITIZE_NUMBER_INT), filter_var($_POST['quantity'], FILTER_SANITIZE_NUMBER_INT));
	}
	if($_POST['btn_action'] == 'load_only_price')
	{
		echo fill_only_price($pdo, filter_var($_POST['product_id'], FILTER_SANITIZE_NUMBER_INT), filter_var($_POST['row_no'], FILTER_SANITIZE_NUMBER_INT), filter_var($_POST['quantity'], FILTER_SANITIZE_NUMBER_INT));
	}
}
?>