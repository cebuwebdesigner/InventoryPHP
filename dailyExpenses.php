<?php 
require_once('headr.php');


$dbhost = 'localhost';

$dbname = 'olivergo_agm' ;

$dbuser = 'olivergo_zach2'; 

$dbpass = 'Ms9@.ph';


 $thedb = 'billing_expenses';



$con = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);    
    

// Check connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  exit();
}
  


if($_POST['op']=="expenses"){
    
    
  
    

                    $expensesdate = $_POST['order_date'];
                    $expensesdescription = $_POST['description'];
                    $expensesamount = $_POST['amount'];
                    $enter_by = filter_var($_SESSION['type']['id'], FILTER_SANITIZE_NUMBER_INT) ;
                    $thedb = 'billing_expenses';

    if($expensesamount!=""){
$result = mysqli_query($con,"INSERT INTO $thedb(expenses_desc,expenses_amount,expenses_time,expenses_enter_by) VALUES ('$expensesdate','$expensesdescription','$expensesamount','$enter_by')");
    }
}


?>
	<div class="container-fluid mar-top">
      	<div class="row">
			<div class="col-lg-12 col-md-12">
				<div class="row">
		   			<div class="col-md-12 col-lg-12">
						<div class="panel panel-default">
							<div class="panel-heading">
								<div class="page-heading"> <h6>Manage Expenses</h6></div>
								<button class="btn btn-info  m-1" id="add_expenses"><i class="fa fa-plus-square"></i> Add </button>
							</div> <!-- /panel-heading -->
							<div class="panel-body">
								<div class="col-lg-12">
									<div class="remove-messages"></div>
								</div>
								<div class="row">
									<div class="col-md-12">
									  <div class="tile">
										<div class="tile-body">
											<div class="table-responsive">
												<table class="table table-bordered table-hover" id="managedenominationTable">
													<thead>
														<tr>
															<th>ID</th>
															<th>Description</th>
															<th>Amount</th>
															<th>Date</th>
															<th>Enter By</th>
															<!--<th><i class="fa fa-shopping-bag"></i></th>
															<th><i class="fa fa-pencil-alt"></i></th>
															<th><i class="fa fa-ban"></i></th>-->
														</tr>
													</thead>
                                                    
                                                    <tbody>
<?php
$resultmu = mysqli_query($con,"SELECT * FROM $thedb"); //WHERE Project = '$subject'
while($rowmu = mysqli_fetch_array($resultmu)) { 
    
   $enter_by = $rowmu['expenses_enter_by'];
    $resultmuA = mysqli_query($con,"SELECT * FROM billing_admin WHERE id='$enter_by'"); 
    while($rowmuA = mysqli_fetch_array($resultmuA)) { $expenses_enter_by = $rowmuA['email'];}
    
    echo '<tr><td>'.$rowmu['expenses_id'].'</td><td>'.$rowmu['expenses_desc'].'</td><td>'.$rowmu['expenses_amount'].'</td><td>'.$rowmu['expenses_time'].'</td><td>'.$expenses_enter_by.'</td></tr>';
  


} 
?>
                                                    </tbody>
                                                    
                                                    
												</table><!-- /table -->
											</div>
										</div>
									</div>
								</div>
							</div>
							</div> <!-- /panel-body -->
					</div> <!-- /panel -->	
					</div>
				</div>
			</div>
		</div>
	</div><!-- page-content" -->
	<!-- Add denomination Modal -->

	<!-- Add Order Modal -->
	<div id="expensesModal" class="modal fade " data-backdrop="static" data-keyboard="false">
    	<div class="modal-dialog modal-xl">
    		     
    			<div class="modal-content">
    				<div class="modal-header">
						<h4 class="modal-title"><i class="fa fa-plus"></i> Add Expenses</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						  <span aria-hidden="true">&times;</span>
						</button>
    				</div>
    				<div class="modal-body">
                        
                   <form method="post" id="expenses_form">
                <input type="hidden" name="op" value="expenses" />
                        
                         
                        
                       
                       <div class="col-lg-10 col-md-10" style="float:left">&nbsp;</div>
                       <div class="col-lg-2 col-md-2" style="float:left">
								<div class="form-group">
									<label>Date</label>
									<input type="text" name="order_date" id="order_date" class="form-control order_date" required="">
								</div>
							</div>
                       
                       
                       


  


<br style="clear:both">
                       
            <div class="row" style="width:100%; margin:0px; padding:0px">           
                       
 <div class="form-group  col-md-7" style="float:left">&nbsp;</div>
  
    <div class="form-group  col-md-5" style="float:left">
    <style>
	.greenok{ color:rgba(0,128,0,1.00)}
	.rednot{ color:#FF0000}
	</style>
    

  </div>
                       </div>         
                       
                       
<br style="clear:both">


                       
         <div class="form-group col-sm-9" style="float:left">
           <label>Description</label>
                                <input type="text" class="form-control" name="description" value="<?php echo $notes; ?>" <?php if($status==1){ echo 'readonly'; } ?>/>
                                </div>
                       
                       
                          <div class="form-group col-sm-3" style="float:left">
           <label>Amount</label>
                                <input type="number" class="form-control" name="amount" value="<?php echo $notes; ?>" <?php if($status==1){ echo 'readonly'; } ?>/>
                                </div>
                       
                       
                       
                                
                                
                <div class="form-group col-sm-3" style="display:none">
                                <label>Confirm Code</label>
                                <input type="password" class="form-control" name="concode" />
                                </div>
                                
                                
                                 
                                    
                                 <br style="clear:both">
                              <div class="form-group col-sm-12"><button type="submit"  class="btn btn-info action_prosingle"> Submit</button><br /><br />&nbsp;<br />&nbsp;</div>
                           
                                  
                                  
              </form>      
   

                        
                        
                        
                        
                        
                        
                        
                        
					</div>
					
    				<div class="modal-footer">
						<input type="hidden" name="singleorderdenomination_id" id="singleorderdenomination_id" class="singleorderdenomination_id"/>
						<input type="hidden" name="btn_action_pro" id="btn_action_prosingle"  class="btn_action_prosingle"/>
    					<!--<input type="submit" name="action_pro" id="action_prosingle" class="btn btn-info action_prosingle" value="Add"  />->
    					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    				</div>
    			</div>
    		</form>
    	</div>
    </div>
<?php require_once('footer.php'); ?>

