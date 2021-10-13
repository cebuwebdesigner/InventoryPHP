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

if(isset($_POST['datewise_action_pro']))
{
	if($_POST['datewise_action_pro'] == 'fetchDatewiseOrder') {
		$start_date = filter_var(date($_POST['datewise_startdate']), FILTER_SANITIZE_STRING) ;
		$end_date = filter_var(date($_POST['datewise_enddate']), FILTER_SANITIZE_STRING) ;
		if($_SESSION['type']['user_role'] == 'Admin') {
			$Statement = $pdo->prepare("select sum(order_total) as Total, count(order_id) as Order_count , id, email, user_role from billing_order LEFT JOIN billing_admin on (billing_order.order_enter_by = billing_admin.id) where 1 and order_date between '$start_date' and '$end_date' GROUP BY order_enter_by order by billing_admin.id ASC");
			$Statement->execute();
		} else {
			$Statement = $pdo->prepare("select sum(order_total) as Total, count(order_id) as Order_count , id, email, user_role from billing_order LEFT JOIN billing_admin on (billing_order.order_enter_by = billing_admin.id) where order_enter_by = '".$_SESSION['type']['id']."' and order_date between '$start_date' and '$end_date' GROUP BY order_enter_by order by billing_admin.id ASC");
			$Statement->execute();
		}
		$result = $Statement->fetchAll(PDO::FETCH_ASSOC);
		$total = $Statement->rowCount(); 
		$output = array('data' => array());
		$total_tax_amt = 0 ;
		$total_sales_amount = 0 ;
		$estimated_earning = 0 ;
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
			$query = "SELECT * FROM billing_order WHERE order_status='1' and order_date between '$start_date' and '$end_date'";
			if($_SESSION['type']['user_role'] == 'Manager')
			{
				$query .= ' AND order_enter_by = "'.$_SESSION['type']['id'].'"';
			}
			$statement = $pdo->prepare($query);
			$statement->execute();
			$subresult = $statement->fetchAll();
			$subtotal = $statement->rowCount();
			if($subtotal > 0) {
				foreach($subresult as $subrow) {
					$total_sales_amount = $total_sales_amount + _e($subrow['order_total']) ;
					$productId = _e($subrow['order_id']);
					$sub_row = $pdo->prepare("select product_price_taxamount, product_price_beforetax from billing_order_detail where billing_order_id = '".$productId."'");
					$sub_row->execute();
					$result_sub_row = $sub_row->fetchAll();
					foreach($result_sub_row as $order_tax) {
						$a = str_replace(',', '', _e($order_tax['product_price_taxamount']));
						$total_tax_amt =  (float)$total_tax_amt + (float)$a;
						$b = str_replace(',', '', _e($order_tax['product_price_beforetax']));
						$estimated_earning = (float)$estimated_earning + (float)$b ;
					}
				}
				$output['datatwo'][] = array(
					$subtotal,
					$total_sales_amount,
					number_format($estimated_earning,2),
					number_format($total_tax_amt,2)
					);
			}
		}
		echo json_encode($output);
	} else {
		echo "All fields are mandatory" ;
	}
	
}

?>