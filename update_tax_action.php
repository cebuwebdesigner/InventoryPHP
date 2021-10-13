<?php
ob_start();
session_start();
include("db/config.php");
include("db/function_xss.php");
// Checking Admin is logged in or not
if( ($_SESSION['type']['user_role'] != 'Admin') ){
	header('location: '.ADMIN_URL.'/index.php');
	exit;
}
if(isset($_POST['btn_action']))
{	
	if($_POST['btn_action'] == 'fetch_tax')
	{	
		$tax_id = filter_var($_POST['tax_id'], FILTER_SANITIZE_NUMBER_INT) ;
		$fetchTax = $pdo->prepare("select * from billing_tax where tax_id = ?");
		$fetchTax->execute(array($tax_id));
		$taxData = $fetchTax->fetchAll(PDO::FETCH_ASSOC);
		foreach($taxData as $row) {
			$output['tax_slab_rate'] = _e($row['tax_slab_rate']) ;
		}
		echo json_encode($output);
	}
	
}
?>
