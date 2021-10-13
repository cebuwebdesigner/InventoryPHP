<?php
ob_start();
session_start();
include("db/config.php");
include("db/function_xss.php");
include("db/functions.php");
// Checking Admin  is logged in or not
if( ($_SESSION['type']['user_role'] != 'Admin')  ){
	header('location: '.ADMIN_URL.'/index.php');
	exit;
}
if(isset($_POST['btn_action']))
{
	if($_POST['btn_action'] == 'Add')
	{
		//if( !empty($_POST['brand_id']) &&  !empty($_POST['category_id']) &&  !empty($_POST['product_name']) &&  !empty($_POST['product_sku']) &&  !empty($_POST['product_quantity']) &&  !empty($_POST['product_unit']) &&  !empty($_POST['product_sp']) &&  !empty($_POST['tax_rate']) ){
			$category_id = filter_var($_POST['category_id'], FILTER_SANITIZE_NUMBER_INT) ;
			$brand_id = filter_var($_POST['brand_id'], FILTER_SANITIZE_NUMBER_INT) ;
			$product_name = filter_var($_POST['product_name'], FILTER_SANITIZE_STRING) ;
			$product_sku = filter_var($_POST['product_sku'], FILTER_SANITIZE_STRING) ;
			$product_quantity = filter_var($_POST['product_quantity'], FILTER_SANITIZE_NUMBER_INT) ;
			$product_unit = filter_var($_POST['product_unit'], FILTER_SANITIZE_STRING) ;
			$product_sp = filter_var($_POST['product_sp'], FILTER_SANITIZE_STRING) ;
            $product_bp = filter_var($_POST['product_bp'], FILTER_SANITIZE_STRING) ;
			
			$enter_by = filter_var($_SESSION['type']['id'], FILTER_SANITIZE_NUMBER_INT) ;
        
            
            $markup_rate = filter_var($_POST['markup_rate'], FILTER_SANITIZE_STRING) ;
			$markupPrice = $product_bp - ( $product_bp * ( 100 / ( 100 + $markup_rate ) ) ) ;
			
        
            $tax_rate = filter_var($_POST['tax_rate'], FILTER_SANITIZE_STRING) ;
			$taxPrice = ($markupPrice+$product_bp) - ( ($markupPrice+$product_bp) * ( 100 / ( 100 + $tax_rate ) ) ) ;
			
             
            //$net_price = number_format(($product_sp - $taxPrice),2) ;
            //$base_price = filter_var($net_price, FILTER_SANITIZE_STRING) ;
			
            $product_sp = number_format(($base_price + $markupPrice + $taxPrice),2) ;//number_format($product_sp,2) ;
           $base_price = number_format($product_bp,2) ;//filter_var($product_bp, FILTER_SANITIZE_STRING) ;
		   $net_price = number_format($markupPrice,2) ; //number_format(($product_sp - $base_price - $taxPrice),2) ;	
        
        
            $Statement = $pdo->prepare("select product_sku from billing_product where product_sku = ? ");
			$Statement->execute(array($product_sku)); 
			$total = $Statement->rowCount(); 
			if($total == 0) {  
				$ins_product = $pdo->prepare("INSERT INTO billing_product (category_id, brand_id, product_name,product_sku,product_quantity,product_unit,product_base_price,product_markup_rate,product_tax_rate,product_selling_price,product_enter_by,product_status) VALUES (?,?,?,?,?,?,?,?,?,?,?)");
				$ins_product->execute(array($category_id,$brand_id,$product_name,$product_sku,$product_quantity,$product_unit,$base_price,$markup_rate,$tax_rate,$product_sp,$enter_by,filter_var("1", FILTER_SANITIZE_NUMBER_INT)));
				echo "New Product added successfully." ;
			} else {
				echo "Duplicate SKU code, Product SKU code must be different for each Product. Try Again."; 
			}
		//} else { echo "All fields are mandatory1" ; }
	}
	if($_POST['btn_action'] == 'fetch_single_product')
	{
		if(!empty($_POST['product_id'])){
			$product_id = filter_var($_POST['product_id'], FILTER_SANITIZE_NUMBER_INT) ;
			$Statement = $pdo->prepare("select * from billing_product where product_id = ? ");
			$Statement->execute(array($product_id));
			$result = $Statement->fetchAll(PDO::FETCH_ASSOC);
			foreach($result as $row) {
				$product_available = available_product_quantity($pdo,_e($row['product_id'])) ;
				$output['category_id'] = _e($row['category_id']);
				$output['brand_id'] = _e($row['brand_id']);
				$output["brand_select_box"] = fill_brand_list($pdo, _e($row["category_id"]));
				$output['product_name'] = _e($row['product_name']) ;
				$output['product_sku'] = _e($row['product_sku']) ;
				if($_SESSION['type']['user_role'] == "Admin") {
					$output['product_input_type'] = '<input type="text" name="addPro" id="addPro" class="form-control" value="0"/>';
				}
				$output['product_quantity'] = $product_available ;
				$output['product_unit'] = _e($row['product_unit']) ;
				$output['product_selling_price'] = _e($row['product_selling_price']) ;
                $output['product_base_price'] = _e($row['product_base_price']) ;
				$output['product_tax_rate'] = _e($row['product_tax_rate']) ;
			}
			echo json_encode($output);
			
		} else {
			echo "All fields are mandatory2" ;
		}
	}
	if($_POST['btn_action'] == 'Edit')
	{
		if( !empty($_POST['product_id']) && !empty($_POST['brand_id']) &&  !empty($_POST['category_id']) &&  !empty($_POST['product_name']) &&  !empty($_POST['product_sku']) &&  !empty($_POST['product_quantity']) &&  !empty($_POST['product_unit']) &&  !empty($_POST['product_sp'])  ){
			
			$product_id = filter_var($_POST['product_id'], FILTER_SANITIZE_NUMBER_INT) ;
			$addProductQuantity = filter_var($_POST['addPro'], FILTER_SANITIZE_NUMBER_INT) ;
			$category_id = filter_var($_POST['category_id'], FILTER_SANITIZE_NUMBER_INT) ;
			$brand_id = filter_var($_POST['brand_id'], FILTER_SANITIZE_NUMBER_INT) ;
			$product_name = filter_var($_POST['product_name'], FILTER_SANITIZE_STRING) ;
			$product_sku = filter_var($_POST['product_sku'], FILTER_SANITIZE_STRING) ;
			$product_quantity = filter_var($_POST['product_quantity'], FILTER_SANITIZE_NUMBER_INT) ;
			$product_unit = filter_var($_POST['product_unit'], FILTER_SANITIZE_STRING) ;
			$product_sp = filter_var($_POST['product_sp'], FILTER_SANITIZE_STRING) ;
			$product_bp = filter_var($_POST['product_bp'], FILTER_SANITIZE_STRING) ;
			$tax_rate = filter_var($_POST['tax_rate'], FILTER_SANITIZE_STRING) ;
			$edited_by = filter_var($_SESSION['type']['id'], FILTER_SANITIZE_NUMBER_INT) ;
			$taxPrice = $product_sp - ( $product_sp * ( 100 / ( 100 + $tax_rate ) ) ) ;
		
            //$net_price = number_format(($product_sp - $taxPrice),2) ;
			//$base_price = filter_var($net_price, FILTER_SANITIZE_STRING) ;
			 $markup_rate = filter_var($_POST['markup_rate'], FILTER_SANITIZE_STRING) ;
			$markupPrice = $product_bp - ( $product_bp * ( 100 / ( 100 + $markup_rate ) ) ) ;
			
        
            $tax_rate = filter_var($_POST['tax_rate'], FILTER_SANITIZE_STRING) ;
			$taxPrice = ($markupPrice+$product_bp) - ( ($markupPrice+$product_bp) * ( 100 / ( 100 + $tax_rate ) ) ) ;
            
            
            $product_sp = number_format(($base_price + $markupPrice + $taxPrice),2) ;//number_format($product_sp,2) ;
           $base_price = number_format($product_bp,2) ;//filter_var($product_bp, FILTER_SANITIZE_STRING) ;
		   $net_price = number_format($markupPrice,2) ;
            
            
            //$product_sp = number_format($product_sp,2) ;
           // $base_price = number_format($product_bp,2) ;
            //filter_var($product_bp, FILTER_SANITIZE_STRING) ;
		   // $net_price = number_format(($product_sp - $base_price - $taxPrice),2) ;	
        
            $old_quantity = fetch_product_details($pdo,$product_id);
            
           // $addProductQuantity
            

            
            date_default_timezone_set('Asia/Manila');
            $currenttime = date("d-m-Y H:i:s");
            
            
          // $ins_product2 = $pdo->prepare("INSERT INTO rec_inventory (AddedBy,ProdTitle,QtyAdded,DateUpdate,IpLog) VALUES ($edited_by,$product_name,$addProductQuantity,$currenttime,'-')");
          if($addProductQuantity!=0){
            
            $ins_product2 = $pdo->prepare("INSERT INTO rec_inventory (AddedBy,ProdTitle,QtyAdded,DateUpdate,IpLog) VALUES (?,?,?,?,?)");
           $ins_product2->execute(array($edited_by,$product_name,$addProductQuantity,$currenttime,'-'));
            
              
          }
            
            
            
            
			$product_new_quantity = $addProductQuantity + $old_quantity['product_quantity'] ;
			$Statement = $pdo->prepare("select product_sku from billing_product where product_sku = ? and product_id = ?");
			$Statement->execute(array($product_sku,$product_id)); 
			$total = $Statement->rowCount(); 
			if($total > 0) {
				$update_product = $pdo->prepare("update billing_product set category_id = ? , brand_id = ? , product_name = ? , product_sku = ? , product_quantity = ? , product_unit = ? , product_base_price = ? , product_markup_rate = ? , product_tax_rate = ? , product_selling_price = ? , product_edited_by = ? , product_status = ? where product_id = ?");
				$update_product->execute(array($category_id,$brand_id,$product_name,$product_sku,$product_new_quantity,$product_unit,$base_price,$markup_rate,$tax_rate,$product_sp,$edited_by,filter_var("1", FILTER_SANITIZE_NUMBER_INT),$product_id));
				echo "Product Edited successfully." ;
			} else {
				$check_sku = $pdo->prepare("select product_sku from billing_product where product_sku = ? ");
				$check_sku->execute(array($product_sku)); 
				$total_check_sku = $check_sku->rowCount(); 
				if($total_check_sku == 0) {
					$update_product = $pdo->prepare("update billing_product set category_id = ? , brand_id = ? , product_name = ? , product_sku = ? , product_quantity = ? , product_unit = ? , product_base_price = ? , product_markup_rate = ? , product_tax_rate = ? , product_selling_price = ? , product_edited_by = ? , product_status = ? where product_id = ?");
					$update_product->execute(array($category_id,$brand_id,$product_name,$product_sku,$product_quantity,$product_unit,$base_price,$markup_rate,$tax_rate,$product_sp,$edited_by,filter_var("1", FILTER_SANITIZE_NUMBER_INT),$product_id));
					echo "Product Edited successfully." ;
				} else {
					echo "Duplicate SKU code, Product SKU code must be different for each Product. Try Again."; 
				}
			}
		
		} else {
			echo "All fields are mandatory3" ;
		}
	
	}
	if($_POST['btn_action'] == 'load_brand')
	{
		echo fill_brand_list($pdo, filter_var($_POST['category_id'], FILTER_SANITIZE_NUMBER_INT));
	}
	if($_POST['btn_action'] == 'check_sku')
	{
		echo checkSKU($pdo, filter_var($_POST['product_sku'], FILTER_SANITIZE_STRING));
	}
}
?>