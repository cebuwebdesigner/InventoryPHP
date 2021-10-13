<?php
ob_start();
session_start();
include("db/config.php");
// Checking Admin is logged in or not
if( ($_SESSION['type']['user_role'] != 'Admin')  ){
	header('location: '.ADMIN_URL.'/dashboard.php');
	exit;
}
if($_POST['btn_action'] == 'changeTaxStatus')
	{
		$taxId = filter_var($_POST['taxId'], FILTER_SANITIZE_NUMBER_INT);
		$status = filter_var($_POST['status'], FILTER_SANITIZE_NUMBER_INT);
		if($taxId) {
			$update = $pdo->prepare("UPDATE billing_tax SET tax_status=?   WHERE tax_id=?");
			$result_new = $update->execute(array($status,$taxId));
			echo 'Tax status changed .' ;	
		} else {
			echo 'Something went wrong. Try again.' ;		
		}
}
?>
