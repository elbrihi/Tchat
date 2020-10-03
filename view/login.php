<?php

require('../app/classLoad.php');
require('header.php');
session_start();
ini_set('display_errors', 1); 
//session_start();defrf

//session_destroy();
?>
<html>
	<head>
		<title>Inventory Management System using PHP with Ajax Jquery</title>		
		<script src="../public/js/jquery-1.10.2.min.js"></script>
		<link rel="stylesheet" href="../public/css/bootstrap.min.css" />
		<script src="../public/js/bootstrap.min.js"></script>
	</head>
	<body>
		<br />
		<div class="container">
			<h2 align="center"></h2>
			<br />
			<div class="panel panel-default">
				<div class="panel-heading">Login</div>
				<div class="panel-body">
					<form method="post" action="../app/Dispatcher.php">
						<?php //echo $message; ?>
						<div class="form-group">
							<label>User Email</label>
							<input type="text" name="login" class="form-control" required />
						</div>
						<div class="form-group">
							<label>Password</label>
							<input type="password" name="password" class="form-control" required />
						</div>
						<div class="form-group">
							<input type="submit" name="buttom" value="Login" class="btn btn-info" />
						</div>
						
                        <input type="hidden" name="action" value="login" />
                        <input type="hidden" name="source" value="user" />
					</form>
				</div>
			</div>
		</div>
	</body>
</html>


