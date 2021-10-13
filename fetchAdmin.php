<?php
ob_start();
session_start();
include("db/config.php");
include("db/function_xss.php");
// Checking Admin is logged in or not
if( ($_SESSION['type']['user_role'] != 'Admin') ){
	header('location: '.ADMIN_URL.'/dashboard.php');
	exit;
}
$Statement = $pdo->prepare("SELECT * FROM billing_admin WHERE user_role = ?");
$Statement->execute(array(_e("Admin"))); 
$total = $Statement->rowCount();    
$result = $Statement->fetchAll(PDO::FETCH_ASSOC); 
$output = array('data' => array());
if($total > 0) {
	$statuss = "";
	foreach($result as $row) {
		$adminId = _e($row['id']);
		$email = _e($row['email']);
		$role = _e($row['user_role']);
		$statuss = _e($row['active_status']);
		if($statuss == 1) {
			// Deactivate User
			$statuss = "<b>Active</b>";
			$myLink = '<button type="button" name="changeAdminStatus" id="'.$adminId.'" class="btn btn-danger btn-xs changeAdminStatus" data-status="0">Deactivate</button>';
		} else {
			// Activate User
			$statuss = "Not Active";
			$myLink = '<button type="button" name="changeAdminStatus" id="'.$adminId.'" class="btn btn-success btn-xs changeAdminStatus" data-status="1">Activate</button>';
		}
		$output['data'][] = array( 		
		$adminId, 
		$email,
		$role,
		$statuss,
		$myLink		
		); 	
	}
}
echo json_encode($output);
?>