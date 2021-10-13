<?php 
require_once('headr.php');

$dbhost = 'localhost';

$dbname = 'olivergo_agm' ;

$dbuser = 'olivergo_zach2'; 

$dbpass = 'Ms9@.ph';


 $thedb = 'billing_expenses';



$con = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);    
    

// Check connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  exit();
}
  


if($_POST['op']=="denomination"){
    
    
  
    

                    $timedate = $_POST['order_date'];
                   
    
$deno1000p = strip_tags($_POST['ccq1']);
$deno500p = strip_tags($_POST['ccq2']);
$deno200p = strip_tags($_POST['ccq3']);
$deno100p = strip_tags($_POST['ccq4']);
$deno50p = strip_tags($_POST['ccq5']);
$deno20p = strip_tags($_POST['ccq6']);
$deno10p = strip_tags($_POST['ccq7']);
$deno5p = strip_tags($_POST['ccq8']);
$deno1p = strip_tags($_POST['ccq9']);
$deno25c = strip_tags($_POST['ccq10']);
$notes = strip_tags($_POST['notes']);
    
    
        $total = ($deno25c*.25)+($deno1p*1)+($deno5p*5)+($deno10p*10)+($deno20p*20)+($deno50p*50)+($deno100p*100)+($deno200p*200)+($deno500p*500)+($deno1000p*1000);
    
    
    
                    $enter_by = filter_var($_SESSION['type']['id'], FILTER_SANITIZE_NUMBER_INT) ;
                    $thedb = 'billing_expenses';
    
    
    $result = mysqli_query($con,"INSERT INTO crossaudit (notes,total,deno1000p,deno500p,deno200p,deno100p,deno50p,deno20p,deno10p,deno5p,deno1p,deno25c,crossaudit_time,enter_by) VALUES ('$notes','$total','$deno1000p','$deno500p','$deno200p','$deno100p','$deno50p','$deno20p','$deno10p','$deno5p','$deno1p','$deno25c','$timedate','$enter_by')");
    
    
    


}



?>
	<div class="container-fluid mar-top">
      	<div class="row">
			<div class="col-lg-12 col-md-12">
				<div class="row">
		   			<div class="col-md-12 col-lg-12">
						<div class="panel panel-default">
							<div class="panel-heading">
								<div class="page-heading"> <h6>Manage denomination</h6></div>
								<button class="btn btn-info  m-1" id="add_denomination"><i class="fa fa-plus-square"></i> Add </button>
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
												<table class="table table-bordered table-hover" id="managedenominationTable">
													<thead>
														<tr>
															<th>ID</th>
															<th>1,000.00</th>

      <th>500.00</th>

      <th>200.00</th>

      <th>100.00</th>

      <th>50.00</th>

      <th>20.00</th>

      <th>10.00</th>

      <th>5.00</th>

      <th>1.00</th>

      <th>0.25</th>
                                                            
                                                            <th>TOTAL</th>
                                                            
                                                            
      <th>Enter By</th>
                                                            <th>Notes</th>
															<th>Date</th>
															<!--<th><i class="fa fa-shopping-bag"></i></th>
															<th><i class="fa fa-pencil-alt"></i></th>
															<th><i class="fa fa-ban"></i></th>-->
														</tr>
													</thead>
                                                    
                                                    
                                                    <tbody>
                                                    
                                                    <?php
                                                        
$result = mysqli_query($con,"SELECT * FROM crossaudit");while($row = mysqli_fetch_array($result)) {
$deno1000p = $row['deno1000p'];
$deno500p = $row['deno500p'];
$deno200p = $row['deno200p'];
$deno100p = $row['deno100p'];
$deno50p = $row['deno50p'];
$deno20p = $row['deno20p'];
$deno10p = $row['deno10p'];
$deno5p = $row['deno5p'];
$deno1p = $row['deno1p'];
$deno25c = $row['deno25c'];
$datetime = $row['crossaudit_time'];
$notes = $row['notes'];
    $enter_by = $row['enter_by'];
 
   
      $total = ($deno25c*.25)+($deno1p*1)+($deno5p*5)+($deno10p*10)+($deno20p*20)+($deno50p*50)+($deno100p*100)+($deno200p*200)+($deno500p*500)+($deno1000p*1000);
    
    
    
    $resultmuA = mysqli_query($con,"SELECT * FROM billing_admin WHERE id='$enter_by'"); 
    while($rowmuA = mysqli_fetch_array($resultmuA)) { $expenses_enter_by = $rowmuA['email'];}
  
    
echo '<tr><td>'.$row['crossaudit_id'].'</td><td>'.$deno1000p.'</td><td>'.$deno500p.'</td><td>'.$deno200p.'</td><td>'.$deno100p.'</td><td>'.$deno50p.'</td><td>'.$deno20p.'</td><td>'.$deno10p.'</td><td>'.$deno5p.'</td><td>'.$deno1p.'</td><td>'.$deno25c.'</td><td>'.$total.'</td><td>'.$expenses_enter_by.'</td><td>'.$notes.'</td><td>'.$datetime.'</td></tr>';
    
}
                                                        ?>
                                                    
                                                    </tbody>
                                                    
                                                    
                                                    
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
	<!-- Add denomination Modal -->

	<!-- Add Order Modal -->
	<div id="denominationModal" class="modal fade " data-backdrop="static" data-keyboard="false">
    	<div class="modal-dialog modal-xl">
    			<div class="modal-content">
    				<div class="modal-header">
						<h4 class="modal-title"><i class="fa fa-plus"></i> Add Denomination</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						  <span aria-hidden="true">&times;</span>
						</button>
    				</div>
    				<div class="modal-body">
                        
                   <form method="post" id="expenses_form">
                <input type="hidden" name="op" value="denomination" />
                        
                          
                        
                       
                       <div class="col-lg-10 col-md-10" style="float:left">&nbsp;</div>
                       <div class="col-lg-2 col-md-2" style="float:left">
								<div class="form-group">
									<label>Date</label>
									<input type="text" name="order_date" id="order_date" class="form-control order_date" required="">
								</div>
							</div>
                       
                       
                       
	 <table class="table table-fixed1">
  <thead class="thead-dark">
    <tr style="background-color:#0073E1; color:WHITE; text-align:center">
      <th class="col-xs-4" style="text-align:center">Denomination</th>
      <th class="col-xs-3" style="text-align:left">&nbsp; &nbsp; &nbsp;Qty</th>
      <th class="col-xs-5">Sub Total</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td class="col-xs-5" style="text-align:right; clear:both; padding:4px">1,000.00</td>
<td class="col-xs-2" style="text-align:center;padding:4px"><input type="number" name="ccq1" id="ccq1" style="width:100%" onchange="calcqty('1')" value="<?php echo $deno1000p; ?>" <?php if($status==1){ echo 'readonly'; } ?>/></td>
<td class="col-xs-5" style="text-align:right; padding:4px"><input type="text" name="ccst1" id="ccst1" style="width:100%" value="<?php 

if($deno1000p!=""){echo (int)$deno1000p*1000;}

?>" disabled /></td>
    </tr>
    
     <tr>
      <td class="col-xs-5" style="text-align:right; clear:both; padding:4px">500.00</td>
<td class="col-xs-2" style="text-align:center;padding:4px"><input type="number" name="ccq2" id="ccq2" style="width:100%" onchange="calcqty('2')"  value="<?php echo $deno500p; ?>" <?php if($status==1){ echo 'readonly'; } ?>/></td>
<td class="col-xs-5" style="text-align:right; padding:4px"><input type="text" name="ccst2" id="ccst2" style="width:100%" value="<?php 

if($deno500p!=""){echo (int)$deno500p*500;}

?>"disabled/></td>
    </tr>
    
    <tr>
      <td class="col-xs-5" style="text-align:right; clear:both; padding:4px">200.00</td>
<td class="col-xs-2" style="text-align:center;padding:4px"><input type="number" name="ccq3" id="ccq3" style="width:100%" onchange="calcqty('3')"   value="<?php echo $deno200p; ?>" <?php if($status==1){ echo 'readonly'; } ?>/></td>
<td class="col-xs-5" style="text-align:right; padding:4px"><input type="text" name="ccst3" id="ccst3" style="width:100%" value="<?php 

if($deno200p!=""){echo (int)$deno200p*200;}

?>" disabled/></td>
    </tr>
   <tr>
      <td class="col-xs-5" style="text-align:right; clear:both; padding:4px">100.00</td>
<td class="col-xs-2" style="text-align:center;padding:4px"><input type="number" name="ccq4" id="ccq4" style="width:100%" onchange="calcqty('4')"  value="<?php echo $deno100p; ?>"  <?php if($status==1){ echo 'readonly'; } ?>/></td>
<td class="col-xs-5" style="text-align:right; padding:4px"><input type="text" name="ccst4" id="ccst4" style="width:100%" value="<?php 

if($deno100p!=""){echo (int)$deno100p*100;}

?>" disabled/></td>
    </tr>
   
   
   <tr>
      <td class="col-xs-5" style="text-align:right; clear:both; padding:4px">50.00</td>
<td class="col-xs-2" style="text-align:center;padding:4px"><input type="number" name="ccq5" id="ccq5" style="width:100%" onchange="calcqty('5')"  value="<?php echo $deno50p; ?>"  <?php if($status==1){ echo 'readonly'; } ?>/></td>
<td class="col-xs-5" style="text-align:right; padding:4px"><input type="text" name="ccst5" id="ccst5" style="width:100%" value="<?php 

if($deno50p!=""){echo (int)$deno50p*50;}

?>" disabled/></td>
    </tr>
    
    <tr>
      <td class="col-xs-5" style="text-align:right; clear:both; padding:4px">20.00</td>
<td class="col-xs-2" style="text-align:center;padding:4px"><input type="number" name="ccq6" id="ccq6" style="width:100%" onchange="calcqty('6')"  value="<?php echo $deno20p; ?>"   <?php if($status==1){ echo 'readonly'; } ?>/></td>
<td class="col-xs-5" style="text-align:right; padding:4px"><input type="text" name="ccst6" id="ccst6" style="width:100%" value="<?php 

if($deno20p!=""){echo (int)$deno20p*20;}

?>" disabled/></td>
    </tr>
    
    <tr>
      <td class="col-xs-5" style="text-align:right; clear:both; padding:4px">10.00</td>
<td class="col-xs-2" style="text-align:center;padding:4px"><input type="number" name="ccq7" id="ccq7" style="width:100%" onchange="calcqty('7')"  value="<?php echo $deno10p; ?>"  <?php if($status==1){ echo 'readonly'; } ?>/></td>
<td class="col-xs-5" style="text-align:right; padding:4px"><input type="text" name="ccst7" id="ccst7" style="width:100%" value="<?php 

if($deno10p!=""){echo (int)$deno10p*10;}

?>" disabled/></td>
    </tr>
    
    
    <tr>
      <td class="col-xs-5" style="text-align:right; clear:both; padding:4px">5.00</td>
<td class="col-xs-2" style="text-align:center;padding:4px"><input type="number" name="ccq8" id="ccq8" style="width:100%" onchange="calcqty('8')"  value="<?php echo $deno5p; ?>"  <?php if($status==1){ echo 'readonly'; } ?>/></td>
<td class="col-xs-5" style="text-align:right; padding:4px"><input type="text" name="ccst8" id="ccst8" style="width:100%" value="<?php 

if($deno5p!=""){echo (int)$deno5p*5;}

?>" disabled/></td>
    </tr>
    
    <tr>
      <td class="col-xs-5" style="text-align:right; clear:both; padding:4px">1.00</td>
<td class="col-xs-2" style="text-align:center;padding:4px"><input type="number" name="ccq9" id="ccq9" style="width:100%"  onchange="calcqty('9')"   value="<?php echo $deno1p; ?>" <?php if($status==1){ echo 'readonly'; } ?>/></td>
<td class="col-xs-5" style="text-align:right; padding:4px"><input type="text" name="ccst9" id="ccst9" style="width:100%" value="<?php 

if($deno1p!=""){echo (int)$deno1p*1;}

?>" disabled/></td>
    </tr>
    
    <tr>
      <td class="col-xs-5" style="text-align:right; clear:both; padding:4px">0.25</td>
  <td class="col-xs-2" style="text-align:center;padding:4px"><input type="number" name="ccq10" id="ccq10" style="width:100%" onchange="calcqty('10')"  value="<?php echo $deno25c; ?>"  <?php if($status==1){ echo 'readonly'; } ?>/></td>
<td class="col-xs-5" style="text-align:right; padding:4px"><input type="text" name="ccst10" id="ccst10" style="width:100%" value="<?php 

if($deno25c!=""){echo (int)$deno25c*.25;}

?>" disabled/></td>
    </tr>
    
  </tbody>
</table>

  


<br style="clear:both">
                       
            <div class="row" style="width:100%; margin:0px; padding:0px">           
                       
 <div class="form-group  col-md-7" style="float:left">&nbsp;</div>
  
    <div class="form-group  col-md-5" style="float:left">
    <style>
	.greenok{ color:rgba(0,128,0,1.00)}
	.rednot{ color:#FF0000}
	</style>
    
  <label for="total" class="col-xs-5 col-form-label" id="elemtotal" style="font-size:18px; text-align:right; margin-top:10px">Total</label>
  <div class="col-xs-7" style="padding:0px">
    <input class="form-control" type="text" id="total" name="total" value="<?php echo ($deno25c*.25)+($deno1p*1)+($deno5p*5)+($deno10p*10)+($deno20p*20)+($deno50p*50)+($deno100p*100)+($deno200p*200)+($deno500p*500)+($deno1000p*1000); ?>" disabled>
  </div>
  </div>
                       </div>         
                       
                       
<br style="clear:both">

         <script>
		 

function calcqty(id){
	
	 var amountarr = [0,1000,500,200,100,50,20,10,5,1,0.25];
	 
	 var amountqty = document.getElementById("ccq"+id).value;
	 var theqty = amountarr[id]*parseFloat(amountqty);
	 if (isNaN(theqty)) {theqty=0;}
	 document.getElementById("ccst"+id).value = theqty;
	
	
	
var subtotal=0;
var i;
var stotal;
for(i=1;i<=10;i++)
{ 

 stotal = document.getElementById("ccst"+i).value;

 if (isNaN(stotal)) {stotal=0;}
  if (stotal=="") {stotal=0;}

subtotal = parseFloat(subtotal)+parseFloat(stotal) }

document.getElementById("total").value = subtotal;



var tocheck = document.getElementById('grandtotal').value;
tocheck = parseFloat(tocheck);

var elemtotal = document.getElementById("elemtotal");
  

if(subtotal>=tocheck){
	
	elemtotal.classList.add("greenok");
	elemtotal.classList.remove("rednot");
	
	}else{
	
	elemtotal.classList.remove("greenok");
	elemtotal.classList.add("rednot");
	
	}

}

</script>
         <div class="form-group col-sm-12">
           <label>Notes</label>
                                <input type="text" class="form-control" name="notes" value="<?php echo $notes; ?>"/>
                                </div>
                                
                                
                <div class="form-group col-sm-3" style="display:none">
                                <label>Confirm Code</label>
                                <input type="password" class="form-control" name="concode" />
                                </div>
                                
                                
                                 
                                    
                                 <br atyle="clear:both">
                              <div class="form-group col-sm-12"><button type="submit" class="btn btn-info action_prosingle"> Submit</button><br /><br />&nbsp;<br />&nbsp;</div>
                           
                                  
                                  
              </form>      
     
	<script>
	function submitnow(){
	calall();
	document.getElementById("branchform").submit();
	}
	</script>
            

                        
                        
                        
                        
                        
                        
                        
                        
					</div>
					
    				<div class="modal-footer">
						<input type="hidden" name="singleorderdenomination_id" id="singleorderdenomination_id" class="singleorderdenomination_id"/>
						<input type="hidden" name="btn_action_pro" id="btn_action_prosingle"  class="btn_action_prosingle"/>
    					<!--<input type="submit" name="action_pro" id="action_prosingle" class="btn btn-info action_prosingle" value="Add"  />->
    					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    				</div>
    			</div>
    		</form>
    	</div>
    </div>
<?php require_once('footer.php'); ?>

