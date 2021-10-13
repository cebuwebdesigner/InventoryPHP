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
$Statement = $pdo->prepare("SELECT * FROM billing_category WHERE 1 order by category_id desc");
$Statement->execute(array()); 
$total = $Statement->rowCount();    
$result = $Statement->fetchAll(PDO::FETCH_ASSOC); 
$output = array('data' => array());
if($total > 0) {
	$statuss = "";
	foreach($result as $row) {
		$categoryId = _e($row['category_id']);
		$categoryName = _e($row['category_name']);
		$statuss = _e($row['category_status']);
		if( ($_SESSION['type']['user_role'] == 'Admin')) {
			$updateCategory = '<button type="button" name="updateCategory" id="'.$categoryId.'" class="btn btn-light btn-xs updateCategory"><i class="fa fa-pencil-alt"></i></button>';
		} else {
			$updateCategory = '' ;
		}
		if($statuss == 1) {
			// Deactivate User
			$statuss = "<b>Active</b>";
			if( ($_SESSION['type']['user_role'] == 'Admin')) {
				$myLink = '<button type="button" name="changeCategoryStatus" id="'.$categoryId.'" class="btn btn-danger btn-xs changeCategoryStatus" data-status="0">Deactivate</button>';
			} else {
				$myLink = '' ;
			}
		} else {
			// Activate User
			$statuss = "Not Active";
			if( ($_SESSION['type']['user_role'] == 'Admin')) {
				$myLink = '<button type="button" name="changeCategoryStatus" id="'.$categoryId.'" class="btn btn-success btn-xs changeCategoryStatus" data-status="1">Activate</button>';
			} else {
				$myLink = '' ;
			}			
		}
		$output['data'][] = array( 		
		$categoryId, 
		$categoryName,
		$statuss,
		$updateCategory,
		$myLink		
		); 	
	}
}
echo json_encode($output);
?>