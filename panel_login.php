<?php
ob_start();
session_start();
require_once('db/config.php');
require_once("db/function_xss.php");
if( !empty($_POST['email']) && !empty($_POST['password']) ){
	$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL) ;
	$password = filter_var($_POST['password'], FILTER_SANITIZE_STRING) ;
	$userAuthentication =  $pdo->prepare("SELECT * FROM billing_admin WHERE email=? and active_status=?");
	$userAuthentication->execute(array($email,filter_var("1", FILTER_SANITIZE_NUMBER_INT)));
	$user_ok = $userAuthentication->rowCount();
	$userData = $userAuthentication->fetchAll(PDO::FETCH_ASSOC);
	if($user_ok > 0) {
		foreach($userData as $row){
			$auth_pass = _e($row['auth_pass']) ;
			$role = _e($row['user_role']) ;
		}
			if(password_verify($password, $auth_pass)) {
				$_SESSION['type'] = $row ;
				header("location: ".ADMIN_URL."/dashboard.php");
			} else {
				$_SESSION['error_message'] = 'Either wrong Email or Password. Try Again.';
				header("location: ".ADMIN_URL."/index.php");
			}
	}
	else {
		$_SESSION['error_message'] = 'Either wrong Email or Account Deactivated.';
		header("location: ".ADMIN_URL."/index.php");
	}

} else {
	$_SESSION['error_message'] = 'Email/Password cannot be empty.';
	header("location: ".ADMIN_URL."/index.php");
}
?>