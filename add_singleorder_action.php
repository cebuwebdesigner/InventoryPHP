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
if(isset($_POST['btn_action_pro']))
{
	if($_POST['btn_action_pro'] == 'fetch_customer')
	{
		if(!empty($_POST['customer_id'])){
			$customer_id = filter_var($_POST['customer_id'], FILTER_SANITIZE_NUMBER_INT) ; 
			$Statement = $pdo->prepare("select * from billing_user where customer_id = ? ");
			$Statement->execute(array($customer_id));
			$result = $Statement->fetchAll(PDO::FETCH_ASSOC);
			foreach($result as $row) {
				$output['customer_email'] = _e($row['customer_email']) ;
				$output['customer_mobile'] = _e($row['customer_phone']) ;
				$output['customer_tax'] = _e($row['customer_tax_no']) ;
				$output['customer_name'] = _e($row['customer_name']) ;
			}
			echo json_encode($output);
		} else {
			echo "All fields are mandatory" ;
		}
	}
	if($_POST['btn_action_pro'] == 'AddOrder')
	{
		if(!empty($_POST['singleordercustomer_id']) && !empty($_POST['product_id'])){
			
			$customer_id = filter_var($_POST['singleordercustomer_id'], FILTER_SANITIZE_NUMBER_INT) ;
			$enter_by = filter_var($_SESSION['type']['id'], FILTER_SANITIZE_NUMBER_INT) ;
			$order_date = filter_var(date("Y-m-d", strtotime($_POST['order_date'])), FILTER_SANITIZE_STRING) ;
			$customer_email = filter_var($_POST['singleordercustomer_email'], FILTER_SANITIZE_EMAIL) ;
			$customer_mobile = filter_var($_POST['singleordercustomer_mobile'], FILTER_SANITIZE_NUMBER_INT) ;
			$customer_name = filter_var($_POST['singleordercustomer_name'], FILTER_SANITIZE_STRING) ;
			$customer_tax = filter_var($_POST['singleordercustomer_tax'], FILTER_SANITIZE_STRING) ;
			$discount = filter_var($_POST['singlediscount'], FILTER_SANITIZE_STRING) ;
			$totalAftertax = filter_var($_POST['singletotalAftertax'], FILTER_SANITIZE_STRING) ;
			$paid = filter_var($_POST['singlepaid'], FILTER_SANITIZE_STRING) ;
			
			$due = filter_var($_POST['singledue'], FILTER_SANITIZE_STRING) ;
			if($due < '1') {
				$payment_status = filter_var('1', FILTER_SANITIZE_NUMBER_INT) ;
			} else {
				$payment_status = filter_var('0', FILTER_SANITIZE_NUMBER_INT) ;
			}
			$ins_order = $pdo->prepare("insert into billing_order (order_customer_id, order_enter_by, order_total, order_customername, order_customer_email, order_customer_mobile, order_customer_tax_no, order_paid_amount, order_due_amount, order_discount, order_date, order_payment_status, order_status) values (?,?,?,?,?,?,?,?,?,?,?,?,?)");
			$ins_order->execute(array($customer_id,$enter_by,$totalAftertax,$customer_name,$customer_email,$customer_mobile,$customer_tax,$paid,$due,$discount,$order_date,$payment_status,filter_var('1', FILTER_SANITIZE_NUMBER_INT)));
			$statement = $pdo->query("SELECT LAST_INSERT_ID()");
			$inventory_order_id = $statement->fetchColumn();
			if(isset($inventory_order_id)) {
				for($count = 0; $count<count($_POST["product_id"]); $count++) {
						$product_id = filter_var($_POST['product_id'][$count], FILTER_SANITIZE_NUMBER_INT) ;
						$quantity = filter_var($_POST['quantity'][$count], FILTER_SANITIZE_NUMBER_INT) ;
					    $query = "SELECT * FROM billing_product WHERE product_id = '".$product_id."'";
						$statement = $pdo->prepare($query);
						$statement->execute();
						$result = $statement->fetchAll();
						foreach($result as $row){
							$product_details['product_id'] = _e($row['product_id']);
							$product_details['product_name'] = _e($row['product_name']) ;
							$product_details['product_sku'] = _e($row['product_sku']) ;
							$product_details['product_quantity'] = _e($row['product_quantity']);
							$product_details['product_selling_price'] = _e($row['product_selling_price']) ;
							$product_details['product_base_price'] = _e($row['product_base_price']) ;
							$product_details['product_tax_rate'] = _e($row['product_tax_rate']) ;
						}
                    
                   // (($product_details['product_selling_price']*$quantity)*($discount/100))
						$product_single_price = (($product_details['product_selling_price']*$quantity) - $discount );
						 $selling_price = number_format($product_details['product_selling_price'],2) ;
						 $a = str_replace(',', '', $selling_price);
						 $b = $product_details['product_base_price'] ;
						 $b = str_replace(',', '', $b);
						 $product_price_beforetax = number_format(($b-($b*($discount/100))) * $quantity,2) ;
						$tax_amount = $a - $b ;
						$product_pricetaxamount =  number_format(($tax_amount-($tax_amount*($discount/100))) * $quantity,2) ;
						$sub_query = "INSERT INTO billing_order_detail (billing_order_id, product_id, quantity, price_beforetax, price_aftertax, tax_percent, tax_amount, product_price_beforetax, product_price_taxamount, product_total_price) VALUES (:billing_order_id, :product_id, :quantity, :price_beforetax, :price_aftertax, :tax_percent, :tax_amount, :product_price_beforetax, :product_price_taxamount, :product_total_price)";
						$statement = $pdo->prepare($sub_query);
						$statement->execute(
							array(
								':billing_order_id'	       =>	$inventory_order_id,
								':product_id'			   =>	$product_id,
								':quantity'				   =>	$quantity,
								':price_beforetax'		   =>	$product_details['product_base_price'],
								':price_aftertax'		   =>	$product_details['product_selling_price'],
								':tax_percent'			   =>   $product_details['product_tax_rate'],
								':tax_amount'              =>   $tax_amount,
								':product_price_beforetax' =>   $product_price_beforetax,
								':product_price_taxamount'  =>  $product_pricetaxamount,
								':product_total_price'     =>   $product_single_price
							)
						);
				}
				echo "Order ID: ".$inventory_order_id." Created for Customer ID : ".$customer_id.", Go to Manage Order for View / Edit.";
			} else {
				echo "Order Not Created.";
			}
			
		} else {
			echo "Error : Please choose any product" ; 
		}
	}
}
?>