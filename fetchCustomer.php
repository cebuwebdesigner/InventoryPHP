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
$Statement = $pdo->prepare("SELECT * FROM billing_user LEFT JOIN billing_admin ON (billing_admin.id = billing_user.enter_by) ORDER BY billing_user.customer_id DESC ");
$Statement->execute(); 
$total = $Statement->rowCount();    
$result = $Statement->fetchAll(PDO::FETCH_ASSOC); 
$output = array('data' => array());
if($total > 0) {
	$statuss = "";
	foreach($result as $row) {
		$customerId = _e($row['customer_id']) ;
		$customerName = _e($row['customer_name']) ;
		$customerUserName = _e($row['customer_username']) ;
		$customerEmail = _e($row['customer_email']) ;
		$customerPhone = _e($row['customer_phone']) ;
		$customerTaxNo = _e($row['customer_tax_no']) ;
		$customeDate = _e($row['customer_date']) ;
		$statuss = _e($row['customer_status']) ;
		$manEmail = _e($row['email']) ;
		$manRole = _e($row['user_role']) ;
		$enter_by =  _e($row['enter_by']);
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
		$createOrderLink = '<button type="button" name="createOrder" id="'.$customerId.'" class="btn btn-success btn-xs createOrder">CreateOrder</button>'; 
		if( ($_SESSION['type']['user_role'] != 'Admin') && ($_SESSION['type']['id'] != $enter_by ) ) {
			$updateCustomer = '' ;
			$myLink = '' ;
			if($statuss == 1) {
				$statuss = "<b>Active</b>";
			} else {
				$statuss = "Not Active";
			}
			
		} else {
			$updateCustomer = '<button type="button" name="updateCustomer" id="'.$customerId.'" class="btn btn-light btn-xs updateCustomer"><i class="fa fa-pencil-alt"></i></button>';
			if($statuss == 1) {
				// Deactivate Customer
				$statuss = "<b>Active</b>";
				$myLink = '<button type="button" name="changeCustomerStatus" id="'.$customerId.'" class="btn btn-danger btn-xs changeCustomerStatus" data-status="0">Deactivate</button>';
			} else {
				// Activate Customer
				$createOrderLink = '<button type="button" name="createOrder" id="'.$customerId.'" class="btn btn-success btn-xs createOrder" disabled>CreateOrder</button>';
				$statuss = "Not Active";
				$myLink = '<button type="button" name="changeCustomerStatus" id="'.$customerId.'" class="btn btn-success btn-xs changeCustomerStatus" data-status="1">Activate</button>';
			}
		}
		$output['data'][] = array( 		
		$customerId,
		$customerName,
		$customerUserName,
		$customerEmail,
		$customerPhone,
		$customeDate,
		$customerTaxNo,
		$statuss,
		$manEmail,
		$manRole,
		$editedBy,
		$editedRole,
		$createOrderLink,
		$updateCustomer,
		$myLink		
		); 	
	}
}
echo json_encode($output);
?>