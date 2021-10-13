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
		//if( !empty($_POST['brand_id']) &&  !empty($_POST['category_id']) &&  !empty($_POST['service_name']) &&  !empty($_POST['service_sku']) &&  !empty($_POST['service_quantity']) &&  !empty($_POST['service_unit']) &&  !empty($_POST['service_sp']) &&  !empty($_POST['tax_rate']) ){
			$category_id = filter_var($_POST['category_id'], FILTER_SANITIZE_NUMBER_INT) ;
			$brand_id = filter_var($_POST['brand_id'], FILTER_SANITIZE_NUMBER_INT) ;
			$service_name = filter_var($_POST['service_name'], FILTER_SANITIZE_STRING) ;
			$service_sku = filter_var($_POST['service_sku'], FILTER_SANITIZE_STRING) ;
			$service_quantity = filter_var($_POST['service_quantity'], FILTER_SANITIZE_NUMBER_INT) ;
			$service_unit = filter_var($_POST['service_unit'], FILTER_SANITIZE_STRING) ;
			$service_sp = filter_var($_POST['service_sp'], FILTER_SANITIZE_STRING) ;
            $service_bp = filter_var($_POST['service_bp'], FILTER_SANITIZE_STRING) ;
			$tax_rate = filter_var($_POST['tax_rate'], FILTER_SANITIZE_STRING) ;
			$enter_by = filter_var($_SESSION['type']['id'], FILTER_SANITIZE_NUMBER_INT) ;
			$taxPrice = $service_sp - ( $service_sp * ( 100 / ( 100 + $tax_rate ) ) ) ;
			
           
            //$net_price = number_format(($service_sp - $taxPrice),2) ;
            //$base_price = filter_var($net_price, FILTER_SANITIZE_STRING) ;
			
            $service_sp = number_format($service_sp,2) ;
           $base_price = number_format($service_bp,2) ;//filter_var($service_bp, FILTER_SANITIZE_STRING) ;
		   $net_price = number_format(($service_sp - $base_price - $taxPrice),2) ;	
        
        
            $Statement = $pdo->prepare("select service_sku from billing_service where service_sku = ? ");
			$Statement->execute(array($service_sku)); 
			$total = $Statement->rowCount(); 
			if($total == 0) {  
				$ins_service = $pdo->prepare("INSERT INTO billing_service (category_id, brand_id, service_name,service_sku,service_quantity,service_unit,service_base_price,service_tax_rate,service_selling_price,service_enter_by,service_status) VALUES (?,?,?,?,?,?,?,?,?,?,?)");
				$ins_service->execute(array($category_id,$brand_id,$service_name,$service_sku,$service_quantity,$service_unit,$base_price,$tax_rate,$service_sp,$enter_by,filter_var("1", FILTER_SANITIZE_NUMBER_INT)));
				echo "New Product added successfully." ;
			} else {
				echo "Duplicate SKU code, Product SKU code must be different for each Product. Try Again."; 
			}
		//} else { echo "All fields are mandatory1" ; }
	}
	if($_POST['btn_action'] == 'fetch_single_service')
	{
		if(!empty($_POST['service_id'])){
			$service_id = filter_var($_POST['service_id'], FILTER_SANITIZE_NUMBER_INT) ;
			$Statement = $pdo->prepare("select * from billing_service where service_id = ? ");
			$Statement->execute(array($service_id));
			$result = $Statement->fetchAll(PDO::FETCH_ASSOC);
			foreach($result as $row) {
				$service_available = available_service_quantity($pdo,_e($row['service_id'])) ;
				$output['category_id'] = _e($row['category_id']);
				$output['brand_id'] = _e($row['brand_id']);
				$output["brand_select_box"] = fill_brand_list($pdo, _e($row["category_id"]));
				$output['service_name'] = _e($row['service_name']) ;
				$output['service_sku'] = _e($row['service_sku']) ;
				if($_SESSION['type']['user_role'] == "Admin") {
					$output['service_input_type'] = '<input type="text" name="addPro" id="addPro" class="form-control" value="0"/>';
				}
				$output['service_quantity'] = $service_available ;
				$output['service_unit'] = _e($row['service_unit']) ;
				$output['service_selling_price'] = _e($row['service_selling_price']) ;
                $output['service_base_price'] = _e($row['service_base_price']) ;
				$output['service_tax_rate'] = _e($row['service_tax_rate']) ;
			}
			echo json_encode($output);
			
		} else {
			echo "All fields are mandatory2" ;
		}
	}
	if($_POST['btn_action'] == 'Edit')
	{
		if( !empty($_POST['service_id']) && !empty($_POST['brand_id']) &&  !empty($_POST['category_id']) &&  !empty($_POST['service_name']) &&  !empty($_POST['service_sku']) &&  !empty($_POST['service_quantity']) &&  !empty($_POST['service_unit']) &&  !empty($_POST['service_sp'])  ){
			
			$service_id = filter_var($_POST['service_id'], FILTER_SANITIZE_NUMBER_INT) ;
			$addProductQuantity = filter_var($_POST['addPro'], FILTER_SANITIZE_NUMBER_INT) ;
			$category_id = filter_var($_POST['category_id'], FILTER_SANITIZE_NUMBER_INT) ;
			$brand_id = filter_var($_POST['brand_id'], FILTER_SANITIZE_NUMBER_INT) ;
			$service_name = filter_var($_POST['service_name'], FILTER_SANITIZE_STRING) ;
			$service_sku = filter_var($_POST['service_sku'], FILTER_SANITIZE_STRING) ;
			$service_quantity = filter_var($_POST['service_quantity'], FILTER_SANITIZE_NUMBER_INT) ;
			$service_unit = filter_var($_POST['service_unit'], FILTER_SANITIZE_STRING) ;
			$service_sp = filter_var($_POST['service_sp'], FILTER_SANITIZE_STRING) ;
			$service_bp = filter_var($_POST['service_bp'], FILTER_SANITIZE_STRING) ;
			$tax_rate = filter_var($_POST['tax_rate'], FILTER_SANITIZE_STRING) ;
			$edited_by = filter_var($_SESSION['type']['id'], FILTER_SANITIZE_NUMBER_INT) ;
			$taxPrice = $service_sp - ( $service_sp * ( 100 / ( 100 + $tax_rate ) ) ) ;
		
            //$net_price = number_format(($service_sp - $taxPrice),2) ;
			//$base_price = filter_var($net_price, FILTER_SANITIZE_STRING) ;
			
            
            $service_sp = number_format($service_sp,2) ;
            $base_price = number_format($service_bp,2) ;
            //filter_var($service_bp, FILTER_SANITIZE_STRING) ;
		    $net_price = number_format(($service_sp - $base_price - $taxPrice),2) ;	
        
            $old_quantity = fetch_service_details($pdo,$service_id);
            
           // $addProductQuantity
            

            
            date_default_timezone_set('Asia/Manila');
            $currenttime = date("d-m-Y H:i:s");
            
            
          // $ins_service2 = $pdo->prepare("INSERT INTO rec_inventory (AddedBy,ProdTitle,QtyAdded,DateUpdate,IpLog) VALUES ($edited_by,$service_name,$addProductQuantity,$currenttime,'-')");
          if($addProductQuantity!=0){
            
            $ins_service2 = $pdo->prepare("INSERT INTO rec_inventory (AddedBy,ProdTitle,QtyAdded,DateUpdate,IpLog) VALUES (?,?,?,?,?)");
           $ins_service2->execute(array($edited_by,$service_name,$addProductQuantity,$currenttime,'-'));
            
              
          }
            
            
            
            
			$service_new_quantity = $addProductQuantity + $old_quantity['service_quantity'] ;
			$Statement = $pdo->prepare("select service_sku from billing_service where service_sku = ? and service_id = ?");
			$Statement->execute(array($service_sku,$service_id)); 
			$total = $Statement->rowCount(); 
			if($total > 0) {
				$update_service = $pdo->prepare("update billing_service set category_id = ? , brand_id = ? , service_name = ? , service_sku = ? , service_quantity = ? , service_unit = ? , service_base_price = ? , service_tax_rate = ? , service_selling_price = ? , service_edited_by = ? , service_status = ? where service_id = ?");
				$update_service->execute(array($category_id,$brand_id,$service_name,$service_sku,$service_new_quantity,$service_unit,$base_price,$tax_rate,$service_sp,$edited_by,filter_var("1", FILTER_SANITIZE_NUMBER_INT),$service_id));
				echo "Product Edited successfully." ;
			} else {
				$check_sku = $pdo->prepare("select service_sku from billing_service where service_sku = ? ");
				$check_sku->execute(array($service_sku)); 
				$total_check_sku = $check_sku->rowCount(); 
				if($total_check_sku == 0) {
					$update_service = $pdo->prepare("update billing_service set category_id = ? , brand_id = ? , service_name = ? , service_sku = ? , service_quantity = ? , service_unit = ? , service_base_price = ? , service_tax_rate = ? , service_selling_price = ? , service_edited_by = ? , service_status = ? where service_id = ?");
					$update_service->execute(array($category_id,$brand_id,$service_name,$service_sku,$service_quantity,$service_unit,$base_price,$tax_rate,$service_sp,$edited_by,filter_var("1", FILTER_SANITIZE_NUMBER_INT),$service_id));
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
		echo checkSKU($pdo, filter_var($_POST['service_sku'], FILTER_SANITIZE_STRING));
	}
}
?>