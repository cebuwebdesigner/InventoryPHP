<?php
ob_start();
session_start();
require_once("db/config.php");
require_once("db/function_xss.php");
require_once("db/CSRF_Protect.php");
$csrf = new CSRF_Protect();
?>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Admin Panel</title>
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<meta name="description" content="Admin Panel">
	<link rel="stylesheet" href="<?php echo ADMIN_URL; ?>/css/main.css">
	<link rel="stylesheet" href="<?php echo ADMIN_URL; ?>/css/all.min.css">
	<link rel="stylesheet" href="<?php echo ADMIN_URL; ?>/css/custom.css" />
</head>

<body>
<div id="logreg-forms">
			<?php 
					if(! empty($_SESSION['error_message'])){ ?>
						<div  class="alert alert-danger errorMessage">
						<button type="button" class="close float-right" aria-label="Close" >
						  <span aria-hidden="true" id="hide">&times;</span>
						</button>
				<?php
						echo $_SESSION['error_message'] ;
						unset($_SESSION['error_message']);
				?>
						</div>
			<?php } ?>
        	<form action="<?php echo ADMIN_URL; ?>/panel_login.php" class="form-signin" method="post">
				<?php $csrf->echoInputField(); ?>
				<h4 class="d-flex justify-content-center">Admin Login</h4>
				<input type="email" name="email" id="inputEmail" class="form-control" placeholder="Email address" maxlength="50" required autofocus>
				<input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required>
				<button class="btn btn-success btn-block" type="submit"><i class="fas fa-sign-in"></i> Sign in</button>
            </form>
</div>
<script type="text/javascript" src="<?php echo ADMIN_URL; ?>/js/jquery-3.5.1.min.js"></script>
<script type="text/javascript" src="<?php echo ADMIN_URL; ?>/js/errorMsg.js"></script>
</body>
</html>
