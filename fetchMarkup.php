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
$Statement = $pdo->prepare("SELECT * FROM billing_markup WHERE 1 order by markup_id desc");
$Statement->execute(); 
$total = $Statement->rowCount();    
$result = $Statement->fetchAll(PDO::FETCH_ASSOC); 
$output = array('data' => array());
if($total > 0) {
	$statuss = "";
	foreach($result as $row) {
		$markupId = _e($row['markup_id']);
		$markupRate = _e($row['markup_slab_rate'])."%";
		$statuss = _e($row['markup_status']);
		if( ($_SESSION['type']['user_role'] == 'Admin')) {
			$updateTax = '<button type="button" name="updateTax" id="'.$markupId.'" class="btn btn-light btn-xs updateTax"><i class="fa fa-pencil-alt"></i></button>';
		} else {
			$updateTax = '' ;
		}
		if($statuss == 1) {
			// Deactivate User
			$statuss = "<b>Active</b>";
			if( ($_SESSION['type']['user_role'] == 'Admin')) {
				$myLink = '<button type="button" name="changeTaxStatus" id="'.$markupId.'" class="btn btn-danger btn-xs changeTaxStatus" data-status="0">Deactivate</button>';
			} else {
				$myLink = '' ;
			}
		} else {
			// Activate User
			$statuss = "Not Active";
			if( ($_SESSION['type']['user_role'] == 'Admin')) {
				$myLink = '<button type="button" name="changeTaxStatus" id="'.$markupId.'" class="btn btn-success btn-xs changeTaxStatus" data-status="1">Activate</button>';
			} else {
				$myLink = '' ;
			}
		}
		$output['data'][] = array( 		
		$markupId, 
		$markupRate,
		$statuss,
		$updateTax,
		$myLink		
		); 	
	}
}
echo json_encode($output);
?>