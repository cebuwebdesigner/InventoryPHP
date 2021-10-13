<?php
ob_start();
session_start();
include("db/config.php");
include("db/function_xss.php");
// Checking Admin or Manager is logged in or not
if( ($_SESSION['type']['user_role'] != 'Admin') && ($_SESSION['type']['user_role']!= 'Manager') ){
	header('location: '.ADMIN_URL.'/index.php');
	exit;
}
$Statement = $pdo->prepare("SELECT * FROM billing_brand LEFT JOIN billing_category ON (billing_category.category_id = billing_brand.category_id) ORDER BY billing_brand.brand_id DESC ");
$Statement->execute(); 
$total = $Statement->rowCount();    
$result = $Statement->fetchAll(PDO::FETCH_ASSOC); 
$output = array('data' => array());
if($total > 0) {
	$statuss = "";
	foreach($result as $row) {
		$brandId = _e($row['brand_id']);
		$categoryName = _e($row['category_name']);
		$brandName = _e($row['brand_name']);
		$statuss = _e($row['brand_status']);
		if( ($_SESSION['type']['user_role'] == 'Admin')) {
			$updateBrand = '<button type="button" name="updateBrand" id="'.$brandId.'" class="btn btn-light btn-xs updateBrand"><i class="fa fa-pencil-alt"></i></button>';
		} else {
			$updateBrand = '' ;
		}
		if($statuss == 1) {
			// Deactivate User
			$statuss = "<b>Active</b>";
			if( ($_SESSION['type']['user_role'] == 'Admin')) {
				$myLink = '<button type="button" name="changeBrandStatus" id="'.$brandId.'" class="btn btn-danger btn-xs changeBrandStatus" data-status="0">Deactivate</button>';
			} else {
				$myLink = '' ;
			}			
		} else {
			// Activate User
			$statuss = "Not Active";
			if( ($_SESSION['type']['user_role'] == 'Admin')) {
				$myLink = '<button type="button" name="changeBrandStatus" id="'.$brandId.'" class="btn btn-success btn-xs changeBrandStatus" data-status="1">Activate</button>';
			} else {
				$myLink = '' ;
			}
		}
		$output['data'][] = array( 		
		$brandId,
		$categoryName,
		$brandName,
		$statuss,
		$updateBrand,
		$myLink		
		); 	
	}
}
echo json_encode($output);
?>