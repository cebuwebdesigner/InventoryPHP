<?php
ob_start();
session_start();
include("db/config.php");
// Checking Admin is logged in or not
if( ($_SESSION['type']['user_role'] != 'Admin') ){
	header('location: '.ADMIN_URL.'/dashboard.php');
	exit;
}
if($_POST['btn_action'] == 'changeManagerStatus')
	{
		$managerId = filter_var($_POST['managerId'], FILTER_SANITIZE_NUMBER_INT);
		$status = filter_var($_POST['status'], FILTER_SANITIZE_NUMBER_INT);
		if($managerId) {
			$update = $pdo->prepare("UPDATE billing_admin SET active_status=?  WHERE id=?");
			$result_new = $update->execute(array($status,$managerId));
			echo 'Manager status changed .' ;	
		} else {
			echo 'Something went wrong. Try again.' ;		
		}
}
?>
