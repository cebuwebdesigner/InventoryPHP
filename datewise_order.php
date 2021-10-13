<?php
if(isset($_POST["download"]) && isset($_POST['order_date']))
{

	require_once 'pdf.php';
	require_once 'db/config.php';
	require_once 'db/function_xss.php';
	
	$role = filter_var($_POST['role'], FILTER_SANITIZE_STRING);
	$uid = filter_var($_POST['uid'] , FILTER_SANITIZE_NUMBER_INT);
	$order_date = filter_var(date($_POST['order_date']), FILTER_SANITIZE_STRING);
	$output = '';
	if($role == 'Admin') {
		$statement = $pdo->prepare("SELECT * FROM billing_order WHERE order_date = :order_date and order_status = :order_status");
		$statement->execute(
						array(
							':order_date'       =>  $order_date,
							':order_status'     =>  filter_var('1', FILTER_SANITIZE_NUMBER_INT)
						)
		);
	} else {
		$statement = $pdo->prepare("SELECT * FROM billing_order WHERE order_date = :order_date and order_status = :order_status and order_enter_by = :order_enter_by");
		$statement->execute(
						array(
							':order_date'       =>  $order_date,
							':order_status'     =>  filter_var('1', FILTER_SANITIZE_NUMBER_INT),
							':order_enter_by'   =>  $uid
						)
		);
	}
	$result = $statement->fetchAll();
	$path = 'images/siteLogo.png';
	$type = pathinfo($path, PATHINFO_EXTENSION);
	$data = file_get_contents($path);
	$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
	$output .= '<link rel="stylesheet" href="css/bootstrap.min.css" />';
	$output .= '
				<table class="table table-bordered text-center">
					<tr>
						<td><img src ="'._e($base64).'" ></td>
					</tr>
				</table>
				';
	foreach($result as $row) {
		$output .= '
					<table class="table table-bordered text-center">
						<thead  class="thead-light">
							<tr>
								<th>Order ID</th>
								<th>Amount</th>
								<th>Name</th>
								<th>Email</th>
								<th>Contact</th>
								<th colspan="4">Tax No.</th>
							</tr>
						</thead>
						
							<tr>
								<td>'._e($row['order_id']).'</td>
								<td>'._e($row['order_total']).'</td>
								<td>'._e($row['order_customername']).'</td>
								<td>'._e($row['order_customer_email']).'</td>
								<td>'._e($row['order_customer_mobile']).'</td>
								<td colspan="4">'._e($row['order_customer_tax_no']).'</td>
							</tr>
						
						<thead  class="thead-dark">
							<tr>
								<th>S.No.</th>
								<th>Product</th>
								<th>Quantity</th>
								<th>Price</th>
								<th>Discount %</th>
								<th>Offered Price</th>
								<th>Tax %</th>
								<th>Tax Price</th>
								<th>Sub Total</th>
							</tr>
						</thead>
						';
		$order_detail = $pdo->prepare("SELECT * FROM billing_order_detail WHERE billing_order_id = :billing_order_id");
		$order_detail->execute(
						array(
							':billing_order_id'  =>  _e($row['order_id'])
						)
					);
		$order_result = $order_detail->fetchAll();
		$count = 0 ;
		$total_tax_amt = 0;
		$total_actual_amount = 0;
		$total_offered_price = 0;
		foreach($order_result as $sub_row){
			$product_detail = $pdo->prepare("select * from billing_product where product_id = '"._e($sub_row['product_id'])."'");
			$product_detail->execute();
			foreach($product_detail as $product){
				$productName = _e($product['product_name']) ;
			}
			$count = $count + 1;
			$a = str_replace(',', '', _e($sub_row['product_price_taxamount']));
			$b = str_replace(',', '', _e($sub_row['product_price_beforetax']));
			$total_actual_amount = $total_actual_amount + _e($sub_row['product_total_price']);
			$total_tax_amt =  (float)$total_tax_amt + (float)$a;
			$total_offered_price = (float)$total_offered_price + (float)$b;
			$output .= '
						<tr>
							<td>'.$count.'</td>
							<td>'.$productName.'</td>
							<td>'._e($sub_row['quantity']).'</td>
							<td>'._e($sub_row['price_aftertax']).'</td>
							<td>'._e($row['order_discount']).'</td>
							<td>'._e($sub_row['product_price_beforetax']).'</td>
							<td>'._e($sub_row['tax_percent']).'</td>
							<td>'._e($sub_row['product_price_taxamount']).'</td>
							<td>'._e($sub_row['product_total_price']).'</td>
						</tr>
			
			';
		}
		$output .= '
					<tr>
						<td colspan="5"><b>Total<b></td>
						<td><b>'.$total_offered_price.'</b></td>
						<td>&nbsp;</td>
						<td><b>'.$total_tax_amt.'</b></td>
						<td><b>'.$total_actual_amount.'</b></td>
					</tr>
		
		';	
		
		$output .=	'</table><br><br>';
	}	
	$pdf = new Pdf();
	$file_name = 'DatewiseOrder-'.$order_date.'.pdf';
	$pdf->loadHtml($output);
	$pdf->render();
	$canvas = $pdf->getCanvas();
	$canvas->page_script('
	  $pdf->set_opacity(.9);
	  $pdf->image("'.ADMIN_URL.'/images/siteLogo.png", {100}, {100}, {300}, {300});
	');
	$pdf->stream($file_name, array("Attachment" => false));
		
} else {
	echo "Something Went wrong try again.";
}
?>