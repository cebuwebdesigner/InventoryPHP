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
								<div class="page-heading"> <h6>Manage Stocks</h6></div>
								
							</div> <!-- /panel-heading -->
							<div class="panel-body">
								<div class="remove-messages"></div>
								<div class="row">
									<div class="col-md-12">
									  <div class="tile">
										<div class="tile-body">
											<div class="table-responsive">
												<table class="table table-bordered table-hover" id="manageProductTable2">
													<thead>
														<tr>
                                                            
															<!--<th>ID</th>-->
                                                            	<th>Name</th>
															<th>Category</th>					
															<!--<th>Brand</th>-->
														
															<th>SKU</th>
															<th>Quantity</th>
															<!--<th>Unit</th>
															<th>Tax %</th>
															<th>Base Price</th>
															<th>Tax Price</th>
															<th>Selling</th>-->
															
															
															<th>Update By</th>
															
                                                            <th>Update</th>
															
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
	<!-- Add Product Modal -->
	<div id="productModal" class="modal fade " data-backdrop="static" data-keyboard="false">
    	<div class="modal-dialog modal-lg">
    		<form method="post" id="product_form">
    			<div class="modal-content">
    				<div class="modal-header">
						<h4 class="modal-title"><i class="fa fa-plus"></i> Add Product</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						  <span aria-hidden="true">&times;</span>
						</button>
    				</div>
    				<div class="modal-body">
                        
                        
                        
                        <div class="row">
							<div class="col-lg-6 col-md-6">
								<div class="row">
								<div class="col-lg-6 col-md-6">
								<div class="form-group">
									<label> Quantity*</label>
									<span><input type="text" name="product_quantity" id="product_quantity" class="form-control" required  /></span>
								</div>
								</div>
								<div class="col-lg-6 col-md-6">
								<div class="form-group pr">
									<label>Add Quantity*</label>
									<span id="product_qt" ><input type="text" name="addPro" id="addPro" class="form-control" /></span>
								</div>
								</div>
								</div>
							</div>
						
						
						</div>
                        
                        
                        
						<div class="row">
							<div class="col-lg-12 col-md-12">
								<div class="form-group">
									<label>Category*</label>
									<select name="category_id" id="category_id" class="form-control" required>
										<option value="">Select Category</option>
										<?php echo fill_category_list($pdo); ?>
									</select>
								</div>
							</div>
							<div class="col-lg-6 col-md-6">
								<div class="form-group" style="display:none">
									<label>Brand*</label>
									<select name="brand_id" id="brand_id" class="form-control" >
										<option value="">Select Brand</option>
									</select>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label> Name*</label>
							<input type="text" name="product_name" id="product_name" class="form-control" required />
						</div>
                        
                        
                        
                        <div class="row">
                        
                        <div class="col-lg-6 col-md-6">	
						<div class="form-group">
							<label> SKU code*</label>
							<span id="check_product_sku"></span>
							<input type="text" name="product_sku" id="product_sku" class="form-control" autocomplete="off" required />
						</div>
                        </div>
                       
                        	<div class="col-lg-6 col-md-6">	
								<div class="form-group">
									<label>Unit*</label>
									   <select name="product_unit" id="product_unit" class="form-control" required>
										<option value="">Select Unit</option>
										<!--<option value="Bags">Bags</option>
										<option value="Bottles">Bottles</option>
										<option value="Box">Box</option>
										<option value="Dozens">Dozens</option>
										<option value="Feet">Feet</option>
										<option value="Gallon">Gallon</option>
										<option value="Grams">Grams</option>
										<option value="Inch">Inch</option>
										<option value="Kg">Kg</option>
										<option value="Liters">Liters</option>-->
										<option value="Meter">Meter</option>
										<!--<option value="Nos">Nos</option>
										<option value="Packet">Packet</option>-->
										<option value="Rolls">Rolls</option>
                                           
                                           <option value="Pieces">Pieces</option>
                                           <option value="Set">Set</option>
                                           
                                           
                                           
									  </select>
								</div>
							</div>
                    
                    
                    
                    
                    
                        </div>
                        
                        
                        
                        
                        
                        
                        
						
                        
                        	<div class="row">
							<div class="col-lg-6 col-md-6">
								<div class="form-group">
							<label> Base Price*</label>
							<input type="text" name="product_bp" id="product_bp" class="form-control" required />
						</div>
							</div>
                                
                                
                                 <div class="col-lg-3 col-md-3">	
								<div class="form-group">
									<label>Markup %*</label>
									<select name="tax_rate" id="tax_rate" class="form-control" required>
										<option value="">Select Markup %</option>
										<?php echo fill_markup_rate($pdo); ?>
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
                                
                                
							<div class="col-lg-6 col-md-6" style="display:none">
								<div class="form-group">
							<label> Selling Price*</label>
							<input type="text" name="product_sp" id="product_sp" class="form-control" required />
						</div>
							</div>
						</div>
                        
                        
                        
                        
						
						
    				</div>
    				<div class="modal-footer">
						<input type="hidden" name="product_id" id="product_id"/>
						<input type="hidden" name="btn_action" id="btn_action" />
    					<input type="submit" name="action" id="action" class="btn btn-info" value="Add" />
    					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    				</div>
    			</div>
    		</form>
    	</div>
    </div>
<?php require_once('footer.php'); ?>

