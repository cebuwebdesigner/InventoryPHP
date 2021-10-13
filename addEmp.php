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
								<div class="page-heading"> <h6>Manage Employee</h6></div>
								<button class="btn btn-info  m-1" id="add_employee"><i class="fa fa-plus-square"></i> Add Employee</button>
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
												<table class="table table-bordered table-hover" id="manageEmployeeTable">
													<thead>
														<tr>
															<th>ID</th>
															<th>Name</th>
															<th>Employee Name</th>
															<th>Email</th>
															<th>Mobile</th>
															<th>Date</th>
															<th>Tax No.</th>
                                                            <th>SSS</th>
                                                            <th>Pag-ibig</th><th>Id No.</th><th>Salary</th>
															<th>Status</th>
															<th>Enter By</th>
															<th>Role</th>
															<th>Edited By</th>
															<th>Role</th>
															<th><i class="fa fa-shopping-bag"></i></th>
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
	<!-- Add employee Modal -->
	<div id="employeeModal" class="modal fade " data-backdrop="static" data-keyboard="false">
    	<div class="modal-dialog modal-lg">
    		<form method="post" id="employee_form">
    			<div class="modal-content">
    				<div class="modal-header">
						<h4 class="modal-title"><i class="fa fa-plus"></i> Add employee</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						  <span aria-hidden="true">&times;</span>
						</button>
    				</div>
    				<div class="modal-body">
						<div class="row">
							<div class="col-lg-12 col-md-12">
							<small>Email or Mobile at least 1 Field is mandatory</small>
							</div>
							<div class="col-lg-6 col-md-6">
								<div class="form-group">
									<label>Name*</label>
									<input type="text" name="employee_name" id="employee_name" class="form-control" required />
								</div>
							</div>
							<div class="col-lg-6 col-md-6">
								<div class="form-group">
									<label>Email</label>
									<input type="email" name="employee_email" id="employee_email" class="form-control"  />
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6 col-md-6">
								<div class="form-group">
									<label>Mobile</label>
									<input type="text" name="employee_mobile" id="employee_mobile" class="form-control"  />
								</div>
							</div>
							<div class="col-lg-6 col-md-6">
								<div class="form-group">
									<label>TIN <small>(Optional)</small></label>
									<input type="text" name="employee_tax" id="employee_tax" class="form-control" />
								</div>
							</div>
                          
						</div>	
                        
                        <div class="row">
							<div class="col-lg-6 col-md-6">
								<div class="form-group">
									<label>SSS <small>(Optional)</small></label>
									<input type="text" name="employee_sss" id="employee_sss" class="form-control"  />
								</div>
							</div>
							<div class="col-lg-6 col-md-6">
								<div class="form-group">
									<label>PAG-BIG <small>(Optional)</small></label>
									<input type="text" name="employee_pagibig" id="employee_pagibig" class="form-control" />
								</div>
							</div>
                          
						</div>
                        
                        
                          <div class="row">
							<div class="col-lg-6 col-md-6">
								<div class="form-group">
									<label>Company ID No. <small>(Optional)</small></label>
									<input type="text" name="employee_idnum" id="employee_idnum" class="form-control"  />
								</div>
							</div>
							<div class="col-lg-6 col-md-6">
								<div class="form-group">
									<label>Salary <small>(per day/8 hours)</small></label>
									<input type="text" name="employee_salary" id="employee_salary" class="form-control" />
								</div>
							</div>
                          
						</div>	
                        
                        
                        
                         
                        
                        
    				</div>
    				<div class="modal-footer">
						<input type="hidden" name="employee_id" id="employee_id"/>
						<input type="hidden" name="btn_action" id="btn_action" value="Add" />
    					<input type="submit" name="action" id="action" class="btn btn-info" value="Add" />
    					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    				</div>
    			</div>
    		</form>
    	</div>
    </div>
	<!-- Add Order Modal -->
	<div id="singleorderModal" class="modal fade " data-backdrop="static" data-keyboard="false">
    	<div class="modal-dialog modal-xl">
    		<form method="post" id="singleorder_form">
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
									<label>Date*</label>
									<input type="text" name="order_date" id="order_date" class="form-control order_date" required />
								</div>
							</div>
							<div class="col-lg-2 col-md-2">
								<div class="form-group">
									<label>Name*</label>
									<input type="text" name="singleorderemployee_name" id="singleorderemployee_name" class="form-control orderemployee_name" readonly="readonly" required />
								</div>
							</div>
							<div class="col-lg-3 col-md-3">
								<div class="form-group">
									<label>Email</label>
									<input type="email" name="singleorderemployee_email" id="singleorderemployee_email" class="form-control orderemployee_email" readonly="readonly"  />
								</div>
							</div>
							<div class="col-lg-3 col-md-3">
								<div class="form-group">
									<label>Mobile</label>
									<input type="text" name="singleorderemployee_mobile" id="singleorderemployee_mobile" class="form-control orderemployee_mobile" readonly="readonly"  />
								</div>
							</div>
							<div class="col-lg-2 col-md-2">
								<div class="form-group">
									<label>Tax No./ GSTIN</label>
									<input type="text" name="singleorderemployee_tax" id="singleorderemployee_tax" class="form-control orderemployee_tax" readonly="readonly" />
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-3 col-md-3">
								<div class="form-group">
									<label>Discount %</label>
									<input type="text" name="singlediscount" id="singlediscount" class="form-control singlediscount"  />
								</div>
							</div>
							<div class="col-lg-3 col-md-3">
								<div class="form-group">
									<label>Total Amount</label>
									<input type="text" name="singletotalAftertax" id="singletotalAftertax" class="form-control singletotalAftertax" readonly="readonly" />
								</div>
							</div>
							<div class="col-lg-3 col-md-3">
								<div class="form-group">
									<label>Paid Amount</label>
									<input type="text" name="singlepaid" id="singlepaid" class="form-control singlepaid" required/>
								</div>
							</div>
							<div class="col-lg-3 col-md-3">
								<div class="form-group">
									<label>Due Amount</label>
									<input type="text" name="singledue" id="singledue" class="form-control singledue" readonly="readonly"  />
								</div>
							</div>
						<div class="col-lg-12"	>
						<span class="span_singleproduct_details"></span>
						</div>
					</div>
					</div>
					
    				<div class="modal-footer">
						<input type="hidden" name="singleorderemployee_id" id="singleorderemployee_id" class="singleorderemployee_id"/>
						<input type="hidden" name="btn_action_pro" id="btn_action_prosingle"  class="btn_action_prosingle"/>
    					<input type="submit" name="action_pro" id="action_prosingle" class="btn btn-info action_prosingle" value="Add"  />
    					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    				</div>
    			</div>
    		</form>
    	</div>
    </div>
<?php require_once('footer.php'); ?>

