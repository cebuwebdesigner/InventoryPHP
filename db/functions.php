<?php
function fetch_currency($pdo){
	$currency = $pdo->prepare("select * from world_currencies where currency_status = '1'");
	$currency->execute();
	$result_currency = $currency->fetchAll(PDO::FETCH_ASSOC);
	foreach($result_currency as $cur) {
		$c = _e($cur['symbol_hex']);
		$chunks = str_split($c, 5);
		$res= implode('&#x', $chunks);
		echo "&#X".$res ;
	}
}
function fill_category_list($pdo)
{
	$query = "
	SELECT * FROM billing_category 
	WHERE category_status = '1' 
	ORDER BY category_name ASC
	";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$output = '';
	foreach($result as $row)
	{
		$output .= '<option value="'._e($row["category_id"]).'">'._e($row["category_name"]).'</option>';
	}
	return ($output);
}

function fill_category2_list($pdo)
{
	$query = "
	SELECT * FROM billing_category2 
	WHERE category_status = '1' 
	ORDER BY category_name ASC
	";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$output = '';
	foreach($result as $row)
	{
		$output .= '<option value="'._e($row["category_id"]).'">'._e($row["category_name"]).'</option>';
	}
	return ($output);
}


function fill_brand_list($pdo, $category_id)
{
	$query = "SELECT * FROM billing_brand 
	WHERE brand_status = '1' 
	AND category_id = '".$category_id."'
	ORDER BY brand_name ASC";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$output = '<option value="">Select Brand</option>';
	foreach($result as $row)
	{
		$output .= '<option value="'._e($row["brand_id"]).'">'._e($row["brand_name"]).'</option>';
	}
	return ($output);
}
function fill_tax_rate($pdo)
{
	$query = "
	SELECT * FROM billing_tax
	WHERE tax_status = '1' 
	ORDER BY tax_id DESC
	";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$output = '';
	foreach($result as $row)
	{
		$output .= '<option value="'._e($row["tax_slab_rate"]).'">'._e($row["tax_slab_rate"]).'</option>';
	}
	return ($output);
}

function fill_markup_rate($pdo)
{
	$query = "
	SELECT * FROM billing_markup
	WHERE markup_status = '1' 
	ORDER BY markup_id DESC
	";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$output = '';
	foreach($result as $row)
	{
		$output .= '<option value="'._e($row["markup_slab_rate"]).'">'._e($row["markup_slab_rate"]).'</option>';
	}
	return ($output);
}


function checkSKU($pdo,$productSKU) {
	$query = "select product_sku from billing_product where product_sku = ? " ;
	$statement = $pdo->prepare($query);
	$statement->execute(array($productSKU));
	$total = $statement->rowCount(); 
	if($total > 0) {
		echo "&ensp;[Duplicate SKU code, Product SKU code must be different for each Product.]";
	} else {
		echo "&ensp;[Product SKU available.]" ;
	}
}
function fetch_product_details($pdo, $product_id)
{
	$query = "
	SELECT * FROM billing_product 
	WHERE product_id = '".$product_id."'";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	foreach($result as $row)
	{
				$output['category_id'] = _e($row['category_id']);
				$output['brand_id'] = _e($row['brand_id']);
				$output["brand_select_box"] = fill_brand_list($pdo, _e($row["category_id"]));
				$output['product_name'] = _e($row['product_name']) ;
				$output['product_sku'] = _e($row['product_sku']) ;
				$output['product_quantity'] = _e($row['product_quantity']);
				$output['product_unit'] = _e($row['product_unit']) ;
				$output['product_selling_price'] = _e($row['product_selling_price']) ;
				$output['product_tax_rate'] = _e($row['product_tax_rate']) ;
	}
	return $output;
}
function available_product_quantity($pdo, $product_id)
{
	$product_data = fetch_product_details($pdo, $product_id);
	$query = "
	SELECT 	billing_order_detail.quantity FROM billing_order_detail 
	INNER JOIN billing_order ON billing_order.order_id = billing_order_detail.billing_order_id
	WHERE billing_order_detail.product_id = '".$product_id."' AND
	billing_order.order_status = '1' and billing_order.order_id != '0'
	";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$total = 0;
	foreach($result as $row)
	{
		$total = $total + $row['quantity'];
	}
	$available_quantity = intval($product_data['product_quantity']) - intval($total);
	if($available_quantity == 0 || $available_quantity < 1)
	{
		$update_query = "
		UPDATE billing_product SET 
		product_status = '0' 
		WHERE product_id = '".$product_id."'
		";
		$statement = $pdo->prepare($update_query);
		$statement->execute();
	} else {
		$update_activequery = "
		UPDATE billing_product SET 
		product_status = '1' 
		WHERE product_id = '".$product_id."'
		";
		$statement = $pdo->prepare($update_activequery);
		$statement->execute();
	}
	
	return $available_quantity;
}

function fill_product_list($pdo)
{
	$query = "
	SELECT * FROM billing_product 
	WHERE product_status = '1' 
	ORDER BY product_name ASC
	";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$output = '';
	foreach($result as $row)
	{
		$output .= '<option data-price="'._e($row['product_selling_price']).'" value="'._e($row["product_id"]).'">'._e("[".$row["product_sku"]."] ".$row["product_name"]).'</option>';
	}
	return ($output);
}

function fill_product_list2($pdo)
{
	$query = "
	SELECT * FROM billing_service 
	WHERE service_status = '1' 
	ORDER BY service_name ASC
	";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$output = '';
	foreach($result as $row)
	{
		$output .= '<option data-price="'._e($row['service_selling_price']).'" value="'._e($row["service_id"]).'">'._e("[".$row["service_sku"]."] ".$row["service_name"]).'</option>';
	}
	return ($output);
}
function fill_price($pdo, $product_id, $row_no)
{
	$query = "SELECT * FROM billing_product 
	WHERE product_status = '1' 
	AND product_id = '".$product_id."'";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$output = '';
	foreach($result as $row)
	{
		$output .= '<input type="text" name="product_price[]" id="product_price'.$row_no.'" class="form-control product_price" value="'._e($row['product_selling_price']).'" readonly="readonly"/>';
	}
	return ($output);
}
function fill_price_quantity($pdo, $product_id, $quantity)
{
	$query = "SELECT * FROM billing_product 
	WHERE product_status = '1' 
	AND product_id = '".$product_id."'";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$output = '';
	foreach($result as $row)
	{	
		if($quantity == '') {
			$quantity = 1;
		}
		$price = _e($row['product_selling_price']*$quantity);
		$output .= '<input type="text" name="product_price[]" id="product_price" class="form-control product_price" value="'.$price.'" readonly="readonly"/>';
	}
	return ($output);
}
function fill_only_price($pdo, $product_id, $row_no, $quantity)
{
	$query = "SELECT * FROM billing_product 
	WHERE product_status = '1' 
	AND product_id = '".$product_id."'";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$output = '';
	foreach($result as $row)
	{	
		if($quantity == '') {
			$quantity = 1;
		}
		$price = _e($row['product_selling_price']*$quantity);
		$output .= $price;
	}
	return ($output);
}
function fill_username($pdo)
{
	$query = "SELECT * FROM billing_user WHERE customer_status =1 ORDER BY customer_id ASC";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$output = '';
	foreach($result as $row)
	{
		$output .= '<option value="'._e($row["customer_id"]).'">'._e($row["customer_username"]).'</option>';
	}
	return ($output);
}
function count_total_order_value_curday($pdo)
{	
	$curday = date('Y-m-d');
	$query = "SELECT sum(order_total) as total_order_value FROM billing_order WHERE order_status='1' and order_date = '".$curday."'";
	if($_SESSION['type']['user_role'] == 'Manager')
	{
		$query .= ' AND order_enter_by = "'.$_SESSION['type']['id'].'"';
	}
	$statement = $pdo->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	foreach($result as $row)
	{
		if($row['total_order_value'] == '' || $row['total_order_value'] == '0'){
			$row['total_order_value'] = 0 ;
		}
		return number_format(_e($row['total_order_value']), 2);
	}
}
function count_total_orderwithouttax_value_curday($pdo)
{	
	$curday = date('Y-m-d');
	$query = "SELECT * FROM billing_order WHERE order_status='1' and order_date = '".$curday."'";
	if($_SESSION['type']['user_role'] == 'Manager')
	{
		$query .= ' AND order_enter_by = "'.$_SESSION['type']['id'].'"';
	}
	$statement = $pdo->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$total = $statement->rowCount();
	$total_ordervaluewithout_tax = 0;
	if($total > 0) {
		foreach($result as $row)
		{
			$productId = _e($row['order_id']);
			$sub_row = $pdo->prepare("select product_price_beforetax from billing_order_detail where billing_order_id = '".$productId."'");
			$sub_row->execute();
			$result_sub_row = $sub_row->fetchAll();
			foreach($result_sub_row as $order_price) {
				$b = str_replace(',', '', _e($order_price['product_price_beforetax']));
				$total_ordervaluewithout_tax = (float)$total_ordervaluewithout_tax + (float)$b;
				if($total_ordervaluewithout_tax == '' || $total_ordervaluewithout_tax == '0'){
					$total_ordervaluewithout_tax = 0.00;
				}
			}
		}
		return number_format($total_ordervaluewithout_tax,2) ;
	} else {
		return number_format(0, 2);
	}
}
function count_total_ordertax_value_curday($pdo)
{	
	$curday = date('Y-m-d');
	$query = "SELECT * FROM billing_order WHERE order_status='1' and order_date = '".$curday."'";
	if($_SESSION['type']['user_role'] == 'Manager')
	{
		$query .= ' AND order_enter_by = "'.$_SESSION['type']['id'].'"';
	}
	$statement = $pdo->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$total = $statement->rowCount();
	$total_tax_amt = 0;
	if($total > 0) {
		foreach($result as $row)
		{
			$productId = _e($row['order_id']);
			$sub_row = $pdo->prepare("select product_price_taxamount from billing_order_detail where billing_order_id = '".$productId."'");
			$sub_row->execute();
			$result_sub_row = $sub_row->fetchAll();
			foreach($result_sub_row as $order_tax) {
				$a = str_replace(',', '', _e($order_tax['product_price_taxamount']));
				$total_tax_amt =  (float)$total_tax_amt + (float)$a;
			}
		}
		return number_format($total_tax_amt,2) ;
	} else {
		return number_format(0, 2);
	}
}
function count_total_order_curday($pdo)
{	
	$curday = date('Y-m-d');
	$query = "SELECT * FROM billing_order WHERE order_status='1' and order_date = '".$curday."'";
	if($_SESSION['type']['user_role'] == 'Manager')
	{
		$query .= ' AND order_enter_by = "'.$_SESSION['type']['id'].'"';
	}
	$statement = $pdo->prepare($query);
	$statement->execute();
	$total = $statement->rowCount();
	return _e($total) ;
	
}
function count_total_order_value_curmonth($pdo)
{	
	$firstday = date('Y-m-01');
	$lastday = date('Y-m-t') ;
	$query = "SELECT sum(order_total) as total_order_value_month FROM billing_order WHERE order_status='1' and order_date between '$firstday' and '$lastday'";
	if($_SESSION['type']['user_role'] == 'Manager')
	{
		$query .= ' AND order_enter_by = "'.$_SESSION['type']['id'].'"';
	}
	$statement = $pdo->prepare($query);
	$statement->execute();
	$total = $statement->rowCount();
	$result = $statement->fetchAll();
	if($total > 0) {
		foreach($result as $row)
		{
			if($row['total_order_value_month'] == '' || $row['total_order_value_month'] == '0'){
			$row['total_order_value_month'] = 0 ;
			}
			return number_format(_e($row['total_order_value_month']), 2);
		}
	} else {
		return number_format(0,2);
	}
}
function count_total_order_curmonth($pdo)
{	
	$firstday = date('Y-m-01');
	$lastday = date('Y-m-t') ;
	$query = "SELECT * FROM billing_order WHERE order_status='1' and order_date between '$firstday' and '$lastday'";
	if($_SESSION['type']['user_role'] == 'Manager')
	{
		$query .= ' AND order_enter_by = "'.$_SESSION['type']['id'].'"';
	}
	$statement = $pdo->prepare($query);
	$statement->execute();
	$total = $statement->rowCount();
	return _e($total) ;
	
}
function count_total_orderwithouttax_value_curmonth($pdo)
{	
	$firstday = date('Y-m-01');
	$lastday = date('Y-m-t') ;
	$query = "SELECT * FROM billing_order WHERE order_status='1' and order_date between '$firstday' and '$lastday'";
	if($_SESSION['type']['user_role'] == 'Manager')
	{
		$query .= ' AND order_enter_by = "'.$_SESSION['type']['id'].'"';
	}
	$statement = $pdo->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$total = $statement->rowCount();
	if($total > 0) {
	$total_ordervaluewithout_tax = 0;
		foreach($result as $row)
		{
			
			$productId = _e($row['order_id']);
			$sub_row = $pdo->prepare("select product_price_beforetax from billing_order_detail where billing_order_id = '".$productId."'");
			$sub_row->execute();
			$result_sub_row = $sub_row->fetchAll();
			foreach($result_sub_row as $order_price) {
				$b = str_replace(',', '', _e($order_price['product_price_beforetax']));
				$total_ordervaluewithout_tax = (float)$total_ordervaluewithout_tax + (float)$b;
				if($total_ordervaluewithout_tax == '' || $total_ordervaluewithout_tax == '0'){
					$total_ordervaluewithout_tax = 0.00;
				}
			}
		}
		return number_format($total_ordervaluewithout_tax,2) ;
	} else {
		return number_format(0, 2);
	}
}
function count_total_ordertax_value_curmonth($pdo)
{	
	$firstday = date('Y-m-01');
	$lastday = date('Y-m-t') ;
	$query = "SELECT * FROM billing_order WHERE order_status='1' and order_date between '$firstday' and '$lastday'";
	if($_SESSION['type']['user_role'] == 'Manager')
	{
		$query .= ' AND order_enter_by = "'.$_SESSION['type']['id'].'"';
	}
	$statement = $pdo->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$total = $statement->rowCount();
	$total_tax_amt = 0;
	if($total > 0) {
		foreach($result as $row)
		{
			$productId = _e($row['order_id']);
			$sub_row = $pdo->prepare("select product_price_taxamount from billing_order_detail where billing_order_id = '".$productId."'");
			$sub_row->execute();
			$result_sub_row = $sub_row->fetchAll();
			foreach($result_sub_row as $order_tax) {
				$a = str_replace(',', '', _e($order_tax['product_price_taxamount']));
				$total_tax_amt =  (float)$total_tax_amt + (float)$a;
			}
		}
		return number_format($total_tax_amt,2) ;
	} else {
		return number_format(0, 2);
	}
}
function count_total_order_value($pdo)
{	
	$query = "SELECT sum(order_total) as total_order_value_month FROM billing_order WHERE order_status='1' ";
	if($_SESSION['type']['user_role'] == 'Manager')
	{
		$query .= ' AND order_enter_by = "'.$_SESSION['type']['id'].'"';
	}
	$statement = $pdo->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$total = $statement->rowCount();
	if($total > 0) {
		foreach($result as $row)
		{
			if($row['total_order_value_month'] == '' || $row['total_order_value_month'] == '0'){
			$row['total_order_value_month'] = 0 ;
			}
			return number_format(_e($row['total_order_value_month']), 2);
		}
	} else {
		return number_format(0,2);
	}
}
function count_total_order($pdo)
{	
	$query = "SELECT * FROM billing_order WHERE order_status='1'";
	if($_SESSION['type']['user_role'] == 'Manager')
	{
		$query .= ' AND order_enter_by = "'.$_SESSION['type']['id'].'"';
	}
	$statement = $pdo->prepare($query);
	$statement->execute();
	$total = $statement->rowCount();
	return _e($total) ;
	
}
function count_total_orderwithouttax_value($pdo)
{	
	$query = "SELECT * FROM billing_order WHERE order_status='1'";
	if($_SESSION['type']['user_role'] == 'Manager')
	{
		$query .= ' AND order_enter_by = "'.$_SESSION['type']['id'].'"';
	}
	$statement = $pdo->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$total = $statement->rowCount();
	if($total > 0) {
	$total_ordervaluewithout_tax = 0;
		foreach($result as $row)
		{
			
			$productId = _e($row['order_id']);
			$sub_row = $pdo->prepare("select product_price_beforetax from billing_order_detail where billing_order_id = '".$productId."'");
			$sub_row->execute();
			$result_sub_row = $sub_row->fetchAll();
			foreach($result_sub_row as $order_price) {
				$b = str_replace(',', '', _e($order_price['product_price_beforetax']));
				$total_ordervaluewithout_tax = (float)$total_ordervaluewithout_tax + (float)$b;
				if($total_ordervaluewithout_tax == '' || $total_ordervaluewithout_tax == '0'){
					$total_ordervaluewithout_tax = 0.00;
				}
			}
		}
		return number_format($total_ordervaluewithout_tax,2) ;
	} else {
		return number_format(0, 2);
	}
}
function count_total_ordertax_value($pdo)
{	
	$query = "SELECT * FROM billing_order WHERE order_status='1'";
	if($_SESSION['type']['user_role'] == 'Manager')
	{
		$query .= ' AND order_enter_by = "'.$_SESSION['type']['id'].'"';
	}
	$statement = $pdo->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$total = $statement->rowCount();
	$total_tax_amt = 0;
	if($total > 0) {
		foreach($result as $row)
		{
			$productId = _e($row['order_id']);
			$sub_row = $pdo->prepare("select product_price_taxamount from billing_order_detail where billing_order_id = '".$productId."'");
			$sub_row->execute();
			$result_sub_row = $sub_row->fetchAll();
			foreach($result_sub_row as $order_tax) {
				$a = str_replace(',', '', _e($order_tax['product_price_taxamount']));
				$total_tax_amt =  (float)$total_tax_amt + (float)$a;
			}
		}
		return number_format($total_tax_amt,2) ;
	} else {
		return number_format(0, 2);
	}
}
?>