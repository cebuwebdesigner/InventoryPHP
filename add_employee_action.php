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
{ //$debug1b='btn_action';////////////
	if($_POST['btn_action'] == 'Add')
	{   $debug1b='btn_action Add';///////////
		if( (!empty($_POST['employee_email']) || !empty($_POST['employee_mobile'])) && !empty($_POST['employee_name']) ) {
			$employee_email = filter_var($_POST['employee_email'], FILTER_SANITIZE_EMAIL) ;
			$employee_mobile = filter_var($_POST['employee_mobile'], FILTER_SANITIZE_NUMBER_INT) ;
			$employee_name = filter_var($_POST['employee_name'], FILTER_SANITIZE_STRING) ;
			$employee_tax = filter_var($_POST['employee_tax'], FILTER_SANITIZE_STRING) ;
            $employee_sss = filter_var($_POST['employee_sss'], FILTER_SANITIZE_STRING) ;
            $employee_pagibig = filter_var($_POST['employee_pagibig'], FILTER_SANITIZE_STRING) ;
            $employee_idnum = filter_var($_POST['employee_idnum'], FILTER_SANITIZE_STRING) ;
            $employee_salary = filter_var($_POST['employee_salary'], FILTER_SANITIZE_STRING) ;
			$employee_date = filter_var(date("d-m-Y"), FILTER_SANITIZE_STRING) ;
			$employee_tmp_password = filter_var("123456", FILTER_SANITIZE_NUMBER_INT) ; 
			$enter_by = filter_var($_SESSION['type']['id'], FILTER_SANITIZE_NUMBER_INT) ;
			
           // $debug1b='field req';/////////////
            
            if($employee_email == "") {
				$employee_username = $employee_mobile ;
			} else {
				$employee_username = $employee_email ;
			}
            
            $employee_username = $employee_name;
            
			if(!empty($employee_tax)) {
				$Statement = $pdo->prepare("select * from billing_employee where (employee_username = ? or employee_phone = ? or employee_email = ? or employee_tax_no = ? or employee_sss = ? or employee_pagibig = ? or employee_idnum = ? or employee_salary = ?) ");
				$Statement->execute(array($employee_username,$employee_mobile,$employee_email,$employee_tax,$employee_sss,$employee_pagibig,$employee_idnum,$employee_salary)); 
			} else {
				$Statement = $pdo->prepare("select * from billing_employee where (employee_username = ? or employee_phone = ? or employee_email = ? ) ");
				$Statement->execute(array($employee_username,$employee_mobile,$employee_email)); 
			}
			$total = $Statement->rowCount();
			if($total > 0 ) {
				echo "Error : Duplicate Username, Mobile, Email or Tax No. Try Again.";
			} else {
                
                 //$debug1b='insert';/////////////
				$ins_employee = $pdo->prepare("insert into billing_employee (employee_username, employee_email, employee_phone, employee_password, employee_name, employee_tax_no, employee_sss, employee_pagibig, employee_idnum, employee_salary, employee_status, employee_date, enter_by) values (?,?,?,?,?,?,?,?,?)");
				$ins_employee->execute(array($employee_username,$employee_email,$employee_mobile,password_hash($employee_tmp_password, PASSWORD_DEFAULT),$employee_name,$employee_tax,$employee_sss,$employee_pagibig,$employee_idnum,$employee_salary,filter_var("1", FILTER_SANITIZE_NUMBER_INT),$employee_date,$enter_by));
				echo "Customer Added Successfully.";
			}
		} else {
			echo "Email or Mobile, at least 1 field is mandatory." ;
		}
	}
	if($_POST['btn_action'] == 'Edit')
	{
		if( (!empty($_POST['employee_email']) || !empty($_POST['employee_mobile'])) && !empty($_POST['employee_name']) && !empty($_POST['employee_id']) ) {
			$employee_id = filter_var($_POST['employee_id'], FILTER_SANITIZE_NUMBER_INT) ;
			$employee_email = filter_var($_POST['employee_email'], FILTER_SANITIZE_EMAIL) ;
			$employee_mobile = filter_var($_POST['employee_mobile'], FILTER_SANITIZE_NUMBER_INT) ;
			$employee_name = filter_var($_POST['employee_name'], FILTER_SANITIZE_STRING) ;
			$employee_tax = filter_var($_POST['employee_tax'], FILTER_SANITIZE_STRING) ;
            $employee_sss = filter_var($_POST['employee_sss'], FILTER_SANITIZE_STRING) ;
            $employee_pagibig = filter_var($_POST['employee_pagibig'], FILTER_SANITIZE_STRING) ;
			$edited_by = filter_var($_SESSION['type']['id'], FILTER_SANITIZE_NUMBER_INT) ;
			if($employee_email == "") {
				$employee_username = $employee_mobile ;
			} else {
				$employee_username = $employee_email ;
			}
			$employeeData = $pdo->prepare("select * from billing_employee where employee_id = ?");
			$employeeData->execute(array($employee_id));
			$result_data = $employeeData->fetchAll(PDO::FETCH_ASSOC);
			foreach ($result_data as $row_data) {
				$cusEmail = _e($row_data['employee_email']) ;
				$cusMobile = _e($row_data['employee_phone']) ;
				$cusTax = _e($row_data['employee_tax_no']) ;
                $cusSSS = _e($row_data['employee_sss']) ;
                $cusPAGIBIG = _e($row_data['employee_pagibig']) ;
			} 
			if( $cusTax != $employee_tax) {
				$Statement = $pdo->prepare("select * from billing_employee where employee_tax_no = ?");
				$Statement->execute(array($employee_tax)); 
				$total = $Statement->rowCount();
			} 
            if( $cusSSS != $employee_sss) {
				$Statement = $pdo->prepare("select * from billing_employee where employee_sss = ?");
				$Statement->execute(array($employee_sss)); 
				$total = $Statement->rowCount();
			} 
               if( $cusPAGIBIG != $employee_pagibig) {
				$Statement = $pdo->prepare("select * from billing_employee where employee_pagibig = ?");
				$Statement->execute(array($employee_pagibig)); 
				$total = $Statement->rowCount();
			} 
			if( $cusMobile != $employee_mobile) {
				$Statement = $pdo->prepare("select * from billing_employee where employee_phone = ?");
				$Statement->execute(array($employee_mobile)); 
				$total = $Statement->rowCount();
			}
			if( $cusEmail != $employee_email) {
				$Statement = $pdo->prepare("select * from billing_employee where employee_email = ?");
				$Statement->execute(array($employee_email)); 
				$total = $Statement->rowCount();
			}
			if( ($cusEmail != $employee_email) && ($cusMobile != $employee_mobile) ) {
				$Statement = $pdo->prepare("select * from billing_employee where employee_email = ? or employee_phone = ?");
				$Statement->execute(array($employee_email,$employee_mobile)); 
				$total = $Statement->rowCount();
			}
			if( ($cusEmail != $employee_email) && ($cusTax != $employee_tax) ) {
				$Statement = $pdo->prepare("select * from billing_employee where employee_email = ? or employee_tax_no = ?");
				$Statement->execute(array($employee_email,$employee_tax)); 
				$total = $Statement->rowCount();
			}
			if( ($cusMobile != $employee_mobile) && ($cusTax != $employee_tax)) {
				$Statement = $pdo->prepare("select * from billing_employee where employee_phone = ? or employee_tax_no = ?");
				$Statement->execute(array($employee_mobile,$employee_tax)); 
				$total = $Statement->rowCount();
			}
			if( ($cusEmail != $employee_email) && ($cusMobile != $employee_mobile) && ($cusTax != $employee_tax) ) {
				$Statement = $pdo->prepare("select * from billing_employee where employee_email = ? or employee_phone = ? or employee_tax_no = ? or employee_sss = ? or employee_pagibig = ? or employee_idnum = ? or employee_salary = ?");
				$Statement->execute(array($employee_email,$employee_mobile,$employee_tax,$employee_sss,$employee_pagibig,$employee_idnum,$employee_salary));
				$total = $Statement->rowCount(); 
			}
			if( ($cusEmail == $employee_email) && ($cusMobile == $employee_mobile) && ($cusTax == $employee_tax) ) {
				//employee name update
				$total = 0;
			}
			if($total > 0 ) {
					echo "Error : Duplicate Username, Mobile, Email or Tax No. Try Again.";
			} else {
				$Statement = $pdo->prepare("update billing_employee set employee_username=? , employee_email=? , employee_phone=? , employee_name=? , employee_tax_no=? ,employee_sss=? ,employee_pagibig=? ,employee_idnum=? ,employee_salary=? , edited_by=? where employee_id = ?");
				$Statement->execute(array($employee_username,$employee_email,$employee_mobile,$employee_name,$employee_tax,$employee_sss,$employee_pagibig,$employee_idnum,$employee_salary,$edited_by,$employee_id));
				echo "Customer Edited Successfully.";
			}
		} else {
			echo "All fields are mandatory" ;
		}
	}
	if($_POST['btn_action'] == 'fetch_employee')
	{
		if(!empty($_POST['employee_id'])){
			$employee_id = filter_var($_POST['employee_id'], FILTER_SANITIZE_NUMBER_INT) ;
			$Statement = $pdo->prepare("select * from billing_employee where employee_id = ? ");
			$Statement->execute(array($employee_id));
			$result = $Statement->fetchAll(PDO::FETCH_ASSOC);
			foreach($result as $row) {
				$output['employee_email'] = _e($row['employee_email']) ;
				$output['employee_mobile'] = _e($row['employee_phone']) ;
				$output['employee_tax'] = _e($row['employee_tax_no']) ;
				$output['employee_name'] = _e($row['employee_name']) ;
                $output['employee_sss'] = _e($row['employee_sss']) ;
                $output['employee_pagibig'] = _e($row['employee_pagibig']) ;
                $output['employee_idnum'] = _e($row['employee_idnum']) ;
                $output['employee_salary'] = _e($row['employee_salary']) ;
			}
			echo json_encode($output);
		} else {
			echo "All fields are mandatory" ;
		}
	}
}

//echo $debug1b;