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
								<div class="page-heading"> <h6>Manage Tax Slab</h6></div>
								<?php if( ($_SESSION['type']['user_role'] == 'Admin')) { ?><button class="btn btn-info  m-1" id="add_tax"><i class="fa fa-plus-square"></i> Add Tax</button><?php } ?>
							</div> <!-- /panel-heading -->
							<div class="panel-body">
								<div class="remove-messages"></div>
								<div class="row">
									<div class="col-md-12">
									  <div class="tile">
										<div class="tile-body">
											<div class="table-responsive">
												<table class="table table-bordered table-hover" id="manageTaxTable">
													<thead>
														<tr>
															<th>ID</th>	
															<th>Tax %</th>		
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
	<!-- Add Tax Modal -->
	<div id="taxModal" class="modal fade">
    	<div class="modal-dialog">
    		<form method="post" id="tax_form">
    			<div class="modal-content">
    				<div class="modal-header">
						<h4 class="modal-title"><i class="fa fa-plus"></i> Add Tax</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						  <span aria-hidden="true">&times;</span>
						</button>
    				</div>
    				<div class="modal-body">
						<div class="form-group">
							<label>Tax %*</label>
							<input type="text" name="tax_rate" id="tax_rate" class="form-control" required />
						</div>
    				</div>
    				<div class="modal-footer">
						<input type="hidden" name="tax_id" id="tax_id"/>
						<input type="hidden" name="btn_action" id="btn_action" />
    					<input type="submit" name="action" id="action" class="btn btn-info" value="Add" />
    					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    				</div>
    			</div>
    		</form>
    	</div>
    </div>
<?php require_once('footer.php'); ?>

