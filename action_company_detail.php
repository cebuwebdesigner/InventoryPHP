<?php
ob_start();
session_start();
include("db/config.php");
// Checking Admin is logged in or not
if( ($_SESSION['type']['user_role'] != 'Admin') ){
	header('location: '.ADMIN_URL.'/dashboard.php');
	exit;
}
if($_POST['company_submit_pr']){
	if($_POST['company_submit_pr'] == 'Submit') {	
		$name = filter_var($_POST['companyname'], FILTER_SANITIZE_STRING) ;
		$email = filter_var($_POST['companyemail'], FILTER_SANITIZE_EMAIL) ;
		$phone = filter_var($_POST['companyphone'], FILTER_SANITIZE_NUMBER_INT) ;
		$tax = filter_var($_POST['companytax'], FILTER_SANITIZE_STRING) ;
		$id = filter_var($_POST['adminId'], FILTER_SANITIZE_NUMBER_INT) ;
		if( !empty($name) && !empty($email) && !empty($id) ){
			$update_company_name = $pdo->prepare("update billing_company set company_name = ? , company_email = ? , company_contact = ? , company_taxno = ? where company_id = 1");
			$update_company_name->execute(array($name,$email,$phone,$tax));
			$update_email = $pdo->prepare("update billing_admin set email = ? where id = ?");
			$update_email->execute(array($email,$id)) ;
			$form_message = "Company Details Updated Successfully.";
			$output = array( 
					'form_message' => $form_message,
					'name' 	=> $name,
					'email' => $email,
					'phone' => $phone,
					'tax'   => $tax
					);
			echo json_encode($output);
		} else {
			$form_message = "Name & Email is mandatory. Try Again";
			$output = array( 
					'form_message' => $form_message,
					'name' 	=> $name,
					'email' => $email,
					'phone' => $phone,
					'tax'   => $tax
					);
			echo json_encode($output);
		}
	}
}
?>