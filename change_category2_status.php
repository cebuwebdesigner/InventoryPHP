<?php
ob_start();
session_start();
include("db/config.php");
// Checking Admin is logged in or not
if( ($_SESSION['type']['user_role'] != 'Admin') ){
	header('location: '.ADMIN_URL.'/dashboard.php');
	exit;
}
if($_POST['btn_action'] == 'changeCategory2Status')
	{
		$categoryId = filter_var($_POST['categoryId'], FILTER_SANITIZE_NUMBER_INT);
		$status = filter_var($_POST['status'], FILTER_SANITIZE_NUMBER_INT);
		if($categoryId) {
			$update = $pdo->prepare("UPDATE billing_category2 SET category_status=?   WHERE category_id=?");
			$result_new = $update->execute(array($status,$categoryId));
			echo 'Category status changed .' ;	
		} else {
			echo 'Something went wrong. Try again.' ;		
		}
}
?>
