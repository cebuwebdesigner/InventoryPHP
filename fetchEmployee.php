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
$Statement = $pdo->prepare("SELECT * FROM billing_employee LEFT JOIN billing_admin ON (billing_admin.id = billing_employee.enter_by) ORDER BY billing_employee.employee_id DESC ");
$Statement->execute(); 
$total = $Statement->rowCount();    
$result = $Statement->fetchAll(PDO::FETCH_ASSOC); 
$output = array('data' => array());
if($total > 0) {
	$statuss = "";
	foreach($result as $row) {
		$employeeId = _e($row['employee_id']) ;
		$employeeName = _e($row['employee_name']) ;
		$employeeUserName = _e($row['employee_username']) ;
		$employeeEmail = _e($row['employee_email']) ;
		$employeePhone = _e($row['employee_phone']) ;
		$employeeTaxNo = _e($row['employee_tax_no']) ;
        $employeeSss = _e($row['employee_sss']) ;
        $employeePagibig = _e($row['employee_pagibig']) ;
        $employeeIdnum = _e($row['employee_idnum']) ;
        $employeeSalary = _e($row['employee_salary']) ;
		$customeDate = _e($row['employee_date']) ;
		$statuss = _e($row['employee_status']) ;
		$manEmail = _e($row['email']) ;
		$manRole = _e($row['user_role']) ;
		$enter_by =  _e($row['enter_by']);
		$enter_by_statement = $pdo->prepare("select email, user_role from billing_admin where id= ?");
		$enter_by_statement->execute(array($enter_by));
		$result_enter_by = $enter_by_statement->fetchAll(PDO::FETCH_ASSOC);
		$total = $enter_by_statement->rowCount();
		if($total > 0) {
			foreach ($result_enter_by as $edited) {
				$editedBy = _e($edited['email']);
				$editedRole = _e($edited['user_role']);
			}
		} else {
			$editedBy = "";
			$editedRole = "";
		}
		$createOrderLink = '<button type="button" name="createOrderz" id="'.$employeeId.'" class="btn btn-success btn-xs createOrder" disabled>Attendance</button>'; 
		if( ($_SESSION['type']['user_role'] != 'Admin') && ($_SESSION['type']['id'] != $enter_by ) ) {
			$updateEmployee = '' ;
			$myLink = '' ;
			if($statuss == 1) {
				$statuss = "<b>Active</b>";
			} else {
				$statuss = "Not Active";
			}
			
		} else {
			$updateEmployee = '<button type="button" name="updateEmployee" id="'.$employeeId.'" class="btn btn-light btn-xs updateEmployee"><i class="fa fa-pencil-alt"></i></button>';
			if($statuss == 1) {
				// Deactivate Employee
				$statuss = "<b>Active</b>";
				$myLink = '<button type="button" name="changeEmployeeStatus" id="'.$employeeId.'" class="btn btn-danger btn-xs changeEmployeeStatus" data-status="0">Deactivate</button>';
			} else {
				// Activate Employee
				$createOrderLink = '<button type="button" name="createOrderz" id="'.$employeeId.'" class="btn btn-success btn-xs createOrder" disabled> Attendance</button>';
				$statuss = "Not Active";
				$myLink = '<button type="button" name="changeEmployeeStatus" id="'.$employeeId.'" class="btn btn-success btn-xs changeEmployeeStatus" data-status="1">Activate</button>';
			}
		}
		$output['data'][] = array( 		
		$employeeId,
		$employeeName,
		$employeeUserName,
		$employeeEmail,
		$employeePhone,
		$customeDate,
		$employeeTaxNo,
        $employeeSss,
        $employeePagibig,
        $employeeIdnum,
        $employeeSalary,
		$statuss,
		$manEmail,
		$manRole,
		$editedBy,
		$editedRole,
		$createOrderLink,
		$updateEmployee,
		$myLink		
		); 	
	}
}
echo json_encode($output);
?>