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
	if($_POST['btn_action_pro'] == 'fetch_username')
	{
		if(!empty($_POST['username'])){
			$username = filter_var($_POST['username'], FILTER_SANITIZE_NUMBER_INT) ;
			$Statement = $pdo->prepare("select * from billing_user where customer_id = ? ");
			$Statement->execute(array($username));
			$result = $Statement->fetchAll(PDO::FETCH_ASSOC);
			foreach($result as $row) {
				$output['customer_email'] = _e($row['customer_email']) ;
				$output['customer_mobile'] = _e($row['customer_phone']) ;
				$output['customer_tax'] = _e($row['customer_tax_no']) ;
				$output['customer_name'] = _e($row['customer_name']) ;
			}
			echo json_encode($output);
		} else {
			echo "Username is mandatory." ;
		}
	}
}
?>