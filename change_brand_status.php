<?php
ob_start();
session_start();
include("db/config.php");
// Checking Adminis logged in or not
if( ($_SESSION['type']['user_role'] != 'Admin')  ){
	header('location: '.ADMIN_URL.'/dashboard.php');
	exit;
}
if($_POST['btn_action'] == 'changeBrandStatus')
	{
		$brandId = filter_var($_POST['brandId'], FILTER_SANITIZE_NUMBER_INT);
		$status = filter_var($_POST['status'], FILTER_SANITIZE_NUMBER_INT);
		if($brandId) {
			$update = $pdo->prepare("UPDATE billing_brand SET brand_status=?   WHERE brand_id=?");
			$result_new = $update->execute(array($status,$brandId));
			echo 'Brand status changed .' ;	
		} else {
			echo 'Something went wrong. Try again.' ;		
		}
}
?>
