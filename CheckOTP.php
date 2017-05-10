<html>
	<head>
		<title>Enter OTP</title>
		
		<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="css/styles.css">
	
	</head>
	
	<body>
		<div align="center" id="container">
			<div id="top">
				<div>
					<img src="img/liveme.gif"/>
				</div>	
				<h1 style="align:center;color:green">Account Help</h1>
				<h2 style="align:center;color:green">Verify Email</h2>	
			</div>
			
			<div id="middle">	
				<?php
				if(isset($_GET['errorcode']))
				{
					if($_GET['errorcode']==1)
						echo "<p style='color:red'>You have Enter wrong OTP</p>";
				}
				
				?>
				<form action="ProcessOTP.php" method="POST" id="msform">
					<div class="form-group">
						<input type="number" class="form-control" name="userotp" id="frgtemail" placeholder="OPT" />
					</div>
					<button type="submit" class="btn btn-default" id="register-button" type="submit">Register</button>
				</form>
				
				<p align="center" style="color:Green">We sent OTP on your Email ID Check your email !!</p>
			</div>
			
			<div id="bottom">	
				<?php require_once('footer.php'); ?>
			</div>
		</div>	
  </body>
</html>
