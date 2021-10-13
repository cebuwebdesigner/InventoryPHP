<?php
ob_start();
session_start();
include("db/config.php");
// Checking Admin is logged in or not
if( ($_SESSION['type']['user_role'] != 'Admin') ){
	header('location: '.ADMIN_URL.'/dashboard.php');
	exit;
}
if(isset($_POST['btn_action']))
{
	if($_POST['btn_action'] == 'Add')
	{
		if( !empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['repassword']) && !empty($_POST['role']) ){
			$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL) ;
			$role = filter_var($_POST['role'], FILTER_SANITIZE_STRING) ;
			$password = filter_var($_POST['password'], FILTER_SANITIZE_STRING) ;
			$repassword = filter_var($_POST['repassword'], FILTER_SANITIZE_STRING) ;
			$uppercase = preg_match('@[A-Z]@', $password);
			$lowercase = preg_match('@[a-z]@', $password);
			$number    = preg_match('@[0-9]@', $password);
			//validate password
			if(!$uppercase || !$lowercase || !$number || strlen($password) < 8) {
			  echo  "Password must contain 8 characters, an uppercase character, a lowercase character & atleast 1 number. Try Again" ;
			} else {
				//check password and confirm password are same
				if($password == $repassword) {
					//checking database for already registered Admin
					$checkAdmin =  $pdo->prepare("SELECT * FROM billing_admin WHERE email=?");
					$checkAdmin->execute(array($email));
					$admin_ok = $checkAdmin->rowCount();
					if($admin_ok > 0) {
						echo "Sorry, This Admin is already registered. Try Again with Other Email.";
					} else { 
						$ins_admin = $pdo->prepare("INSERT INTO billing_admin (email, auth_pass, user_role, active_status) VALUES (?,?,?,?)");
						$ins_admin->execute(array($email,password_hash($password, PASSWORD_DEFAULT),$role,filter_var("1", FILTER_SANITIZE_NUMBER_INT)));
						echo "New Manager added successfully." ;
					}
				} else {
					echo "Sorry, Password & Confirm Password does not match. Try Again." ;
				}
			}
		} else {
			echo "All Fields are mandatory" ;
		}
	}
}
?>