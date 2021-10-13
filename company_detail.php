<?php 
require_once('admin_header.php');
?>
<div class="container mar-top">
	<div class="row">
		<div class="col-lg-12 col-md-12">
			<div class="row">
				<div class="col-lg-3 col-md-3"></div>
				<div class="col-lg-6 col-md-6">
					<div class="card">
                		<div class="card-header bg-secondary text-white text-center"><h4> Company Detail</h4></div>
                		<div class="card-body">
							<form method="post" id="company_validation" class="company_validation">
								<div class="form-group">
									<label for="name"><i class="fa fa-address-book text-success"></i> Company Name*</label>
									<input type="text" class="form-control" name="companyname" id="companyname" placeholder="Name" maxlength="50" value="<?php echo $companyName ; ?>" required>
								</div>
								<div class="row">
									<div class="col-lg-6">
										<div class="form-group">
											<label for="email"><i class="fa fa-envelope text-success"></i> Company Email*</label>
											<input type="email" class="form-control" name="companyemail" id="companyemail" placeholder="Company Email" maxlength="100" value="<?php echo $email_old ; ?>" required>
										</div>
									</div>
									<div class="col-lg-6">
										<div class="form-group">
											<label for="phone"><i class="fa fa-phone-square text-success"></i> Company Phone</label>
											<input type="text" class="form-control" name="companyphone" id="companyphone"  placeholder="Company Phone" maxlength="20" value="<?php echo $companyPhone ; ?>">
										</div>
									</div>
								</div>
								
								<div class="form-group">
									<label for="message"><i class="fa fa-comment text-success"></i> Company Tax No.</label>
									<input type="text" class="form-control" name="companytax" id="companytax"  placeholder="Company Tax No" maxlength="20" value="<?php echo $companyTax ; ?>">
								</div>
								<div class="col-md-12 text-center">
									<div class="remove-messages"></div>
									<input type="hidden" name="adminId" value="<?php echo $id ; ?>"  />
									<input type="hidden" name="company_submit_pr" value="Submit" />
									<input type="submit" id="company_submit" name="company_submit" class="btn btn-primary text-center form_submit" value="Update Company Detail" />
								</div>
							</form>
                		</div>
           			 </div>
				</div>
				<div class="col-lg-3 col-md-3"></div>
			</div>
		</div>
	</div>
</div>
<?php require_once('footer.php'); ?>