<?php
ob_start();
session_start();
include("db/config.php");
// Checking Admin is logged in or not
if( ($_SESSION['type']['user_role'] != 'Admin') ){
	header('location: '.ADMIN_URL.'/index.php');
	exit;
}
if(isset($_POST['btn_action']))
{
	if($_POST['btn_action'] == 'Add')
	{
		if( isset($_POST['tax_rate']) ){
			$taxRate = filter_var($_POST['tax_rate'], FILTER_SANITIZE_STRING) ;
			$ins_tax = $pdo->prepare("INSERT INTO billing_tax (tax_slab_rate, tax_status) VALUES (?,?)");
			$ins_tax->execute(array($taxRate,filter_var("1", FILTER_SANITIZE_NUMBER_INT)));
			echo "New Tax % added successfully." ;
		} else {
			echo "All fields are mandatory" ;
		}
	}
	if($_POST['btn_action'] == 'Edit')
	{
		if(!empty($_POST['tax_id']) ){
			$tax_id = filter_var($_POST['tax_id'], FILTER_SANITIZE_NUMBER_INT) ;
			$tax_rate = filter_var($_POST['tax_rate'], FILTER_SANITIZE_STRING) ;
			$ins_tax = $pdo->prepare("update billing_tax set tax_slab_rate = ? where tax_id = ?");
			$ins_tax->execute(array($tax_rate,$tax_id));
			if($ins_tax) {
			 	echo "Tax % Edited Successfully." ;
			} else {
				echo "Something went wrong. Try Again." ;
			}
		} else {
			echo "All fields are mandatory" ;
		}
	}
}
?>