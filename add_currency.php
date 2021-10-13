<?php
ob_start();
session_start();
include("db/config.php");
// Checking Admin is logged in or not
if( ($_SESSION['type']['user_role'] != 'Admin') ){
	header('location: '.ADMIN_URL.'/index.php');
	exit;
}
if(isset($_POST['btn_action_currency']))
{
	if($_POST['btn_action_currency'] == 'Add')
	{
		if( !empty($_POST['currency']) ) {
			$currency = filter_var(($_POST['currency']), FILTER_SANITIZE_STRING) ;
			$update_old = $pdo->prepare("update world_currencies set currency_status = 0 where 1");
			$update_old->execute();
			$update_currency = $pdo->prepare("update world_currencies set currency_status = ? where world_currency_id = ?");
			$update_currency->execute(array(filter_var("1",FILTER_SANITIZE_NUMBER_INT),$currency));
			echo "Currency Updated Successfully.";
		} else {
			echo "Currency Symbol is mandatory." ;
		}
	}
}
?>