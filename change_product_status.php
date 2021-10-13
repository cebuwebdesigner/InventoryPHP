<?php
ob_start();
session_start();
include("db/config.php");
// Checking Admin is logged in or not
if( ($_SESSION['type']['user_role'] != 'Admin')  ){
	header('location: '.ADMIN_URL.'/dashboard.php');
	exit;
}
if($_POST['btn_action'] == 'changeProductStatus')
	{
		$productId = filter_var($_POST['productId'], FILTER_SANITIZE_NUMBER_INT);
		$status = filter_var($_POST['status'], FILTER_SANITIZE_NUMBER_INT);
		if($productId) {
			$update = $pdo->prepare("UPDATE billing_product SET product_status=?   WHERE product_id=?");
			$result_new = $update->execute(array($status,$productId));
			echo 'Product status changed .' ;	
		} else {
			echo 'Something went wrong. Try again.' ;		
		}
}
?>
