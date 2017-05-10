<html>
	<head>
		<title>Sign Up</title>
		
		<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="css/styles.css">
		
		<script>
		function ValidateEmail(inputText)  
		{  
			var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/; 

			if(inputText.value.match(mailformat))  
			{    
				return true;  
			}  
			else  
			{  
				inputText.style.color="red";				
				inputText.focus();  
				return false;  
			}  
		}  
		</script>
	</head>
	<body>
		<div align="center" id="container">
			<div id="top">
				<div>
					<img src="img/liveme.gif"/>
				</div>	
				<h1 style="align:center;color:green">Account Help</h1>
				<h2 style="align:center;color:green">Register</h2>
			</div>
			<div id="middle">	
				<form action="ProcessRegister.php" name="regform" method="POST">
					<div class="form-group">
						<input type="text" class="form-control" placeholder="Full Name" id="UserName" name="username" />
					</div>
					<div class="form-group">	
						<input type="text" class="form-control" placeholder="Email" id="UserEmail" name="useremail" onchange="return ValidateEmail(document.regform.useremail)"/>
					</div>	
					<div class="form-group">	
						<input type="text" onfocus="(this.type='date')" onmouseover="(this.type='date')" onmouseout="(this.type='text')" class="form-control" placeholder="Date of Birth" id="UserDOB" name="userdob" style="width:200px"/>
					</div>		
					<div class="form-group">
						<input type="password" class="form-control" placeholder="Password" id="UserPassword" name="userpass" />
					</div>	
					<div class="form-group">
						<input type="radio" placeholder="Male" value="male" name="usergender" checked/>Male
						<input type="radio" value="female" name="usergender" />Female
					</div>	
					<div class="form-group">		
						<button type="submit" class="btn btn-default" id="register-button" type="submit" onclick="return CheckNull()">Register</button>
					</div>	
				</form>
				
				<a href="login.php">To Login Click here</a>
			</div>	
				
			<div id="bottom">	
				<?php require_once('footer.php'); ?>
			</div>
		</div>		
	</body>
</html>