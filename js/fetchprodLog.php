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

if($_SESSION['type']['user_role'] == 'Admin') {
	$Statement = $pdo->prepare("select * from rec_inventory");
	$Statement->execute();
} else {
	$Statement = $pdo->prepare("select * from rec_inventory");
	$Statement->execute(array($_SESSION['type']['id']));
}

$total = $Statement->rowCount();    
$result = $Statement->fetchAll(PDO::FETCH_ASSOC); 
$output = array('data' => array());
if($total > 0) {
	$orderPaymentStatus = "" ;
	$orderStatus = "" ;
	$enterByEmail = "" ;
	$enterByRole = "" ;
	$editedByEmail = "" ;
	$editedByRole = "" ;
	foreach($result as $row) {
		
        
        
        	$ProdTitle = _e($row['id']) ;
            $QtyAdded = _e($row['id']) ;
            $enterBy = _e($row['id']) ;
            $DateUpdate = _e($row['id']) ;
        
     
        
        
		$enter_by_statement = $pdo->prepare("select email, user_role from billing_admin where id= ?");
		$enter_by_statement->execute(array($enterBy));
		$result_enter_by = $enter_by_statement->fetchAll(PDO::FETCH_ASSOC);
		$total = $enter_by_statement->rowCount();
		if($total > 0) {
			foreach ($result_enter_by as $enter) {
				$AddedBy = _e($enter['email']);
				$enterByRole = _e($enter['user_role']);
			}
		}

		
        
            	
      
		$output['data'][] = array( 		
	      	$ProdTitle,
            $QtyAdded,
            $AddedBy,
            $DateUpdate
			);
		
	}
}
echo json_encode($output);
?>
