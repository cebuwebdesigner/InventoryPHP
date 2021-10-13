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
	if($_POST['btn_action'] == 'fetch_brand')
	{	
		$brand_id = filter_var($_POST['brand_id'], FILTER_SANITIZE_NUMBER_INT) ;
		$fetch_brand = $pdo->prepare("select * from billing_brand where brand_id = ?");
		$fetch_brand->execute(array($brand_id));
		$brandData = $fetch_brand->fetchAll(PDO::FETCH_ASSOC);
		foreach($brandData as $row) {
			$output['category_id'] = _e($row['category_id']);
			$output['brand_name'] = _e($row['brand_name']) ;
		}
		echo json_encode($output);
	}
	
}
?>