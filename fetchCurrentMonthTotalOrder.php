<?php
ob_start();
session_start();
include("db/config.php");
include("db/function_xss.php");
// Checking Admin is logged in or not
if( ($_SESSION['type']['user_role'] != 'Admin')){
	header('location: '.ADMIN_URL.'/index.php');
	exit;
}
$firstday = date('Y-m-01');
$lastday = date('Y-m-t') ;
if($_SESSION['type']['user_role'] == 'Admin') {
	$Statement = $pdo->prepare("select sum(order_total) as Total, count(order_id) as Order_count , id, email, user_role from billing_order LEFT JOIN billing_admin on (billing_order.order_enter_by = billing_admin.id) where 1 and order_date between '$firstday' and '$lastday' GROUP BY order_enter_by order by billing_admin.id ASC ");
	$Statement->execute();
	$result = $Statement->fetchAll(PDO::FETCH_ASSOC);
	$total = $Statement->rowCount(); 
	$output = array('data' => array());
	if($total > 0) {
		foreach($result as $row) {
			$id = _e($row['id']);
			$email = _e($row['email']);
			$role = _e($row['user_role']);
			$totalOrder = _e($row['Order_count']);
			$totalAmt = _e($row['Total']);
			$output['data'][] = array( 
			$id,
			$email,
			$role,
			$totalOrder,
			$totalAmt
		);
		}
		
	}
	echo json_encode($output);
}
?>