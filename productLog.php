<?php 
require_once('headr.php');
?>
	<div class="container-fluid mar-top">
      	<div class="row">
			<div class="col-lg-12 col-md-12">
				<div class="row">
		   			<div class="col-md-12 col-lg-12">
						<div class="panel panel-default">
							<div class="panel-heading">
								<div class="page-heading"> 
									
									<div class="row">
										<div class="col-lg-4 col-md-4 ">
											<h3 class="panel-title">Inventory Log</h3>
										</div>
										<div class="col-lg-8 col-md-8" style="display:none">
										<div class="row">
										<div class="col-md-12 col-lg-12">
											<form action="datewise_order.php" method="post" enctype="multipart/form-data" class="form-inline float-right">
											  <div class="form-group mb-2">
												<input type="text" readonly class="form-control-plaintext" id="staticEmail2" value="Datewise Order">
											  </div>
											  <div class="form-group mx-sm-3 mb-2">
												<label for="order_date" class="sr-only">Order Date</label>
												<input type="text" class="form-control order_date" id="order_date" name="order_date" placeholder="Date">
											  </div>
											  <input type="hidden" name="role" value="<?php echo $_SESSION['type']['user_role'] ; ?>" />
											  <input type="hidden" name="uid" value="<?php echo $_SESSION['type']['id'] ; ?>" />
											  <input type="submit" name="download" class="btn btn-info mb-2" value="Download" >
											</form>
										</div>
										</div>
										</div>
										
									</div>
								</div>
							</div> <!-- /panel-heading -->
							<div class="panel-body">
								<div class="remove-messages"></div>
								<div class="row">
									<div class="col-md-12">
								  		<div class="tile">
											<div class="tile-body">
												<div class="table-responsive">
													<table class="table table-bordered table-hover" id="productLogTable">
														<thead>
															<tr>
                                                                
                                                                <th>Product Title</th>
																<th>Qty Added</th>
                                                                <th>Added By</th>
																<th>Date Updated</th>
														
                                                                
                                                                                  
															</tr>
														</thead>
                                                        <tbody>
                                                            
                                                            
<?php
       
                                                            
$dbhost = 'localhost' ;
$dbname = 'olivergo_agm' ;
$dbuser = 'olivergo_zach2'; 
$dbpass = 'Ms9@.ph';



$con = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);    
    

// Check connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  exit();
}                                                  
              
                                                            
                                                            
$resultvsub = mysqli_query($con,"SELECT * FROM rec_inventory"); //WHERE Project = '$subject'
while($rowvsub = mysqli_fetch_array($resultvsub)) {  

    
    
    $adminID = $rowvsub['AddedBy'];
                                                                
$resultadmin = mysqli_query($con,"SELECT * FROM billing_admin WHERE id='$adminID'"); //WHERE Project = '$subject'
while($rowadmin = mysqli_fetch_array($resultadmin)) { $AddedBy = $rowadmin['email']; }
    
    
    

                                                            echo '<tr>
                                                                <td>'.$rowvsub['ProdTitle'].'</td>
                                                                <td>'.$rowvsub['QtyAdded'].'</td>
                                                                <td>'.$AddedBy.'</td>
                                                                <td>'.$rowvsub['DateUpdate'].'</td>
                                                            </tr>';
                                                            
                                                            
                                                            }
                                                            
                                                            ?>
                                                            
                                                            
                                                        </tbody>
                                                        
                                                        
													</table><!-- /table <th>Create Role</th> <th>Edited Role</th>
																
																<th style="display:none">Customer Email</th>
																<th style="display:none">Customer Mobile</th>
																<th style="display:none">Customer Tax No.</th>
																 -->
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

<script>
    $(document).ready(function() {
        
    //$('#productLogTable').DataTable();
        
    }
</script>

<?php require_once('footer.php'); ?>

