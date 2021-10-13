<?php 
require_once('admin_header.php');
?>
<div class="container mar-top">
	<div class="row">
		<div class="col-lg-12 col-md-12">
			<div class="row">
				<div class="col-lg-4 col-md-4"></div>
				<div class="col-lg-4 col-md-4 text-center">
					<div class="tile">
						<h3 class="tile-title justify-content-center text-muted">Update Currency</h3>
						<div class="tile-body">
							<form method="post" id="currency_form">
						<div class="remove-messages"></div>
						<div class="col-md-12">
						<select name="currency" id="currency" class="form-control currency_selectpicker" data-live-search="true"   data-dropup-auto="false" data-size="5"  required>
							<option value="">Select Currency</option>
							<?php
								$currency = $pdo->prepare("select * from world_currencies where 1");
								$currency->execute();
								$result_currency = $currency->fetchAll(PDO::FETCH_ASSOC);
								foreach($result_currency as $cur) {
									$c = _e($cur['symbol_hex']);
									$currency_id = _e($cur['world_currency_id']) ;
									$chunks = str_split($c, 5);
									$res= implode('&#x', $chunks);
									$currency_name = "&#X".$res ;
									$currency_status = _e($cur['currency_status']) ;
									$currency_language = _e($cur['langEN']) ;
									?>
									<option value="<?php echo $currency_id ; ?>" <?php if($currency_status == 1) { echo "selected" ; } ?> ><?php echo $currency_language."&ensp;".$currency_name ; ?></option>
									<?php
								}
							?>
						</select>
						</div>
						<br />
						<div class="col-md-12">
						<input type="hidden" name="btn_action_currency" id="btn_action_currency" />
						<input type="submit" name="action_currency" id="action_currency" class="btn btn-info" value="Update" />
						</div>
					</form>
						</div>
					</div>
				</div>
				<div class="col-lg-4 col-md-4"></div>
			</div>
		</div>
	</div>
</div>
<?php require_once('footer.php'); ?>