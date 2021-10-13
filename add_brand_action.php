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
		if( !empty($_POST['brand_name']) &&  !empty($_POST['category_id']) ){
			$category_id = filter_var($_POST['category_id'], FILTER_SANITIZE_NUMBER_INT) ;
			$brandName = filter_var($_POST['brand_name'], FILTER_SANITIZE_STRING) ;
			$ins_brand = $pdo->prepare("INSERT INTO billing_brand (category_id, brand_name, brand_status) VALUES (?,?,?)");
			$ins_brand->execute(array($category_id,$brandName,filter_var("1", FILTER_SANITIZE_NUMBER_INT)));
			echo "New Brand added successfully." ;
		} else {
			echo "All fields are mandatory" ;
		}
	}
	if($_POST['btn_action'] == 'Edit')
	{
		if(!empty($_POST['brand_id']) && !empty($_POST['brand_name']) &&  !empty($_POST['category_id']) ){
			$category_id = filter_var($_POST['category_id'], FILTER_SANITIZE_NUMBER_INT) ;
			$brand_id = filter_var($_POST['brand_id'], FILTER_SANITIZE_NUMBER_INT) ;
			$brand_name = filter_var($_POST['brand_name'], FILTER_SANITIZE_STRING) ;
			$ins_brand = $pdo->prepare("update billing_brand set category_id = ? , brand_name = ? where brand_id = ?");
			$ins_brand->execute(array($category_id,$brand_name,$brand_id));
			if($ins_brand) {
			 	echo "Brand Edited Successfully." ;
			} else {
				echo "Something went wrong. Try Again." ;
			}
		} else {
			echo "All fields are mandatory" ;
		}
	}
}
?>