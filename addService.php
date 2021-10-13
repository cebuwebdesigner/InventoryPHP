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
								<div class="page-heading"> <h6>Manage Services</h6></div>
								<?php if( ($_SESSION['type']['user_role'] == 'Admin')) { ?><button class="btn btn-info  m-1" id="add_service"><i class="fa fa-plus-square"></i> Add Service</button><?php } ?>
							</div> <!-- /panel-heading -->
							<div class="panel-body">
								<div class="remove-messages"></div>
								<div class="row">
									<div class="col-md-12">
									  <div class="tile">
										<div class="tile-body">
											<div class="table-responsive">
												<table class="table table-bordered table-hover" id="manageServiceTable">
													<thead>
														<tr>
															<th>ID</th>
															<th>Enter By</th>
															<th>Last Edited By</th>
															<th>Category</th>					
															<th>Brand</th>
															<th>Service Name</th>
															<th>Service SKU code</th>
															<th>Quantity</th>
															<th>Unit</th>
															<th>Tax %</th>
															<th>Base Price</th>
															<th>Tax Price</th>
															<th>Selling Price</th>
															<th>Status</th>
															<th><i class="fa fa-pencil-alt"></i></th>
															<th><i class="fa fa-ban"></i></th>
														</tr>
													</thead>
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
	<!-- Add Service Modal -->
	<div id="serviceModal" class="modal fade " data-backdrop="static" data-keyboard="false">
    	<div class="modal-dialog modal-lg">
    		<form method="post" id="service_form">
    			<div class="modal-content">
    				<div class="modal-header">
						<h4 class="modal-title"><i class="fa fa-plus"></i> Add Services</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						  <span aria-hidden="true">&times;</span>
						</button>
    				</div>
    				<div class="modal-body">
						<div class="row">
							<div class="col-lg-6 col-md-6">
								<div class="form-group">
									<label>Category*</label>
									<select name="category_id" id="category_id" class="form-control" required>
										<option value="">Select Category</option>
										<?php echo fill_category2_list($pdo); ?>
									</select>
								</div>
							</div>
							<div class="col-lg-6 col-md-6" style="display:none">
								<div class="form-group">
									<label>Brand*</label>
									<select name="brand_id" id="brand_id" class="form-control" >
										<option value="">Select Brand</option>
									</select>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label>Service Name*</label>
							<input type="text" name="service_name" id="service_name" class="form-control" required />
						</div>
						<div class="form-group">
							<label>Service SKU code*</label>
							<span id="check_service_sku"></span>
							<input type="text" name="service_sku" id="service_sku" class="form-control" autocomplete="off" required />
						</div>
						<div class="row">
							<div class="col-lg-6 col-md-6">
								<div class="row">
								<div class="col-lg-6 col-md-6">
								<div class="form-group">
									<label>Service Quantity*</label>
									<span><input type="text" name="service_quantity" id="service_quantity" class="form-control" required  /></span>
								</div>
								</div>
								<div class="col-lg-6 col-md-6">
								<div class="form-group pr">
									<label>Add Quantity*</label>
									<span id="service_qt" ><input type="text" name="addPro" id="addPro" class="form-control" /></span>
								</div>
								</div>
								</div>
							</div>
							<div class="col-lg-3 col-md-3">	
								<div class="form-group">
									<label>Unit*</label>
									   <select name="service_unit" id="service_unit" class="form-control" required>
										<option value="">Select Unit</option>
										<option value="Equiptment">Equiptment</option>
                                     
									  </select>
								</div>
							</div>
							<div class="col-lg-3 col-md-3">	
								<div class="form-group">
									<label>Tax% *</label>
									<select name="tax_rate" id="tax_rate" class="form-control" required>
										<option value="">Select Tax %</option>
										<?php echo fill_tax_rate($pdo); ?>
									</select>
								</div>
							</div>
						</div>
                        
                        	<div class="row">
							<div class="col-lg-6 col-md-6">
								<div class="form-group">
							<label>Service Base Price*</label>
							<input type="text" name="service_bp" id="service_bp" class="form-control" required />
						</div>
							</div>
							<div class="col-lg-6 col-md-6">
								<div class="form-group">
							<label>Service Selling Price*</label>
							<input type="text" name="service_sp" id="service_sp" class="form-control" required />
						</div>
							</div>
						</div>
                        
                        
                        
                        
						
						
    				</div>
    				<div class="modal-footer">
						<input type="hidden" name="service_id" id="service_id"/>
						<input type="hidden" name="btn_action" id="btn_action" />
    					<input type="submit" name="action" id="action" class="btn btn-info" value="Add" />
    					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    				</div>
    			</div>
    		</form>
    	</div>
    </div>
<?php require_once('footer.php'); ?>

