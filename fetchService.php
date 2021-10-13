<?php
ob_start();
session_start();
include("db/config.php");
include("db/function_xss.php");
include("db/functions.php");
// Checking Admin or Manager is logged in or not
if( ($_SESSION['type']['user_role'] != 'Admin') && ($_SESSION['type']['user_role']!= 'Manager') ){
	header('location: '.ADMIN_URL.'/index.php');
	exit;
}
$Statement = $pdo->prepare("SELECT * FROM billing_service LEFT JOIN billing_category ON (billing_category.category_id = billing_service.category_id) LEFT JOIN billing_brand ON (billing_brand.brand_id = billing_service.brand_id) LEFT JOIN billing_admin ON (billing_admin.id = billing_service.service_enter_by) ORDER BY billing_service.service_id DESC ");
$Statement->execute(); 
$total = $Statement->rowCount();    
$result = $Statement->fetchAll(PDO::FETCH_ASSOC); 
$output = array('data' => array());
if($total > 0) {
	$statuss = "";
	foreach($result as $row) {
		$productId = _e($row['service_id']) ;
		$categoryName = _e($row['category_name']) ;
		$brandName = _e($row['brand_name']) ;
		$statuss = _e($row['service_status']) ;
		$productName = _e($row['service_name']) ;
		$productSKU = _e($row['service_sku']) ;
		$productQuantity = available_product_quantity($pdo,$productId) ;
		$productUnit = _e($row['service_unit']) ;
		$productBasePrice = _e($row['service_base_price']) ;
		$productTaxRate = _e($row['service_tax_rate']) ;
		$productSellingPrice = _e($row['service_selling_price']) ;
		$productEnterBy = _e($row['service_enter_by']) ;
		$userEmail = _e($row['email']) ;
		$userRole = _e($row['user_role']) ;
		$enter_by =  _e($row['service_edited_by']);
		$enter_by_statement = $pdo->prepare("select email, user_role from billing_admin where id= ?");
		$enter_by_statement->execute(array($enter_by));
		$result_enter_by = $enter_by_statement->fetchAll(PDO::FETCH_ASSOC);
		$total = $enter_by_statement->rowCount();
		if($total > 0) {
			foreach ($result_enter_by as $edited) {
				$editedBy = _e($edited['email']);
				$editedRole = _e($edited['user_role']);
			}
		} else {
			$editedBy = "";
			$editedRole = "";
		} 
		$taxPrice = number_format((float)$productSellingPrice - ( (float)$productSellingPrice * ( 100 / ( 100 + (float)$productTaxRate ) ) ),2) ;
		if( ($_SESSION['type']['user_role'] == 'Admin')) {
			$updateService = '<button type="button" name="updateService" id="'.$productId.'" class="btn btn-light btn-xs updateService"><i class="fa fa-pencil-alt"></i></button>';
		} else {
			$updateService = '' ;
		}
		if($statuss == 1) {
			// Deactivate Service
			$statuss = "<b>Active</b>";
			if( ($_SESSION['type']['user_role'] == 'Admin')) {
				$myLink = '<button type="button" name="changeServiceStatus" id="'.$productId.'" class="btn btn-danger btn-xs changeServiceStatus" data-status="0">Deactivate</button>';
			} else {
				$myLink = '' ;
			}
		} else {
			// Activate Service
			$statuss = "Not Active";
			if( ($_SESSION['type']['user_role'] == 'Admin')) {
				$myLink = '<button type="button" name="changeServiceStatus" id="'.$productId.'" class="btn btn-success btn-xs changeServiceStatus" data-status="1">Activate</button>';
			} else {
				$myLink = '' ;
			} 
		}
		$output['data'][] = array( 		
		$productId,
		$userEmail,
		$editedBy,
		$categoryName,
		$brandName,
		$productName,
		$productSKU,
		$productQuantity,
		$productUnit,
		$productTaxRate,
		$productBasePrice,
		_e($taxPrice),
		$productSellingPrice,
		$statuss,
		$updateService,
		$myLink		
		); 	
	}
}
echo json_encode($output);
?>