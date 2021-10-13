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
$Statement = $pdo->prepare("SELECT * FROM billing_product LEFT JOIN billing_category ON (billing_category.category_id = billing_product.category_id) LEFT JOIN billing_brand ON (billing_brand.brand_id = billing_product.brand_id) LEFT JOIN billing_admin ON (billing_admin.id = billing_product.product_enter_by) ORDER BY billing_product.product_id DESC ");
$Statement->execute(); 
$total = $Statement->rowCount();    
$result = $Statement->fetchAll(PDO::FETCH_ASSOC); 
$output = array('data' => array());
if($total > 0) {
	$statuss = "";
	foreach($result as $row) {
		$productId = _e($row['product_id']) ;
		$categoryName = _e($row['category_name']) ;
		$brandName = _e($row['brand_name']) ;
		$statuss = _e($row['product_status']) ;
		$productName = _e($row['product_name']) ;
		$productSKU = _e($row['product_sku']) ;
		$productQuantity = available_product_quantity($pdo,$productId) ;
		$productUnit = _e($row['product_unit']) ;
		$productBasePrice = _e($row['product_base_price']) ;
		$productTaxRate = _e($row['product_tax_rate']) ;
		$productSellingPrice = _e($row['product_selling_price']) ;
		$productEnterBy = _e($row['product_enter_by']) ;
		$userEmail = _e($row['email']) ;
		$userRole = _e($row['user_role']) ;
		$enter_by =  _e($row['product_edited_by']);
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
			$updateProduct = '<button type="button" name="updateProduct" id="'.$productId.'" class="btn btn-light btn-xs updateProduct"><i class="fa fa-pencil-alt"></i></button>';
		} else {
			$updateProduct = '' ;
		}
		if($statuss == 1) {
			// Deactivate Product
			$statuss = "<b>Active</b>";
			if( ($_SESSION['type']['user_role'] == 'Admin')) {
				$myLink = '<button type="button" name="changeProductStatus" id="'.$productId.'" class="btn btn-danger btn-xs changeProductStatus" data-status="0">Deactivate</button>';
			} else {
				$myLink = '' ;
			}
		} else {
			// Activate Product
			$statuss = "Not Active";
			if( ($_SESSION['type']['user_role'] == 'Admin')) {
				$myLink = '<button type="button" name="changeProductStatus" id="'.$productId.'" class="btn btn-success btn-xs changeProductStatus" data-status="1">Activate</button>';
			} else {
				$myLink = '' ;
			} 
		}
		$output['data'][] = array( 	
          
		//$productId,
            $productName,
		$categoryName,
		//$brandName,
		$productSKU,
		$productQuantity,
		/*$productUnit,
		$productTaxRate,
		$productBasePrice,
		_e($taxPrice),
		$productSellingPrice,**/
		
			
		$editedBy,
	  $updateProduct
            
			
		); 	
	}
}
echo json_encode($output);
?>