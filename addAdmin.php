<?php 
require_once('headr.php');
?><?php 
//require_once('admin_header.php');
?>
	<div class="container-fluid mar-top">
      	<div class="row">
			<div class="col-lg-12 col-md-12">
				<div class="row">
		   			<div class="col-md-12 col-lg-12">
						<div class="panel panel-default">
							<div class="panel-heading">
								<div class="page-heading"> <h6>Manage Admin</h6></div>
								<button class="btn btn-info  m-1" id="add_admin"><i class="fa fa-plus-square"></i> Add Admin</button>
							</div> <!-- /panel-heading -->
							<div class="panel-body">
								<div class="remove-messages"></div>
								<div class="row">
									<div class="col-md-12">
								  		<div class="tile">
											<div class="tile-body">
												<div class="table-responsive">
													<table class="table table-bordered table-hover" id="manageAdminTable">
														<thead>
															<tr>
																<th>ID</th>						
																<th>Email</th>
																<th>Role</th>
																<th>Status</th>
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
	<!-- Add Admin Modal -->
	<div id="adminModal" class="modal fade">
    	<div class="modal-dialog">
    		<form method="post" id="admin_form">
    			<div class="modal-content">
    				<div class="modal-header">
						<h4 class="modal-title"><i class="fa fa-plus"></i> Add New Admin</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						  <span aria-hidden="true">&times;</span>
						</button>
    				</div>
    				<div class="modal-body">
						<div class="form-group">
							<label>Admin Email*</label>
							<input type="text" name="email" id="email" class="form-control" required />
						</div>
						<div class="form-group">
						<small>Password must contain minimum 8 characters, 1 Uppercase character, 1 Lowercase character & 1 number.</small><br>
							<label>Admin Password*</label>
							<input type="password" name="password" id="password" class="form-control" required />
						</div>
						<div class="form-group">
							<label>Admin Confirm Password*</label>
							<input type="text" name="repassword" id="repassword" class="form-control" required />
						</div>
    					<div class="form-group">
							<label>Role*</label>
    						<select name="role" id="role" class="form-control" required>
								<option value="Admin">Admin</option>
							</select>
    					</div>
    				</div>
    				<div class="modal-footer">
						<input type="hidden" name="btn_action" id="btn_action" />
    					<input type="submit" name="action" id="action" class="btn btn-info" value="Add" />
    					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    				</div>
    			</div>
    		</form>
    	</div>
    </div>
<?php require_once('footer.php'); ?>

