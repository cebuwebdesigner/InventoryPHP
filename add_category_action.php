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
		if( !empty($_POST['category_name']) ){
			$categoryName = filter_var($_POST['category_name'], FILTER_SANITIZE_STRING) ;
			$ins_category = $pdo->prepare("INSERT INTO billing_category (category_name, category_status) VALUES (?,?)");
			$ins_category->execute(array($categoryName,filter_var("1", FILTER_SANITIZE_NUMBER_INT)));
			echo "New Category added successfully." ;
		} else {
			echo "All fields are mandatory" ;
		}
	}
	if($_POST['btn_action'] == 'Edit')
	{
		if(!empty($_POST['category_id']) && !empty($_POST['category_name']) ){
			$category_id = filter_var($_POST['category_id'], FILTER_SANITIZE_NUMBER_INT) ;
			$category_name = filter_var($_POST['category_name'], FILTER_SANITIZE_STRING) ;
			$ins_category = $pdo->prepare("update billing_category set category_name = ? where category_id = ?");
			$ins_category->execute(array($category_name,$category_id));
			if($ins_category) {
			 	echo "Category Edited Successfully." ;
			} else {
				echo "Something went wrong. Try Again." ;
			}
		} else {
			echo "All fields are mandatory" ;
		}
	}
}
?>