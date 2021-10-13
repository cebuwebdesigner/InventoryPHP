<?php
ob_start();
session_start();
include("db/config.php");
// Checking Admin is logged in or not
if( ($_SESSION['type']['user_role'] != 'Admin') ){
	header('location: '.ADMIN_URL.'/dashboard.php');
	exit;
}
if($_POST['btn_action'] == 'changeAdminStatus')
	{
		$adminId = filter_var($_POST['adminId'], FILTER_SANITIZE_NUMBER_INT);
		$status = filter_var($_POST['status'], FILTER_SANITIZE_NUMBER_INT);
		if($adminId != $_SESSION['type']['id']) {
			$update = $pdo->prepare("UPDATE billing_admin SET active_status=?   WHERE id=?");
			$result_new = $update->execute(array($status,$adminId));
			echo 'Admin status changed .' ;	
		} else {
			echo 'You cannot change your own Status.' ;		
		}
}
?>
