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

if(isset($_POST['categorywise_action_pro']))
{
	if($_POST['categorywise_action_pro'] == 'fetchCategorywiseOrder') {
		$start_date = filter_var(date($_POST['datewise_startdate']), FILTER_SANITIZE_STRING) ;
		$end_date = filter_var(date($_POST['datewise_enddate']), FILTER_SANITIZE_STRING) ;
		if($_SESSION['type']['user_role'] == 'Admin') {
		
			$Statement = $pdo->prepare("select billing_category.category_name as CategoryName , billing_category.category_id as CategoryId , sum(cast((REPLACE(CONCAT(billing_order_detail.product_price_taxamount), ',', '')) as decimal(10,2))) as TaxAmount, sum(cast((REPLACE(CONCAT(billing_order_detail.product_price_beforetax), ',', '')) as decimal(10,2))) as ProductTotalPriceBeforeTax, sum(billing_order_detail.product_total_price) as ProductTotalPrice, sum(billing_order_detail.quantity) as Qty from billing_order_detail left join billing_product on (billing_order_detail.product_id = billing_product.product_id) left join billing_order on (billing_order_detail.billing_order_id = billing_order.order_id) left join billing_category on (billing_category.category_id = billing_product.category_id) where billing_order.order_date between '$start_date' and '$end_date' GROUP BY billing_category.category_id");
			$Statement->execute();
		} else {
			$Statement = $pdo->prepare("select billing_category.category_name as CategoryName , billing_category.category_id as CategoryId , sum(cast((REPLACE(CONCAT(billing_order_detail.product_price_taxamount), ',', '')) as decimal(10,2))) as TaxAmount, sum(cast((REPLACE(CONCAT(billing_order_detail.product_price_beforetax), ',', '')) as decimal(10,2))) as ProductTotalPriceBeforeTax, sum(billing_order_detail.product_total_price) as ProductTotalPrice, sum(billing_order_detail.quantity) as Qty from billing_order_detail left join billing_product on (billing_order_detail.product_id = billing_product.product_id) left join billing_order on (billing_order_detail.billing_order_id = billing_order.order_id) left join billing_category on (billing_category.category_id = billing_product.category_id) where billing_order.order_enter_by = '".$_SESSION['type']['id']."' and billing_order.order_date between '$start_date' and '$end_date' GROUP BY billing_category.category_id");
			$Statement->execute();
		}
		$result = $Statement->fetchAll(PDO::FETCH_ASSOC);
		$total = $Statement->rowCount(); 
		$output = array('data' => array());
		if($total > 0) {
			foreach($result as $row) {
				$CategoryName = _e($row['CategoryName']) ;
				$CategoryId = _e($row['CategoryId']) ;
				$TaxAmount = _e($row['TaxAmount']) ;
				$ProductTotalPriceBeforeTax = _e($row['ProductTotalPriceBeforeTax']) ;
				$ProductTotalPrice =  _e($row['ProductTotalPrice']) ;
				$Qty =   _e($row['Qty']) ;
				$output['data'][] = array( 
				$CategoryId,
				$CategoryName,
				$Qty,
				$ProductTotalPrice,
				number_format($ProductTotalPriceBeforeTax,2),
				number_format($TaxAmount,2)
				);
			}
			
		}
		echo json_encode($output);
	} else {
		echo "All fields are mandatory";
	}
}
?>