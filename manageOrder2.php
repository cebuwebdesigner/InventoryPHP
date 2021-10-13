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
											<h3 class="panel-title">Manage Service</h3>
										</div>
										<div class="col-lg-8 col-md-8 ">
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
													<table class="table table-bordered table-hover" id="manageOrderTable2">
														<thead>
															<tr>
																<th>Order ID</th>
																<th>Order Date</th>							
																<th>Customer Name</th>
																<th>Created By</th>
																<th>Edited By</th>
																<th>Item Details</th>
																<th>Order Total</th>
																<th>Discount %</th>
																<th>Paid Amount</th>
																<th>Download</th>
																<th>Due Amount</th>
																<th>Order Status</th>
																<th>Due Status</th>
																<th><i class="fa fa-pencil-alt"></i></th>
																<th><i class="fa fa-ban"></i></th>
                                                                
                                                                
															</tr>
														</thead>
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
	<!-- Add Order Modal -->
	<div id="editorderModal" class="modal fade " data-backdrop="static" data-keyboard="false">
    	<div class="modal-dialog modal-xl">
    		<form method="post" id="editorder_form">
    			<div class="modal-content">
    				<div class="modal-header">
						<h4 class="modal-title"><i class="fa fa-plus"></i> Edit Order</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						  <span aria-hidden="true">&times;</span>
						</button>
    				</div>
    				<div class="modal-body">
						<div class="row">
							<div class="col-lg-3 col-md-3">
								<div class="form-group">
									<label>Name*</label>
									<input type="text" name="editordercustomer_name" id="editordercustomer_name" class="form-control" readonly="readonly" required />
								</div>
							</div>
							<div class="col-lg-3 col-md-3">
								<div class="form-group">
									<label>Email</label>
									<input type="email" name="editordercustomer_email" id="editordercustomer_email" class="form-control" readonly="readonly"  />
								</div>
							</div>
							<div class="col-lg-2 col-md-2">
								<div class="form-group">
									<label>Mobile</label>
									<input type="text" name="editordercustomer_mobile" id="editordercustomer_mobile" class="form-control" readonly="readonly"  />
								</div>
							</div>
							<div class="col-lg-2 col-md-2">
								<div class="form-group">
									<label>Tax No./ GSTIN</label>
									<input type="text" name="editordercustomer_tax" id="editordercustomer_tax" class="form-control" readonly="readonly" />
								</div>
							</div>
							<div class="col-lg-2 col-md-2">
								<div class="form-group">
									<label>Date</label>
									<input type="text" name="order_date" id="order_date" class="form-control order_date" required />
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-3 col-md-3">
								<div class="form-group">
									<label>Discount %</label>
									<input type="text" name="editdiscount" id="editdiscount" class="form-control"  />
								</div>
							</div>
							<div class="col-lg-3 col-md-3">
								<div class="form-group">
									<label>Total Amount</label>
									<input type="text" name="edittotalAftertax" id="edittotalAftertax" class="form-control" readonly="readonly" />
								</div>
							</div>
							<div class="col-lg-3 col-md-3">
								<div class="form-group">
									<label>Paid Amount</label>
									<input type="text" name="editpaid" id="editpaid" class="form-control" required/>
								</div>
							</div>
							<div class="col-lg-3 col-md-3">
								<div class="form-group">
									<label>Due Amount</label>
									<input type="text" name="editdue" id="editdue" class="form-control" readonly="readonly"  />
								</div>
							</div>
						<div class="col-lg-12"	>
						<span class="span_editproduct_details"></span>
						</div>
					</div>
					</div>
					
    				<div class="modal-footer">
						<input type="hidden" name="order_id" id="order_id"/>
						<input type="hidden" name="btn_action_pro" class="btn_action_pro" />
    					<input type="submit" name="action_pro" id="action_pro" class="action_pro btn btn-info" value="Edit Order"  />
    					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    				</div>
    			</div>
    		</form>
    	</div>
    </div>
	<!-- Add Due Amount Modal -->
	<div id="dueamountModal" class="modal fade " data-backdrop="static" data-keyboard="false">
    	<div class="modal-dialog modal-md">
    		<form method="post" id="dueamount_form">
    			<div class="modal-content">
    				<div class="modal-header">
						<h4 class="modal-title"><i class="fa fa-plus"></i> Clear Due Amount</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						  <span aria-hidden="true">&times;</span>
						</button>
    				</div>
					<div class="modal-body">
							<div class="form-group">
								<label>Due Amount</label>
								<input type="text" name="dueamount" id="dueamount" class="form-control" readonly="readonly"  />
							</div>
						
					</div>
					<div class="modal-footer">
						<input type="hidden" name="dueorder_id" id="dueorder_id" />
						<input type="hidden" name="order_totalamt" id="order_totalamt" />
						<input type="hidden" name="btn_action_pro" id="btn_actionpro_dueamt" />
    					<input type="submit" name="action_pro_dueamt" id="action_pro_dueamt" class="action_pro_dueamt btn btn-info" value="Clear Due Amount"  />
    					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    				</div>
    			</div>
    		</form>
    	</div>
    </div>
<?php require_once('footer.php'); ?>

