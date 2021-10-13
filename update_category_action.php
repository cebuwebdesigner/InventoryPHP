<?php
ob_start();
session_start();
include("db/config.php");
include("db/function_xss.php");
// Checking Admin is logged in or not
if( ($_SESSION['type']['user_role'] != 'Admin') ){
	header('location: '.ADMIN_URL.'/index.php');
	exit;
}
if(isset($_POST['btn_action']))
{	
	if($_POST['btn_action'] == 'fetch_category')
	{	
		$category_id = filter_var($_POST['category_id'], FILTER_SANITIZE_NUMBER_INT) ;
		$fetch_category = $pdo->prepare("select * from billing_category where category_id = ?");
		$fetch_category->execute(array($category_id));
		$categoryData = $fetch_category->fetchAll(PDO::FETCH_ASSOC);
		foreach($categoryData as $row) {
			$output['category_name'] = _e($row['category_name']) ;
		}
		echo json_encode($output);
	}
	
}
?>