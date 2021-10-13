<?php
ob_start();
session_start();
include("db/config.php");
include("db/CSRF_Protect.php");
include("db/function_xss.php");
include("db/functions.php");
$csrf = new CSRF_Protect();
// Checking Admin or Manager is logged in or not
if( ($_SESSION['type']['user_role'] != 'Admin') && ($_SESSION['type']['user_role']!= 'Manager') ){
	header('location: '.ADMIN_URL.'/index.php');
	exit;
}
$id = _e($_SESSION['type']['id']) ; 
$admin = $pdo->prepare("SELECT * FROM billing_admin WHERE active_status=? and id = ?");
$admin->execute(array(filter_var("1", FILTER_SANITIZE_NUMBER_INT),$id));   
$admin_result = $admin->fetchAll(PDO::FETCH_ASSOC);
$total = $admin->rowCount();
//if admin or manager deactivated 
if($total == '0'){
	header('location: logout.php');
	exit;
}
foreach($admin_result as $adm) {
//escape all  data
	$id = _e($adm['id']);
	$role = _e($adm['user_role']);
	$email_old   = _e($adm['email']);
	$old_password = _e($adm['auth_pass']);
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>AGM Dashboard</title>

	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<link rel="stylesheet" href="<?php echo ADMIN_URL; ?>/css/main.css">
	<link rel="stylesheet" href="<?php echo ADMIN_URL; ?>/css/bootstrap-select.min.css">
	<link rel="stylesheet" href="<?php echo ADMIN_URL; ?>/css/all.min.css">
	<link rel="stylesheet" href="<?php echo ADMIN_URL; ?>/css/datepicker.css">
	<link rel="stylesheet" href="<?php echo ADMIN_URL; ?>/css/Latofont.css">
	<link rel="stylesheet" href="<?php echo ADMIN_URL; ?>/css/Niconnefont.css">
	

    
</head>
<body class="app sidebar-mini">
    <!-- Navbar-->
    <header class="app-header"><a class="app-header__logo" href="<?php echo ADMIN_URL; ?>/dashboard.php"><img src="<?php echo ADMIN_URL; ?>/images/siteLogo.png" class="img-fluid" alt="Logo"></a>
      <!-- Sidebar toggle button--><a class="app-sidebar__toggle" href="#" data-toggle="sidebar" aria-label="Hide Sidebar"><i class="fa fa-bars fa-2x"></i></a>
      <!-- Navbar Right Menu-->
      <ul class="app-nav">
        <!-- User Menu-->
       
          
          
             <li class="dropdown"><a class="app-nav__item" href="#" data-toggle="dropdown"><i class="app-menu__icon fa fa-cogs"></i><span class="app-menu__label"></span></a>
          <ul class="dropdown-menu settings-menu dropdown-menu-right">
		  <?php if($role == 'Admin'){ ?>
		    
            <li><a class="dropdown-item"  href="<?php echo ADMIN_URL; ?>/addAdmin.php"><i class="icon fa fa-user-secret"></i> Admin</a></li>
            <li><a class="dropdown-item"  href="<?php echo ADMIN_URL; ?>/addManager.php"><i class="icon fa fa-briefcase"></i> Manager</a></li>
              
                <li><a class="dropdown-item" href="<?php echo ADMIN_URL; ?>/addEmp.php"><i class="icon fa fa-users"></i> Employee</a></li>
              <li><a class="dropdown-item" href="<?php echo ADMIN_URL; ?>/addUser.php"><i class="icon fa fa-user"></i> Customers</a></li>
    
            <li><a class="dropdown-item" href="<?php echo ADMIN_URL; ?>/addCategory.php"><i class="icon fa fa-bars"></i> Product Category</a></li>
                <li><a class="dropdown-item" href="<?php echo ADMIN_URL; ?>/addCategory2.php"><i class="icon fa fa-bars"></i> Service Category</a></li>
	<!--		<li><a class="dropdown-item" href="<?php echo ADMIN_URL; ?>/addBrand.php"><i class="icon fa fa-cube"></i> Brand</a></li> -->
              <li><a class="dropdown-item" href="<?php echo ADMIN_URL; ?>/addMarkup.php"><i class="icon fa fa-cube"></i> Markup</a></li>
			<li><a class="dropdown-item" href="<?php echo ADMIN_URL; ?>/addTax.php"><i class="icon fa fa-percent"></i> Tax</a></li>
			<?php }  if($role == 'Admin' || $role == 'Manager') { ?>
			
			<?php } ?>
          </ul>
        </li>
          
          
          <li class="dropdown"><a class="app-nav__item" href="#" data-toggle="dropdown" aria-label="Open Profile Menu"><i class="fa fa-user fa-lg"></i></a>
          <ul class="dropdown-menu settings-menu dropdown-menu-right">
            <li>
			<?php if($role == 'Admin'){ ?><a class="dropdown-item" href="company_detail.php"><i class="fa fa-fax"></i> Company Details</a> <?php } ?>
			</li>
            <li><a class="dropdown-item"  href="<?php echo ADMIN_URL; ?>/change_password.php"><i class="fa fa-key"></i> Password</a></li>
            <li><a class="dropdown-item" href="<?php echo ADMIN_URL; ?>/logout.php"><i class="fa fa-sign-out-alt fa-lg"></i> Logout</a></li>
          </ul>
        </li>
          
          
          
          
        
		
          
          
      </ul>
    </header>
    <!-- Sidebar menu-->
    <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
    <aside class="app-sidebar">
      <div class="app-sidebar__user"><?php if($role == 'Admin'){ ?><i class="fa fa-user-secret fa-2x text-warning"></i><?php } else { ?><i class="fa fa-briefcase fa-2x text-warning"></i><?php } ?>
        <div>
          <p class="app-sidebar__user-name"><?php echo $email_old ;?></p>
          <p class="app-sidebar__user-designation"><?php echo $role ; ?></p>
        </div>
      </div>
      <ul class="app-menu">
        <li><a class="app-menu__item" href="<?php echo ADMIN_URL; ?>/dashboard.php"><i class="app-menu__icon fa fa-laptop"></i><span class="app-menu__label">Dashboard</span></a></li>
          
        <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-file"></i><span class="app-menu__label">Inventory</span><i class="treeview-indicator fa fa-angle-right"></i></a>
          <ul class="treeview-menu" style="font-size:11px">
           
              <li><a class="treeview-item"  class="header_order app-menu__item" href="<?php echo ADMIN_URL; ?>/addProduct.php"> &nbsp; &nbsp; &nbsp; <i class="icon fa fa-plus-square"></i> &nbsp; &nbsp; General inventory </a></li>
			
              <li><a class="treeview-item"  class="header_order app-menu__item" href="<?php echo ADMIN_URL; ?>/addStock.php"> &nbsp; &nbsp; &nbsp; <i class="icon fa fa-plus-square"></i> &nbsp; &nbsp; Additional Stocks </a></li>
			
            <li><a class="treeview-item"  class="header_order app-menu__item" href="<?php echo ADMIN_URL; ?>/productLog.php"> &nbsp; &nbsp; &nbsp; <i class="icon fa fa-file"></i> &nbsp; &nbsp; View Logs</a></li>
            
          </ul>
        </li>
          
          
          
          
       <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-shopping-bag"></i><span class="app-menu__label">Daily Purchase</span><i class="treeview-indicator fa fa-angle-right"></i></a>
          <ul class="treeview-menu" style="font-size:11px">
         	
              <li><a href="#" class="header_order app-menu__item"> &nbsp; &nbsp; &nbsp; <i class="app-menu__icon  fa fa-plus-square"></i> <span class="app-menu__label"> Add Purchase</span></a></li>	
              
            	<li><a href="<?php echo ADMIN_URL; ?>/manageOrder.php" class="app-menu__item"> &nbsp; &nbsp; &nbsp; <i class="app-menu__icon fa fa-edit"></i> <span class="app-menu__label"> Manage Purchase</span></a></li>
              
              
              <!--<li><a class="treeview-item" href="<?php echo ADMIN_URL; ?>/addProduct.php"> &nbsp; &nbsp; &nbsp; <i class="icon fa fa-pencil-alt"></i> <span class="app-menu__label"> &nbsp; &nbsp;Products Offer</span></a></li>-->
			
     
          </ul>
        </li>
          
          
          
          
            <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-shopping-bag"></i><span class="app-menu__label">Services</span><i class="treeview-indicator fa fa-angle-right"></i></a>
          <ul class="treeview-menu" style="font-size:11px">
         	 <li><a href="#" class="header_order2 app-menu__item"> &nbsp; &nbsp; &nbsp; <i class="app-menu__icon  fa fa-plus-square"></i> <span class="app-menu__label"> Add Serve</span></a></li>
            	
              	<li><a href="<?php echo ADMIN_URL; ?>/manageOrder2.php" class="app-menu__item"> &nbsp; &nbsp; &nbsp; <i class="app-menu__icon fa fa-edit"></i> <span class="app-menu__label"> Manage Service</span></a></li>
          
              <li><a class="treeview-item" href="<?php echo ADMIN_URL; ?>/addService.php"> &nbsp; &nbsp; &nbsp; <i class="icon fa fa-pencil-alt"></i> <span class="app-menu__label"> &nbsp; &nbsp;Services Setup</span></a></li>
			
          </ul>
        </li>
          
          
          
	
           
            <li><a href="dailyExpenses.php" class="app-menu__item"><i class="app-menu__icon  fa fa-paperclip"></i><span class="app-menu__label"> Daily Expenses </span></a></li>
         
          
         
          
          
            <li><a href="enddayDenomination.php" class="app-menu__item"><i class="app-menu__icon  fa fa-money-bill"></i><span class="app-menu__label"> End Day Denomination </span></a></li>
          
       
	     
          
          
   
          
           
          
        <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-shopping-cart"></i><span class="app-menu__label">Sales Report</span><i class="treeview-indicator fa fa-angle-right"></i></a>
          <ul class="treeview-menu" style="font-size:11px">
            <li><a class="treeview-item" href="<?php echo ADMIN_URL; ?>/datewiseSale.php">  &nbsp; &nbsp; &nbsp; <i class="icon fa fa-shopping-bag"></i> Datewise Sale</a></li>
            <li><a class="treeview-item" href="<?php echo ADMIN_URL; ?>/productwiseSale.php">  &nbsp; &nbsp; &nbsp; <i class="icon fa fa-shopping-cart"></i> Productwise Sale</a></li>
            <li><a class="treeview-item" href="<?php echo ADMIN_URL; ?>/categorywiseSale.php">  &nbsp; &nbsp; &nbsp; <i class="icon fa fa-align-justify"></i> Categorywise Sale</a></li>
            
          </ul>
        </li>
          
          
          
          
  
          
        
      </ul>
    </aside>
    <main class="app-content">
  <!-- sidebar-wrapper  -->
<!-- Add Header Order Modal -->
	<div id="headerorderModal" class="modal fade " data-backdrop="static" data-keyboard="false">
    	<div class="modal-dialog modal-xl">
    		<form method="post" id="headerorder_form">
    			<div class="modal-content">
    				<div class="modal-header">
						<h4 class="modal-title"><i class="fa fa-plus"></i> Add Order</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						  <span aria-hidden="true">&times;</span>
						</button>
    				</div>
    				<div class="modal-body">
						<div class="row">
							<div class="col-lg-2 col-md-2">
								<div class="form-group">
									<label>UserName*</label>
									<select name="ordercustomer_username" id="ordercustomer_username" class="form-control user_selectpicker" data-live-search="true" required>
										<option value="">Select Username</option>
										<?php echo fill_username($pdo); ?>
									</select>
								</div>
							</div>
                            
                            <div class="col-lg-6 col-md-6">&nbsp;</div>
							<div class="col-lg-2 col-md-2">
								<div class="form-group">
									<label>Date</label>
									<input type="text" name="order_date" id="order_date" class="form-control order_date" required />
								</div>
							</div>
							<div class="col-lg-2 col-md-2"  style="display:none">
								<div class="form-group">
									<label>Name</label>
									<input type="text" name="ordercustomer_name" id="ordercustomer_name" class="form-control ordercustomer_name" readonly="readonly"  />
								</div>
							</div>
							<div class="col-lg-2 col-md-2" style="display:none">
								<div class="form-group">
									<label>Email</label>
									<input type="email" name="ordercustomer_email" id="ordercustomer_email" class="form-control ordercustomer_email" readonly="readonly"  />
								</div>
							</div>
							<div class="col-lg-2 col-md-2" style="display:none">
								<div class="form-group">
									<label>Mobile</label>
									<input type="text" name="ordercustomer_mobile" id="ordercustomer_mobile" class="form-control ordercustomer_mobile" readonly="readonly"  />
								</div>
							</div>
							<div class="col-lg-2 col-md-2" style="display:none">
								<div class="form-group">
									<label>Tax No./ GSTIN</label>
									<input type="text" name="ordercustomer_tax" id="ordercustomer_tax" class="form-control ordercustomer_tax" readonly="readonly" />
								</div>
							</div>
                            
                            <div class="col-lg-12"	><hr /></div>
                            
						</div>
						<div class="row">
						<div class="col-lg-12"	>
						<span class="span_product_details"></span>
						</div>
					</div>
                        
                        
                        
                        
                          <div class="row">
							 
                              <div class="col-lg-8 col-md-8">&nbsp;</div>
                        <div class="col-lg-4 col-md-4">
								<div class="form-group">
									<label>Total Amount</label>
									<input type="text" name="totalAftertax" id="totalAftertax" class="form-control totalAftertax" readonly="readonly" />
								</div>
							</div>
                              
                              
                                <div class="col-lg-12"	><hr /></div>
                              
                              
                        </div>
                              
                              
                        <div class="row">
                            <div class="col-lg-2 col-md-2">&nbsp;</div>
                            
                            <div class="col-lg-3 col-md-3">
								<div class="form-group">
									<label>Discount </label>
									<input type="text" name="discount" id="discount" class="form-control discount"  />
								</div>
							</div>
							
							<div class="col-lg-3 col-md-3">
								<div class="form-group">
									<label>Paid Amount</label>
									<input type="text" name="paid" id="paid" class="form-control paid" required/>
								</div>
							</div>
							<div class="col-lg-4 col-md-4">
								<div class="form-group">
									<label>Due Amount</label>
									<input type="text" name="due" id="due" class="form-control due" readonly="readonly"  />
								</div>
							</div>
						
					</div>
                        
                        
					</div>
					
    				<div class="modal-footer">
						<input type="hidden" name="ordercustomer_id" id="ordercustomer_id" class="ordercustomer_id"/>
						<input type="hidden" name="btn_action_pro" id="btn_action_pros" class="btn_action_pros" />
    					<input type="submit" name="action_pro" id="action_pros" class="btn btn-info action_pros" value="Add"  />
    					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    				</div>
    			</div>
    		</form>
    	</div>
    </div>
        
        
        
        
        
        
        
        

        
        <div id="headerorderModal2" class="modal fade " data-backdrop="static" data-keyboard="false">
    	<div class="modal-dialog modal-xl">
    		<form method="post" id="headerorder_form2">
    			<div class="modal-content">
    				<div class="modal-header">
						<h4 class="modal-title2"><i class="fa fa-plus"></i> Add Service</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						  <span aria-hidden="true">&times;</span>
						</button>
    				</div>
    				<div class="modal-body">
						<div class="row">
							<div class="col-lg-2 col-md-2">
								<div class="form-group">
									<label>UserName*</label>
									<select name="ordercustomer_username" id="ordercustomer_username"2 class="form-control user_selectpicker" data-live-search="true" required>
										<option value="">Select Username</option>
										<?php echo fill_username($pdo); ?>
									</select>
								</div>
							</div>
                            
                            <div class="col-lg-6 col-md-6">&nbsp;</div>
							<div class="col-lg-2 col-md-2">
								<div class="form-group">
									<label>Date</label>
									<input type="text" name="order_date" id="order_date2" class="form-control order_date" required />
								</div>
							</div>
							<div class="col-lg-2 col-md-2"  style="display:none">
								<div class="form-group">
									<label>Name</label>
									<input type="text" name="ordercustomer_name" id="ordercustomer_name2" class="form-control ordercustomer_name" readonly="readonly"  />
								</div>
							</div>
							<div class="col-lg-2 col-md-2" style="display:none">
								<div class="form-group">
									<label>Email</label>
									<input type="email" name="ordercustomer_email" id="ordercustomer_email2" class="form-control ordercustomer_email" readonly="readonly"  />
								</div>
							</div>
							<div class="col-lg-2 col-md-2" style="display:none">
								<div class="form-group">
									<label>Mobile</label>
									<input type="text" name="ordercustomer_mobile" id="ordercustomer_mobile2" class="form-control ordercustomer_mobile" readonly="readonly"  />
								</div>
							</div>
							<div class="col-lg-2 col-md-2" style="display:none">
								<div class="form-group">
									<label>Tax No./ GSTIN</label>
									<input type="text" name="ordercustomer_tax" id="ordercustomer_tax2" class="form-control ordercustomer_tax" readonly="readonly" />
								</div>
							</div>
                            
                            <div class="col-lg-12"	><hr /></div>
                            
						</div>
						<div class="row">
						<div class="col-lg-12"	>
						<span class="span_service_details"></span>
						</div>
					</div>
                        
                        
                        
                        
                          <div class="row">
							 
                              <div class="col-lg-8 col-md-8">&nbsp;</div>
                        <div class="col-lg-4 col-md-4">
								<div class="form-group">
									<label>Total Amount</label>
									<input type="text" name="totalAftertax" id="totalAftertax2" class="form-control totalAftertax" readonly="readonly" />
								</div>
							</div>
                              
                              
                                <div class="col-lg-12"	><hr /></div>
                              
                              
                        </div>
                              
                              
                        <div class="row">
                            <div class="col-lg-2 col-md-2">&nbsp;</div>
                            
                            <div class="col-lg-3 col-md-3">
								<div class="form-group">
									<label>Discount </label>
									<input type="text" name="discount" id="discount2" class="form-control discount"  />
								</div>
							</div>
							
							<div class="col-lg-3 col-md-3">
								<div class="form-group">
									<label>Paid Amount</label>
									<input type="text" name="paid" id="paid2" class="form-control paid" required/>
								</div>
							</div>
							<div class="col-lg-4 col-md-4">
								<div class="form-group">
									<label>Due Amount</label>
									<input type="text" name="due" id="due2" class="form-control due" readonly="readonly"  />
								</div>
							</div>
						
					</div>
                        
                        
					</div>
					
    				<div class="modal-footer">
						<input type="hidden" name="ordercustomer_id" id="ordercustomer_id2" class="ordercustomer_id"/>
						<input type="hidden" name="btn_action_pro" id="btn_action_pros2" class="btn_action_pros" />
    					<input type="submit" name="action_pro" id="action_pros2" class="btn btn-info action_pros" value="Add"  />
    					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    				</div>
    			</div>
    		</form>
    	</div>
    </div>
        
        
        
        
        
        
        
        
