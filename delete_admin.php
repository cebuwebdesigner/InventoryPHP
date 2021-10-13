<?php
ob_start();
session_start();
include("db/config.php");
// Checking Admin is logged in or not
if( ($_SESSION['type']['user_role'] != 'Admin') ){
	header('location: '.ADMIN_URL.'/dashboard.php');
	exit;
}
if($_POST['btn_action'] == 'delAdminStatus')
	{
		$adminId = filter_var($_POST['adminId'], FILTER_SANITIZE_NUMBER_INT);
		if($adminId != $_SESSION['type']['id']) {
			$update = $pdo->prepare("DELETE FROM `billing_admin` WHERE id=?");
			$result_new = $update->execute(array($adminId));
			echo 'Admin Deleted Successfully .' ;	
		} else {
			echo 'You cannot Delete yourself.' ;			
		}
}
?>