<?php 
include("headr.php") ;
?>
<div class="app-title">
  <div>
    <h1><i class="fa fa-th-list"></i> Productwise Sale Analysis</h1>
  </div>
  <div class="row">
					<form  method="post" enctype="multipart/form-data" class="form-inline" id="productwiseSale_form">
						<div class="form-group mx-sm-3 mb-2">
							<label for="order_date" class="sr-only">Start Date</label>
							<input type="text" class="form-control order_date" id="datewise_startdate" name="datewise_startdate" placeholder="Start Date" required>
						</div>
						<div class="form-group mx-sm-3 mb-2">
							<label for="order_date" class="sr-only">End Date</label>
							<input type="text" class="form-control order_date" id="datewise_enddate" name="datewise_enddate" placeholder="End Date" required>
						</div>
							<input type="hidden" name="productwise_action_pro" class="productwise_action_pro" value="fetchProductwiseOrder" />
							<input type="submit" name="productwise_action" id="productwise_action" class="btn btn-info mb-2" value="Show" >
					</form>
	</div>
</div>

<div class="row mar-top-auto productwiseSale">
			<div class="col-lg-12 col-md-12">
				<div class="row">
		   			<div class="col-md-12 col-lg-12">
						<div class="panel panel-default">
							<div class="panel-heading">
								<div class="page-heading"> <h6>Productwise Sale</h6></div>
							</div> <!-- /panel-heading -->
							<div class="panel-body">
								<div class="row">
									<div class="col-md-12">
									  <div class="tile">
										<div class="tile-body">
											<div class="table-responsive">
													<table class="table table-bordered table-hover" id="manageproductwiseSale">
														<thead>
															<tr>
																<th>Product ID</th>						
																<th>Product Name</th>
																<th>Product SKU Code</th>
																<th>No. of Product Sale</th>
																<th>Total Sales Amount</th>
																<th>Estimated Earning</th>
																<th>Total Tax</th>
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

<?php include("footer.php") ; ?>