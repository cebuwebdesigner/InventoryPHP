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
if($_POST['pass_submit_pr']){
	if($_POST['pass_submit_pr'] == 'Submit') {
		$oldpass = filter_var($_POST['oldpass'], FILTER_SANITIZE_STRING) ;
		$newpass = filter_var($_POST['newpass'], FILTER_SANITIZE_STRING) ;
		$repass = filter_var($_POST['repass'], FILTER_SANITIZE_STRING) ;
		$id = filter_var($_POST['uid'], FILTER_SANITIZE_NUMBER_INT) ;
		$uppercase = preg_match('@[A-Z]@', $newpass);
		$lowercase = preg_match('@[a-z]@', $newpass);
		$number    = preg_match('@[0-9]@', $newpass);
		$statement = $pdo->prepare("select * from billing_admin where id = ?");
		$statement->execute(array($id)) ;
		$result = $statement->fetchAll(PDO::FETCH_ASSOC); 
		$user_ok = $statement->rowCount();
		if($user_ok > 0) {
			foreach($result as $row){
				$auth_pass = _e($row['auth_pass']) ;
			}
			if(password_verify($oldpass, $auth_pass)) {
				if($newpass == $repass) {
					//validate password
					if(!$uppercase || !$lowercase || !$number || strlen($newpass) < 8) {
						$form_message = "Password must contain 8 characters, an uppercase character, a lowercase character & atleast 1 number. Try Again.";
						$output = array( 
								'form_message' => $form_message
								) ;
						echo json_encode($output);
					} else {
						$update_password = $pdo->prepare("update billing_admin set auth_pass = ? where id = ?");
						$update_password->execute(array(password_hash($newpass, PASSWORD_DEFAULT),$id));
						$form_message = "Password Updated Successfully.";
						$output = array( 
								'form_message' => $form_message
								) ;
						echo json_encode($output);
					}
				} else {
					$form_message = "Password & Confirm Password is not Match. Try Again.";
					$output = array( 
							'form_message' => $form_message
							) ;
					echo json_encode($output);
				}
			} else {
				$form_message = "Old Password is wrong. Try Again.";
				$output = array( 
						'form_message' => $form_message
						) ;
				echo json_encode($output);
			}
		} else {
			$form_message = "This is not authorized user.";
			$output = array( 
					'form_message' => $form_message
					) ;
			echo json_encode($output);
		}
	}
} 
?>