<?php 
require_once('headr.php');
?>





<div class="container-fluid mar-top" > 
    
     <div class="card-body col-mg-12" style="background-color:#000; color:#fff; padding:20px">  <h4>Login</h4></div>
    
    
                  <div class="row" style="margin-top:30px">
                      
                      
                      
                      
                      
                      
                      <div class="card col-lg-6">
                          
                            <img src="logo.gif" style="width:100%" />
  <div class="card-body">
      
    
      
      
                      <div class="col-md-4 col-xs-12 col-sm-6 col-lg-4" style="float:left">
                       <img alt="User Pic" src="https://c8.alamy.com/comp/MF27R5/los-angeles-california-usa-23rd-april-2018-actor-mark-ruffalo-attends-the-world-premiere-of-disney-and-marvels-avengers-infinity-war-on-april-23-2018-in-los-angeles-california-photo-by-barry-kingalamy-live-news-MF27R5.jpg" id="profile-image1" class="img-circle img-responsive" style="width:100%"> 
                     
                 
                      </div>
                      <div class="col-md-8 col-xs-12 col-sm-6 col-lg-8" style="float:left">
                          <div class="container">
                            <h2>John Doe</h2>
                            <p>an   <b> Employee</b></p>
                          
                           
                          </div>
                           <hr>
                          
                          
                          <div class="col-sm-5 col-xs-6 tital " style="font-size:20px">Time:<br />8:00am</div>
                         <!-- <ul class="container details">
                            <li><p><span class="glyphicon glyphicon-user one" style="width:50px;"></span>i.rudberg</p></li>
                            <li><p><span class="glyphicon glyphicon-envelope one" style="width:50px;"></span>somerandom@email.com</p></li>
                          </ul> -->
                          <hr>
                          <div class="col-sm-5 col-xs-6 tital ">Date:<br />15 Jun 2021</div>
                      </div>
                </div>
            </div>
                      
                      
                      
                      
                      
                      
                      
                      
                      
                      
                      
                      
                  <div class="card col-lg-6">    
                      
                      <canvas id="canvas" width="400" height="400"
style="background-color:#333">
</canvas><br />&nbsp;<br />
                      <center><em>Use the biometric to login (make sure you are already registered on the system)</em></center>
                      </div>
                      
<script>
var canvas = document.getElementById("canvas");
var ctx = canvas.getContext("2d");
var radius = canvas.height / 2;
ctx.translate(radius, radius);
radius = radius * 0.90
setInterval(drawClock, 1000);

function drawClock() {
  drawFace(ctx, radius);
  drawNumbers(ctx, radius);
  drawTime(ctx, radius);
}

function drawFace(ctx, radius) {
  var grad;
  ctx.beginPath();
  ctx.arc(0, 0, radius, 0, 2*Math.PI);
  ctx.fillStyle = 'white';
  ctx.fill();
  grad = ctx.createRadialGradient(0,0,radius*0.95, 0,0,radius*1.05);
  grad.addColorStop(0, '#333');
  grad.addColorStop(0.5, 'white');
  grad.addColorStop(1, '#333');
  ctx.strokeStyle = grad;
  ctx.lineWidth = radius*0.1;
  ctx.stroke();
  ctx.beginPath();
  ctx.arc(0, 0, radius*0.1, 0, 2*Math.PI);
  ctx.fillStyle = '#333';
  ctx.fill();
}

function drawNumbers(ctx, radius) {
  var ang;
  var num;
  ctx.font = radius*0.15 + "px arial";
  ctx.textBaseline="middle";
  ctx.textAlign="center";
  for(num = 1; num < 13; num++){
    ang = num * Math.PI / 6;
    ctx.rotate(ang);
    ctx.translate(0, -radius*0.85);
    ctx.rotate(-ang);
    ctx.fillText(num.toString(), 0, 0);
    ctx.rotate(ang);
    ctx.translate(0, radius*0.85);
    ctx.rotate(-ang);
  }
}

function drawTime(ctx, radius){
    var now = new Date();
    var hour = now.getHours();
    var minute = now.getMinutes();
    var second = now.getSeconds();
    //hour
    hour=hour%12;
    hour=(hour*Math.PI/6)+
    (minute*Math.PI/(6*60))+
    (second*Math.PI/(360*60));
    drawHand(ctx, hour, radius*0.5, radius*0.07);
    //minute
    minute=(minute*Math.PI/30)+(second*Math.PI/(30*60));
    drawHand(ctx, minute, radius*0.8, radius*0.07);
    // second
    second=(second*Math.PI/30);
    drawHand(ctx, second, radius*0.9, radius*0.02);
}

function drawHand(ctx, pos, length, width) {
    ctx.beginPath();
    ctx.lineWidth = width;
    ctx.lineCap = "round";
    ctx.moveTo(0,0);
    ctx.rotate(pos);
    ctx.lineTo(0, -length);
    ctx.stroke();
    ctx.rotate(-pos);
}
</script>
                      
                      
                      
                      
                      
                      
            </div>	<script type="text/javascript">
		</script>


</div>




	<div class="container-fluid mar-top" style="display:none">
      	<div class="row">
			<div class="col-lg-12 col-md-12">
				<div class="row">
		   			<div class="col-md-12 col-lg-12">
						<div class="panel panel-default">
							<div class="panel-heading">
								<div class="page-heading"> 
									
									<div class="row">
										<div class="col-lg-4 col-md-4 ">
											<h3 class="panel-title">Today's Recored</h3>
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
													<table class="table table-bordered table-hover" id="manageOrderTable">
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

