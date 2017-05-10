<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Login</title>
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
					alert("You have entered an invalid email address!");  
					inputText.focus();  
					return false;  
				}  
			}    
		</script>  
		<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="css/styles.css">
	</head>
	<body>
		<div align="center" class="container">
			<div id="top">
				<div>
					<img src="img/liveme.gif"/>
				</div>	
				<h1>Welcome</h1>
			</div>
			<div id="middle">
				<form action="validate.php" class="form" name="firstform" method="post">
					<fieldset>
						<?php 
						if(isset($_GET['errorcode']))
						{
							echo "<p style='color:red'><strong>Alert!</strong> You have entered wrong.</p>";
						} 
						?>
						<div class="form-group">
							<input type="text" class="form-control" id="useremail" placeholder="Username" name="useremail">
						</div>
						
						<div class="form-group">
							<input type="password" class="form-control" placeholder="Password" name="userpass">
						</div>
							
						<?php 
							if(isset($_GET['NextURL']))
							{
								echo "<div style='display:none' class='form-group'>";
								echo "<input type='text' class='form-control' name='nexturl' value='{$_GET['NextURL']}'>";
								echo "</div>";
							} 
						?>
							
						<div class="form-group">
							<button class="btn btn-default " type="submit" onclick="return ValidateEmail(document.firstform.useremail)">
								<span class="glyphicon glyphicon-log-in"></span>
								Log In
							</button>
						</div>
					</fieldset>				
				</form>
				<a href="forgetpassword.php">Forget</a> your password
				<br>
				<a href="register.php">Register</a> your account
			</div>
			<div id="bottom">	
				<?php require_once('footer.php'); ?>
			</div>
		</div>
	</body>
</html>