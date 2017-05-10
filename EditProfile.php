<?php
session_start();
if(isset($_SESSION['SesUserID']))
{	
	require_once('dbconfig.php');
	establish_connections(); //This function establishes connection with the database
}
else
	header("location:login.php?NextURL=EditProfile.php");
	
function GetOldDetails()
{
	//connection
	global $con;
	
	//session variable
	$UserID = $_SESSION['SesUserID'];
	
	
	//main function
	$GetOldInfoQuery = "SELECT UserName, UserGender, UserDOB FROM userinfo WHERE UserID = '$UserID'";
	$GetOldInfo = mysqli_fetch_assoc(mysqli_query($con, $GetOldInfoQuery));
	
	return $GetOldInfo;
}


?>
<html>
	<head>
		<title>Edit Profile</title>
		
		<link rel="stylesheet" type="text/css" href="css/styles.css">
		<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
		
		<script>
			function CreateXML()
			{
				if (window.XMLHttpRequest) 
				{	
					// code for IE7+, Firefox, Chrome, Opera, Safari
					xmlhttp = new XMLHttpRequest();
				} 
				else 
				{
					// code for IE6, IE5
					xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
				}
				return xmlhttp;
			}
			function UpdatePersonalProfile()
			{
				var name = document.getElementById('username').value;
				var dob =  document.getElementById('userdob').value;
				var gender = document.getElementById('usergender').value;
			
				var UpdateQuery = "WhichProfile=personal&Name="+name+"&DOB="+dob+"&Gender="+gender;
				var UpdateURL = "ajax/updateprofile.php?"+UpdateQuery;
				
				xmlhttp = CreateXML();
				xmlhttp.open("GET",UpdateURL,true);
				xmlhttp.onreadystatechange = function() 
				{
					if (this.readyState == 4 && this.status == 200) 
					{
						if(xmlhttp.responseText == '1')
							console.log('ok');
						else
							console.log('not ok');
					}
				};
				xmlhttp.send(null);
			}
		</script>
	</head>
	
	<body>
		<div align="center" id="container">
			<?php require_once('header.php'); ?>
			<div id="top">	
				<div id="ProfileNav">
					<ul class="nav nav-pills">
						<li><a href="EduProfile.php">Education Info</a></li>
						<li><a href="ContactProfile.php">Contact Info</a></li>
						<li><a href="EditProfile.php">Personal Info</a></li>
						<li><a href="PostProfile.php">Post Profile</a></li>
					</ul>
				</div>
			</div>
			<div id="middle">	
				<?php
					$GetInfo = GetOldDetails();
				?>
				<fieldset>
					<div class="form-group"><strong>Name</strong></div>
					<div class="form-group">
						<input type="text" class="form-control" name="username" id="username" value='<?php echo $GetInfo['UserName']; ?>' >
					</div>
					<div class="form-group"><strong>Date Of Birth</strong></div> 
					<div class="form-group">
						<input type="text" value='<?php echo $GetInfo['UserDOB']; ?>' onfocus="(this.type='date')" onmouseover="(this.type='date')" onmouseout="(this.type='text')" class="form-control" id="userdob" name="userdob" style="width:200px" />	
					</div>
					<div class="form-group">
						Male <input type="radio" value="male" id="usergender" name="usergender" <?php if($GetInfo['UserGender']=="male") echo "checked" ?> >
						Female <input type="radio" value="female" id="usergender" name="usergender" <?php if($GetInfo['UserGender']=="female") echo "checked" ?> >
					</div>
					<div class="form-group">
						<button class="btn btn-default" onclick="UpdatePersonalProfile()" type="submit">Update</button>
					</div>
				</fieldset>	
				<h3>Profile picture</h3>
				<form enctype="multipart/form-data" action="insertprofile.php" method="POST">
					<fieldset>
						<div class="form-group">
							<input class="form-control" type="file" name="fileToUpload">
						</div>	
						<div class="form-group" style="display:none">
							<input type="text"  value="photo" name="WhichInsert" style="width:100px" required>
						</div>	
						<div class="form-group">
							<button class="btn btn-default" type="submit">Upload</button>
						</div>
					</fieldset>
				</form>
			</div>
			<div id="bottom">	
				<?php require_once('footer.php'); ?>
			</div>
		</div>	
	</body>
</html>