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

if($_SESSION['type']['user_role'] == 'Admin') {
	$Statement = $pdo->prepare("select * from billing_order2 where 1 order by order_id desc");
	$Statement->execute();
} else {
	$Statement = $pdo->prepare("select * from billing_order2 where order_enter_by = ? order by order_id desc");
	$Statement->execute(array($_SESSION['type']['id']));
}

$total = $Statement->rowCount();    
$result = $Statement->fetchAll(PDO::FETCH_ASSOC); 
$output = array('data' => array());
if($total > 0) {
	$orderPaymentStatus = "" ;
	$orderStatus = "" ;
	$enterByEmail = "" ;
	$enterByRole = "" ;
	$editedByEmail = "" ;
	$editedByRole = "" ;
	foreach($result as $row) {
		$orderId = _e($row['order_id']) ;
		$customerId = _e($row['order_customer_id']) ;
		$enterBy = _e($row['order_enter_by']) ;
		$editedBy = _e($row['order_edited_by']) ;
		$orderTotal = _e($row['order_total']) ;
		$customerName = _e($row['order_customername']) ;
		$customerEmail = _e($row['order_customer_email']) ;
		$customerMobile = _e($row['order_customer_mobile']) ;
		$customerTaxNo = _e($row['order_customer_tax_no']) ;
		$paidAmount = _e($row['order_paid_amount']) ;
		$dueAmount = _e($row['order_due_amount']) ;
		$discount = _e($row['order_discount']) ;
		$orderDate = _e($row['order_date']) ;
		$orderPaymentStatus = _e($row['order_payment_status']) ;
		$orderStatus = _e($row['order_status']) ;
		
		$enter_by_statement = $pdo->prepare("select email, user_role from billing_admin where id= ?");
		$enter_by_statement->execute(array($enterBy));
		$result_enter_by = $enter_by_statement->fetchAll(PDO::FETCH_ASSOC);
		$total = $enter_by_statement->rowCount();
		if($total > 0) {
			foreach ($result_enter_by as $enter) {
				$enterByEmail = _e($enter['email']);
				$enterByRole = _e($enter['user_role']);
			}
		}
		if(!empty($editedBy)){
			$edited_by_statement = $pdo->prepare("select email, user_role from billing_admin where id= ?");
			$edited_by_statement->execute(array($editedBy));
			$result_edited_by = $edited_by_statement->fetchAll(PDO::FETCH_ASSOC);
			$total = $edited_by_statement->rowCount();
			if($total > 0) {
				foreach ($result_edited_by as $edited) {
					$editedByEmail = _e($edited['email']);
					$editedByRole = _e($edited['user_role']);
				}
			}
		}
		$productDetail = "";
		$product_statement = $pdo->prepare("select service_name from billing_order2_detail left join billing_service on (billing_service.service_id = billing_order2_detail.service_id) where billing_order_id= ?");
		$product_statement->execute(array($orderId));
		$result_product = $product_statement->fetchAll(PDO::FETCH_ASSOC);
		$total = $product_statement->rowCount();
		if($total > 0) {
			foreach ($result_product as $product) {
				$productDetail .= _e($product['service_name']);
				$productDetail .= '<p></p>';
			}
		}
		if($orderStatus == 0) {
			//activate order
			$status = "Not Active";
			$changeOrderStatus = '<button type="button" name="changeOrderStatus" id="'.$orderId.'" class="btn btn-success btn-md changeOrderStatus" data-status="1">Activate</button>';
			$pendingBalance = '<button type="button" name="pendingBalance" id="'.$orderId.'" class="btn btn-light btn-md pendingBalance" disabled>Order Deactivated</button>';
			$download = '' ;
		} else {
			$download = '<a href="view_order.php?pdf=1&oid='.$orderId.'&cid='.$customerId.'" target="_blank" class="btn btn-sm btn-success">Download</a>';
			//deactivate order
			if($orderPaymentStatus == 0) {
				$pendingBalance = '<button type="button" name="pendingBalance" id="'.$orderId.'" class="btn btn-danger btn-md pendingBalance">ClearDue</button>';
			} else {
				$pendingBalance = '<button type="button" name="pendingBalance" id="'.$orderId.'" class="btn btn-light btn-md pendingBalance" disabled>NoDue</button>';
			}
			$status = "<b>Active</b>";
			$changeOrderStatus = '<button type="button" name="changeOrderStatus" id="'.$orderId.'" class="btn btn-danger btn-md changeOrderStatus" data-status="0">Deactivate</button>';
		}
		$editOrder = '<button type="button" name="editOrder" id="'.$orderId.'" class="btn btn-light btn-md editOrder"><i class="fa fa-pencil-alt"></i></button>';
		
        /*$customerName,
		$customerEmail,
		$customerMobile,
		$customerTaxNo,$enterByRole, $editedByRole,
		
		*/
		$output['data'][] = array( 		
		$orderId,
		$orderDate,
		$customerName,
		$enterByEmail,
		$editedByEmail,
		$productDetail,
		$orderTotal,
		$discount,
		$paidAmount,
		$download,
		$dueAmount,
		$status,
		$pendingBalance,
		$editOrder,
		$changeOrderStatus	
		);
		
	}
}
echo json_encode($output);
?>
