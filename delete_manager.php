<?php
ob_start();
session_start();
include("db/config.php");
// Checking Admin is logged in or not
if( ($_SESSION['type']['user_role'] != 'Admin') ){
	header('location: '.ADMIN_URL.'/dashboard.php');
	exit;
}
if($_POST['btn_action'] == 'delManagerStatus')
	{
		$managerId = filter_var($_POST['managerId'], FILTER_SANITIZE_NUMBER_INT);
		if($managerId) {
			$update = $pdo->prepare("DELETE FROM `billing_admin` WHERE id=?");
			$result_new = $update->execute(array($managerId));
			echo 'Manager Deleted Successfully .' ;	
		} else {
			echo 'Something went wrong. Try again.' ;			
		}
}
?>