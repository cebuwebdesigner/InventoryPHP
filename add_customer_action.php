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
if(isset($_POST['btn_action']))
{
	if($_POST['btn_action'] == 'Add')
	{
		if( (!empty($_POST['customer_email']) || !empty($_POST['customer_mobile'])) && !empty($_POST['customer_name']) ) {
			$customer_email = filter_var($_POST['customer_email'], FILTER_SANITIZE_EMAIL) ;
			$customer_mobile = filter_var($_POST['customer_mobile'], FILTER_SANITIZE_NUMBER_INT) ;
			$customer_name = filter_var($_POST['customer_name'], FILTER_SANITIZE_STRING) ;
			$customer_tax = filter_var($_POST['customer_tax'], FILTER_SANITIZE_STRING) ;
			$customer_date = filter_var(date("d-m-Y"), FILTER_SANITIZE_STRING) ;
			$customer_tmp_password = filter_var("123456", FILTER_SANITIZE_NUMBER_INT) ; 
			$enter_by = filter_var($_SESSION['type']['id'], FILTER_SANITIZE_NUMBER_INT) ;
			
            
            if($customer_email == "") {
				$customer_username = $customer_mobile ;
			} else {
				$customer_username = $customer_email ;
			}
            
            $customer_username = $customer_name;
            
			if(!empty($customer_tax)) {
				$Statement = $pdo->prepare("select * from billing_user where (customer_username = ? or customer_phone = ? or customer_email = ? or customer_tax_no = ?) ");
				$Statement->execute(array($customer_username,$customer_mobile,$customer_email,$customer_tax)); 
			} else {
				$Statement = $pdo->prepare("select * from billing_user where (customer_username = ? or customer_phone = ? or customer_email = ? ) ");
				$Statement->execute(array($customer_username,$customer_mobile,$customer_email)); 
			}
			$total = $Statement->rowCount();
			if($total > 0 ) {
				echo "Error : Duplicate Username, Mobile, Email or Tax No. Try Again.";
			} else {
				$ins_customer = $pdo->prepare("insert into billing_user (customer_username, customer_email, customer_phone, customer_password, customer_name, customer_tax_no, customer_status, customer_date, enter_by) values (?,?,?,?,?,?,?,?,?)");
				$ins_customer->execute(array($customer_username,$customer_email,$customer_mobile,password_hash($customer_tmp_password, PASSWORD_DEFAULT),$customer_name,$customer_tax,filter_var("1", FILTER_SANITIZE_NUMBER_INT),$customer_date,$enter_by));
				echo "Customer Added Successfully.";
			}
		} else {
			echo "Email or Mobile, at least 1 field is mandatory." ;
		}
	}
	if($_POST['btn_action'] == 'Edit')
	{
		if( (!empty($_POST['customer_email']) || !empty($_POST['customer_mobile'])) && !empty($_POST['customer_name']) && !empty($_POST['customer_id']) ) {
			$customer_id = filter_var($_POST['customer_id'], FILTER_SANITIZE_NUMBER_INT) ;
			$customer_email = filter_var($_POST['customer_email'], FILTER_SANITIZE_EMAIL) ;
			$customer_mobile = filter_var($_POST['customer_mobile'], FILTER_SANITIZE_NUMBER_INT) ;
			$customer_name = filter_var($_POST['customer_name'], FILTER_SANITIZE_STRING) ;
			$customer_tax = filter_var($_POST['customer_tax'], FILTER_SANITIZE_STRING) ;
			$edited_by = filter_var($_SESSION['type']['id'], FILTER_SANITIZE_NUMBER_INT) ;
			if($customer_email == "") {
				$customer_username = $customer_mobile ;
			} else {
				$customer_username = $customer_email ;
			}
			$customerData = $pdo->prepare("select * from billing_user where customer_id = ?");
			$customerData->execute(array($customer_id));
			$result_data = $customerData->fetchAll(PDO::FETCH_ASSOC);
			foreach ($result_data as $row_data) {
				$cusEmail = _e($row_data['customer_email']) ;
				$cusMobile = _e($row_data['customer_phone']) ;
				$cusTax = _e($row_data['customer_tax_no']) ;
			} 
			if( $cusTax != $customer_tax) {
				$Statement = $pdo->prepare("select * from billing_user where customer_tax_no = ?");
				$Statement->execute(array($customer_tax)); 
				$total = $Statement->rowCount();
			} 
			if( $cusMobile != $customer_mobile) {
				$Statement = $pdo->prepare("select * from billing_user where customer_phone = ?");
				$Statement->execute(array($customer_mobile)); 
				$total = $Statement->rowCount();
			}
			if( $cusEmail != $customer_email) {
				$Statement = $pdo->prepare("select * from billing_user where customer_email = ?");
				$Statement->execute(array($customer_email)); 
				$total = $Statement->rowCount();
			}
			if( ($cusEmail != $customer_email) && ($cusMobile != $customer_mobile) ) {
				$Statement = $pdo->prepare("select * from billing_user where customer_email = ? or customer_phone = ?");
				$Statement->execute(array($customer_email,$customer_mobile)); 
				$total = $Statement->rowCount();
			}
			if( ($cusEmail != $customer_email) && ($cusTax != $customer_tax) ) {
				$Statement = $pdo->prepare("select * from billing_user where customer_email = ? or customer_tax_no = ?");
				$Statement->execute(array($customer_email,$customer_tax)); 
				$total = $Statement->rowCount();
			}
			if( ($cusMobile != $customer_mobile) && ($cusTax != $customer_tax)) {
				$Statement = $pdo->prepare("select * from billing_user where customer_phone = ? or customer_tax_no = ?");
				$Statement->execute(array($customer_mobile,$customer_tax)); 
				$total = $Statement->rowCount();
			}
			if( ($cusEmail != $customer_email) && ($cusMobile != $customer_mobile) && ($cusTax != $customer_tax) ) {
				$Statement = $pdo->prepare("select * from billing_user where customer_email = ? or customer_phone = ? or customer_tax_no = ?");
				$Statement->execute(array($customer_email,$customer_mobile,$customer_tax));
				$total = $Statement->rowCount(); 
			}
			if( ($cusEmail == $customer_email) && ($cusMobile == $customer_mobile) && ($cusTax == $customer_tax) ) {
				//customer name update
				$total = 0;
			}
			if($total > 0 ) {
					echo "Error : Duplicate Username, Mobile, Email or Tax No. Try Again.";
			} else {
				$Statement = $pdo->prepare("update billing_user set customer_username=? , customer_email=? , customer_phone=? , customer_name=? , customer_tax_no=? , edited_by=? where customer_id = ?");
				$Statement->execute(array($customer_username,$customer_email,$customer_mobile,$customer_name,$customer_tax,$edited_by,$customer_id));
				echo "Customer Edited Successfully.";
			}
		} else {
			echo "All fields are mandatory" ;
		}
	}
	if($_POST['btn_action'] == 'fetch_customer')
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
}