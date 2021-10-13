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
		if( isset($_POST['markup_rate']) ){
			$markupRate = filter_var($_POST['markup_rate'], FILTER_SANITIZE_STRING) ;
			$ins_markup = $pdo->prepare("INSERT INTO billing_markup (markup_slab_rate, markup_status) VALUES (?,?)");
			$ins_markup->execute(array($markupRate,filter_var("1", FILTER_SANITIZE_NUMBER_INT)));
			echo "New Markup % added successfully." ;
		} else {
			echo "All fields are mandatory" ;
		}
	}
	if($_POST['btn_action'] == 'Edit')
	{
		if(!empty($_POST['markup_id']) ){
			$markup_id = filter_var($_POST['markup_id'], FILTER_SANITIZE_NUMBER_INT) ;
			$markup_rate = filter_var($_POST['markup_rate'], FILTER_SANITIZE_STRING) ;
			$ins_markup = $pdo->prepare("update billing_markup set markup_slab_rate = ? where markup_id = ?");
			$ins_markup->execute(array($markup_rate,$markup_id));
			if($ins_markup) {
			 	echo "Markup % Edited Successfully." ;
			} else {
				echo "Something went wrong. Try Again." ;
			}
		} else {
			echo "All fields are mandatory" ;
		}
	}
}
?>