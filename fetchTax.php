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
$Statement = $pdo->prepare("SELECT * FROM billing_tax WHERE 1 order by tax_id desc");
$Statement->execute(); 
$total = $Statement->rowCount();    
$result = $Statement->fetchAll(PDO::FETCH_ASSOC); 
$output = array('data' => array());
if($total > 0) {
	$statuss = "";
	foreach($result as $row) {
		$taxId = _e($row['tax_id']);
		$taxRate = _e($row['tax_slab_rate'])."%";
		$statuss = _e($row['tax_status']);
		if( ($_SESSION['type']['user_role'] == 'Admin')) {
			$updateTax = '<button type="button" name="updateTax" id="'.$taxId.'" class="btn btn-light btn-xs updateTax"><i class="fa fa-pencil-alt"></i></button>';
		} else {
			$updateTax = '' ;
		}
		if($statuss == 1) {
			// Deactivate User
			$statuss = "<b>Active</b>";
			if( ($_SESSION['type']['user_role'] == 'Admin')) {
				$myLink = '<button type="button" name="changeTaxStatus" id="'.$taxId.'" class="btn btn-danger btn-xs changeTaxStatus" data-status="0">Deactivate</button>';
			} else {
				$myLink = '' ;
			}
		} else {
			// Activate User
			$statuss = "Not Active";
			if( ($_SESSION['type']['user_role'] == 'Admin')) {
				$myLink = '<button type="button" name="changeTaxStatus" id="'.$taxId.'" class="btn btn-success btn-xs changeTaxStatus" data-status="1">Activate</button>';
			} else {
				$myLink = '' ;
			}
		}
		$output['data'][] = array( 		
		$taxId, 
		$taxRate,
		$statuss,
		$updateTax,
		$myLink		
		); 	
	}
}
echo json_encode($output);
?>