<?php 
require_once('admin_header.php');
?>

<script>
$(document).ready(function() {
        
    alert("debug");
        
    }
</script>

	<div class="container-fluid mar-top">
      	<div class="row">
			<div class="col-lg-12 col-md-12">
				<div class="row">
		   			<div class="col-md-12 col-lg-12">
						<div class="panel panel-default">
							<div class="panel-heading">
								<div class="page-heading"> <h6>Manage Category</h6></div>
								<?php if( ($_SESSION['type']['user_role'] == 'Admin')) { ?><button class="btn btn-info  m-1" id="add_category"><i class="fa fa-plus-square"></i> Add Category</button> <?php } ?>
							</div> <!-- /panel-heading -->
							<div class="panel-body">
								<div class="remove-messages"></div>
								<div class="row">
									<div class="col-md-12">
									  <div class="tile">
										<div class="tile-body">
											<div class="table-responsive">
												<table class="table table-bordered table-hover" id="manageLogTable">
													<thead>
														<tr>
															<th>ID</th>						
															<th>Category Name</th>
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
	<!-- Add Category Modal -->

<?php require_once('footer.php'); ?>

