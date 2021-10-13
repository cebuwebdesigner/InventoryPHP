<?php
ob_start();
session_start();
include("db/config.php");
// Checking Admin or Manager is logged in or not
if( ($_SESSION['type']['user_role'] != 'Admin') && ($_SESSION['type']['user_role']!= 'Manager') ){
	header('location: '.ADMIN_URL.'/dashboard.php');
	exit;
}
if($_POST['btn_action'] == 'changeCustomerStatus')
	{
		$customerId = filter_var($_POST['customerId'], FILTER_SANITIZE_NUMBER_INT);
		$status = filter_var($_POST['status'], FILTER_SANITIZE_NUMBER_INT);
		if($customerId) {
			$update = $pdo->prepare("UPDATE billing_user SET customer_status=?   WHERE customer_id=?");
			$result_new = $update->execute(array($status,$customerId));
			echo 'Customer status changed .' ;	
		} else {
			echo 'Something went wrong. Try again.' ;		
		}
}
?>
