<?php include("headr.php") ; ?>

<div class="app-title">
        <div>
          <h1><i class="fa fa-laptop"></i> Dashboard</h1>
          <p>Hassle Free Dashboard to Analysis. </p>
		  <div class="remove-messages"></div>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
        </ul>
 </div>
 <div class="row">
 		<div class="col-lg-12 col-md-12">
				<h5 class="border-bottom text-muted">Today Analysis</h5>
			</div>
        <div class="col-md-6 col-lg-3">
          <div class="widget-small primary coloured-icon"><i class="icon fa fa-shopping-bag fa-3x"></i>
            <div class="info">
              <h5 class="font-italic text-muted">Orders</h5>
              <p><b><?php echo count_total_order_curday($pdo); ?></b></p>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-3">
          <div class="widget-small info coloured-icon"><i class="icon fa fa-bookmark fa-3x"></i>
            <div class="info">
              <h5 class="font-italic text-muted">Sales Amount</h5>
              <p><b><?php echo fetch_currency($pdo)."&ensp;".count_total_order_value_curday($pdo); ?></b></p>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-3">
          <div class="widget-small warning coloured-icon"><i class="icon fa fa-fire fa-3x"></i>
            <div class="info">
              <h5 class="font-italic text-muted">Estd. Earning</h5>
              <p><b><?php echo fetch_currency($pdo)."&ensp;".count_total_orderwithouttax_value_curday($pdo); ?></b></p>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-3">
          <div class="widget-small danger coloured-icon"><i class="icon fa fa-exclamation-circle fa-3x"></i>
            <div class="info">
              <h5 class="font-italic text-muted">Tax</h5>
              <p><b><?php echo fetch_currency($pdo)."&ensp;".count_total_ordertax_value_curday($pdo); ?></b></p>
            </div>
          </div>
        </div>
      </div>
 <div class="row">
 		<div class="col-lg-12 col-md-12">
				<h5 class="border-bottom text-muted">This Month Analysis</h5>
			</div>
        <div class="col-md-6 col-lg-3">
          <div class="widget-small primary coloured-icon"><i class="icon fa fa-shopping-bag fa-3x"></i>
            <div class="info">
              <h5 class="font-italic text-muted">Orders</h5>
              <p><b><?php echo count_total_order_curmonth($pdo); ?></b></p>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-3">
          <div class="widget-small info coloured-icon"><i class="icon fa fa-bookmark fa-3x"></i>
            <div class="info">
              <h5 class="font-italic text-muted">Sales Amount</h5>
              <p><b><?php echo fetch_currency($pdo)."&ensp;".count_total_order_value_curmonth($pdo); ?></b></p>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-3">
          <div class="widget-small warning coloured-icon"><i class="icon fa fa-fire fa-3x"></i>
            <div class="info">
              <h5 class="font-italic text-muted">Estd. Earning</h5>
              <p><b><?php echo fetch_currency($pdo)."&ensp;".count_total_orderwithouttax_value_curmonth($pdo); ?></b></p>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-3">
          <div class="widget-small danger coloured-icon"><i class="icon fa fa-exclamation-circle fa-3x"></i>
            <div class="info">
              <h5 class="font-italic text-muted">Tax</h5>
              <p><b><?php echo fetch_currency($pdo)."&ensp;".count_total_ordertax_value_curmonth($pdo); ?></b></p>
            </div>
          </div>
        </div>
      </div>
	<div class="row">
 		<div class="col-lg-12 col-md-12">
				<h5 class="border-bottom text-muted">Total Analysis</h5>
			</div>
        <div class="col-md-6 col-lg-3">
          <div class="widget-small primary coloured-icon"><i class="icon fa fa-shopping-bag fa-3x"></i>
            <div class="info">
              <h5 class="font-italic text-muted">Orders</h5>
              <p><b><?php echo count_total_order($pdo); ?></b></p>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-3">
          <div class="widget-small info coloured-icon"><i class="icon fa fa-bookmark fa-3x"></i>
            <div class="info">
              <h5 class="font-italic text-muted">Sales Amount</h5>
              <p><b><?php echo fetch_currency($pdo)."&ensp;".count_total_order_value($pdo); ?></b></p>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-3">
          <div class="widget-small warning coloured-icon"><i class="icon fa fa-fire fa-3x"></i>
            <div class="info">
              <h5 class="font-italic text-muted">Estd. Earning</h5>
              <p><b><?php echo fetch_currency($pdo)."&ensp;".count_total_orderwithouttax_value($pdo); ?></b></p>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-3">
          <div class="widget-small danger coloured-icon"><i class="icon fa fa-exclamation-circle fa-3x"></i>
            <div class="info">
              <h5 class="font-italic text-muted">Tax</h5>
              <p><b><?php echo fetch_currency($pdo)."&ensp;".count_total_ordertax_value($pdo); ?></b></p>
            </div>
          </div>
        </div>
      </div>
	  <?php 
	  //table analysis only for admin
	  if($_SESSION['type']['user_role'] == 'Admin') { ?>
	  <div class="app-title mt-4">
        <div>
          <h1><i class="fa fa-th-list"></i> Today Table Analysis</h1>
        </div>
      </div>
	  <div class="row">
        <div class="col-md-12">
          <div class="tile">
            <div class="tile-body">
              <div class="table-responsive">
                <table class="table table-hover table-bordered" id="manageCurrentDayOrderTable">
					<thead>
						<tr>
							<th>ID</th>						
							<th>Email</th>
							<th>Role/Outlet</th>
							<th>Total Orders</th>
							<th>Order Total</th>
						</tr>
					</thead>
				</table>
			  </div>
			</div>
		 </div>
		</div>
	</div>
	
	<div class="app-title mt-4">
        <div>
          <h1><i class="fa fa-th-list"></i> This Month Table Analysis</h1>
        </div>
      </div>
	  <div class="row">
        <div class="col-md-12">
          <div class="tile">
            <div class="tile-body">
              <div class="table-responsive">
                <table class="table table-hover table-bordered" id="manageCurrentMonthOrderTable">
					<thead>
						<tr>
							<th>ID</th>						
							<th>Email</th>
							<th>Role/Outlet</th>
							<th>Total Orders</th>
							<th>Order Total</th>
						</tr>
					</thead>
				</table>
			  </div>
			</div>
		 </div>
		</div>
	</div>
	
	<div class="app-title mt-4">
        <div>
          <h1><i class="fa fa-th-list"></i> Table Analysis from Starting</h1>
        </div>
      </div>
	  <div class="row">
        <div class="col-md-12">
          <div class="tile">
            <div class="tile-body">
              <div class="table-responsive">
                <table class="table table-hover table-bordered" id="manageTotalOrderTable">
					<thead>
						<tr>
							<th>ID</th>						
							<th>Email</th>
							<th>Role/Outlet</th>
							<th>Total Orders</th>
							<th>Order Total</th>
						</tr>
					</thead>
				</table>
			  </div>
			</div>
		 </div>
		</div>
	</div>
	  <?php } ?>

<?php include("footer.php") ; ?>