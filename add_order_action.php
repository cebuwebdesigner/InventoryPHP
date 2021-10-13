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
		if(!empty($_POST['ordercustomer_id'])  && !empty($_POST["product_id"])){
			
			$customer_id = filter_var($_POST['ordercustomer_id'], FILTER_SANITIZE_NUMBER_INT) ;
			$enter_by = filter_var($_SESSION['type']['id'], FILTER_SANITIZE_NUMBER_INT) ;
			$order_date = filter_var(date("Y-m-d", strtotime($_POST['order_date'])), FILTER_SANITIZE_STRING) ;
			$customer_email = filter_var($_POST['ordercustomer_email'], FILTER_SANITIZE_EMAIL) ;
			$customer_mobile = filter_var($_POST['ordercustomer_mobile'], FILTER_SANITIZE_NUMBER_INT) ;
			$customer_name = filter_var($_POST['ordercustomer_name'], FILTER_SANITIZE_STRING) ;
			$customer_tax = filter_var($_POST['ordercustomer_tax'], FILTER_SANITIZE_STRING) ;
			$discount = filter_var($_POST['discount'], FILTER_SANITIZE_STRING) ;
			$totalAftertax = filter_var($_POST['totalAftertax'], FILTER_SANITIZE_STRING) ;
			$paid = filter_var($_POST['paid'], FILTER_SANITIZE_STRING) ;
			
			$due = filter_var($_POST['due'], FILTER_SANITIZE_STRING) ;
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
						$product_single_price = (($product_details['product_selling_price']*$quantity) - (($product_details['product_selling_price']*$quantity)*($discount/100)) );
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
	
	if($_POST['btn_action_pro'] == 'fetch_order')
	{
		if(!empty($_POST['orderId'])){
			$orderId = filter_var($_POST['orderId'], FILTER_SANITIZE_NUMBER_INT) ;
			$Statement = $pdo->prepare("select * from billing_order where order_id = ? ");
			$Statement->execute(array($orderId));
			$result = $Statement->fetchAll(PDO::FETCH_ASSOC);
			$output = array();
			foreach($result as $row) {
				$output['order_customer_id'] = _e($row['order_customer_id']);
				$output['order_paid_amount'] = _e($row['order_paid_amount']);
				$output['order_due_amount'] = _e($row['order_due_amount']);
				$output['order_discount'] = _e($row['order_discount']);
				$output['order_total'] = _e($row['order_total']);
				$output['order_date'] = _e($row['order_date']);
				$output['order_customer_email'] = _e($row['order_customer_email']) ;
				$output['order_customer_mobile'] = _e($row['order_customer_mobile']) ;
				$output['order_customer_tax_no'] = _e($row['order_customer_tax_no']) ;
				$output['order_customername'] = _e($row['order_customername']) ;
			}
			$sub_query = "SELECT * FROM billing_order_detail WHERE billing_order_id = '".$orderId."'";
			$statement = $pdo->prepare($sub_query);
			$statement->execute();
			$sub_result = $statement->fetchAll(PDO::FETCH_ASSOC);
			$product_details = '';
			$count = 0;
			foreach($sub_result as $sub_row) {
				
				$product_name = "SELECT * FROM billing_product WHERE product_id = '"._e($sub_row["product_id"])."'" ;
				$product_statement = $pdo->prepare($product_name);
				$product_statement->execute();
				$product_result = $product_statement->fetchAll(PDO::FETCH_ASSOC);
				foreach($product_result as $pro) {
					$productName = _e($pro['product_name']);
				}
				$singleproduct_name = "SELECT * FROM billing_product WHERE 1 " ;
				$singleproduct_statement = $pdo->prepare($singleproduct_name);
				$singleproduct_statement->execute();
				$singleproduct_result = $singleproduct_statement->fetchAll(PDO::FETCH_ASSOC);
				$option ='';
				$select[$count] = '';
				foreach($singleproduct_result as $singlepro) {
					$singleproductName = _e($singlepro['product_name']);
					$p_sku = _e("[".$singlepro['product_sku']."] ");
					$productSellingPrice = _e($singlepro['product_selling_price']);
					$productId = _e($singlepro['product_id']);
					
					if($sub_row["product_id"] == $productId) {
						$select[$count] = "selected";
					} else {
						$select[$count] = "";
					}
				$option .= '<option data-price="'.$productSellingPrice.'" value="'.$productId.'" '.$select[$count].' >'.$p_sku.$singleproductName.'</option>';
				}
				if($count == 0) {
					$product_details .= '<button type="button" name="add_more" id="add_editmore" class="btn btn-success btn-xs ">+Add Product</button>';
				}
				$product_details .= '<span id="row'.$count.'"><div class="row"><div class="col-md-6"><div class="form-group"><label>Product</label><select name="product_id[]" id="product_id'.$count.'" class="form-control selectpicker editproduct_id" data-live-search="true" >'.$option.'</select></div></div><div class="col-md-2"><div class="form-group"><label>Quantity</label><input type="text" name="quantity[]" id="quantity'.$count.'" class="form-control editquantity" value="'._e($sub_row['quantity']).'" required "/></div></div><div class="col-md-3"><div class="form-group"><label>Price</label><span class="myproduct_price'.$count.'"><input type="text" name="product_price[]" id="product_price'.$count.'" class="form-control editproduct_price" value="'._e($sub_row['product_total_price']).'" readonly="readonly"/></span></div></div><div class="col-md-1"><div class="form-group"><label>Remove</label>';
					$product_details .= '<button type="button" name="remove" id="'.$count.'" class="btn btn-danger btn-xs remove"><i class="fa fa-trash"></i></button></div></div>';
				
				$product_details .= '</div></span>';
				$count++ ;
			}
			$output['product_details'] = $product_details;
			echo json_encode($output);
		} else {
			echo "All fields are mandatory" ;
		}
	}
	if($_POST['btn_action_pro'] == 'EditOrder')
	{
		if(!empty($_POST['order_id']) && !empty($_POST["product_id"])){
			$orderId = filter_var($_POST['order_id'], FILTER_SANITIZE_NUMBER_INT) ;
			$edited_by = filter_var($_SESSION['type']['id'], FILTER_SANITIZE_NUMBER_INT) ;
			$order_date = filter_var(date("Y-m-d", strtotime($_POST['order_date'])), FILTER_SANITIZE_STRING) ;
			$customer_email = filter_var($_POST['editordercustomer_email'], FILTER_SANITIZE_EMAIL) ;
			$customer_mobile = filter_var($_POST['editordercustomer_mobile'], FILTER_SANITIZE_NUMBER_INT) ;
			$customer_name = filter_var($_POST['editordercustomer_name'], FILTER_SANITIZE_STRING) ;
			$customer_tax = filter_var($_POST['editordercustomer_tax'], FILTER_SANITIZE_STRING) ;
			$discount = filter_var($_POST['editdiscount'], FILTER_SANITIZE_STRING) ;
			$totalAftertax = filter_var($_POST['edittotalAftertax'], FILTER_SANITIZE_STRING) ;
			$paid = filter_var($_POST['editpaid'], FILTER_SANITIZE_STRING) ;
			$due = filter_var($_POST['editdue'], FILTER_SANITIZE_STRING) ;
			if($due < '1') {
				$payment_status = filter_var('1', FILTER_SANITIZE_NUMBER_INT) ;
			} else {
				$payment_status = filter_var('0', FILTER_SANITIZE_NUMBER_INT) ;
			}
			$delete_query = "DELETE FROM billing_order_detail WHERE billing_order_id = '".$orderId."'";
			$deletestatement = $pdo->prepare($delete_query);
			$deletestatement->execute();
			if(isset($deletestatement)) {
				for($count = 0; $count < count($_POST["product_id"]); $count++) {
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
					$product_single_price = (($product_details['product_selling_price']*$quantity) - (($product_details['product_selling_price']*$quantity)*($discount/100)) );
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
								':billing_order_id'	       =>	$orderId,
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
					//update Order Table
					$update_order = $pdo->prepare("update billing_order set order_edited_by = ? , order_total = ? , order_customername = ? , order_customer_email = ? , order_customer_mobile = ? , order_customer_tax_no = ? , order_paid_amount= ? , order_due_amount = ? , order_discount = ? , order_date = ? , order_payment_status = ? , order_status = ? where order_id = ?");
					$update_order->execute(array($edited_by,$totalAftertax,$customer_name,$customer_email,$customer_mobile,$customer_tax,$paid,$due,$discount,$order_date,$payment_status,filter_var('1', FILTER_SANITIZE_NUMBER_INT),$orderId));
				}
				echo "Order Edited Successfully." ;
			} else {
				echo "Order cannot be Edited. Something went wrong. Try Again." ;
			}
		} else {
			echo "Please choose Any Product to Edit.";
		}
	}
	if($_POST['btn_action_pro'] == 'fetch_due_amount')
	{
		if(!empty($_POST['orderId'])){
			$orderId = filter_var($_POST['orderId'], FILTER_SANITIZE_NUMBER_INT) ;
			$Statement = $pdo->prepare("select * from billing_order where order_id = ? ");
			$Statement->execute(array($orderId));
			$result = $Statement->fetchAll(PDO::FETCH_ASSOC);
			foreach($result as $row) {
				$output['order_id'] = _e($row['order_id']) ;
				$output['order_total'] = _e($row['order_total']) ;
				$output['order_due_amount'] = _e($row['order_due_amount']) ;
			}
			echo json_encode($output);
		} else {
			echo "Order ID is mandatory. Try Again." ;
		}
	}
	if($_POST['btn_action_pro'] == 'ClearDueAmount')
	{
		if(!empty($_POST['dueorder_id'])){
			$orderId = filter_var($_POST['dueorder_id'], FILTER_SANITIZE_NUMBER_INT) ;
			$orderTotal = filter_var($_POST['order_totalamt'], FILTER_SANITIZE_STRING);
			//update Order Table
			$update_order = $pdo->prepare("update billing_order set order_paid_amount= ? , order_due_amount = ? , order_payment_status = ?  where order_id = ?");
			$update_order->execute(array($orderTotal,filter_var('0.00', FILTER_SANITIZE_STRING),filter_var('1', FILTER_SANITIZE_NUMBER_INT),$orderId));
			
		} else {
			echo "Order ID is mandatory. Try Again." ;
		}
	}
}
?>