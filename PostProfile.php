<?php
session_start();
if(isset($_SESSION['SesUserID']))
{	
	require_once('dbconfig.php');
	establish_connections(); //This function establishes connection with the database
}
else
	header("location:login.php?NextURL=PostProfile.php");

function GetOldSub()
{
	//connection
	global $con;
	
	//session variable
	$UserID = $_SESSION['SesUserID'];

	//main function
	$GetSubQuery = "SELECT `PostSubSrNo`, `PostSubName`, `PostSubDetails`, `PostSubPrivacy` FROM `postsubject` WHERE UserID = '$UserID' AND PostSubDelete = '0'";
	$GetSubResult = mysqli_query($con, $GetSubQuery);
	
	while($row = mysqli_fetch_assoc($GetSubResult))
		$GetSub[] = $row;
	
	if(isset($GetSub))
		return $GetSub;
}
?>
<html>
	<head>
		<title>Post Profile</title>
		
		<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="css/styles.css">
		
		
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
			function UpdateSub(PostSubID, PostSubNumber)
			{
				var name = document.getElementsByClassName('SubNameOld')[PostSubNumber].value;
				var details = document.getElementsByClassName('SubDetailsOld')[PostSubNumber].value;
				var privacy = document.getElementsByClassName('SubPrivacyOld')[PostSubNumber].value;
			
				var UpdateQuery = "WhichProfile=postsub&name="+name+"&details="+details+"&privacy="+privacy+"&SubID="+PostSubID;
				var UpdateURL = "ajax/updateprofile.php?"+UpdateQuery;
				
				console.log('we are in');
				xmlhttp = CreateXML();
				xmlhttp.open("GET",UpdateURL,true);
				xmlhttp.onreadystatechange = function() 
				{
					console.log('inside');
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
			function DeleteSub(PostSubID, PostSubNumber)
			{
				var r = confirm('Are you sure want to delete this subject details');
				if(r == true)
				{
					var DeleteQuery = "SubID="+PostSubID;
					var DeleteURL = "ajax/deleteprofile.php?WhichProfile=postsub&"+DeleteQuery;
					
					xmlhttp = CreateXML();
					xmlhttp.open("GET",DeleteURL,true);
					xmlhttp.onreadystatechange = function() 
					{
						if (this.readyState == 4 && this.status == 200) 
						{
							if(xmlhttp.responseText == '1')
							{	
								console.log('ok');
								document.getElementsByClassName('OldDetailsTable')[PostSubNumber].style.display="none";
							}
							else
								alert('Something went wrong');
						}
					};
					xmlhttp.send(null);
				}
			}
		</script>
	
	</head>
	<body>
		<div id="container" align="center">
			<div id="top">	
				<?php require_once('header.php'); ?>
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
				<form action="insertprofile.php" method="POST">
					<fieldset>
						<div class="form-group">Subject Name</div>
						<div class="form-group">
							<input type="text" class="form-control" name="SubName" required>
						</div>
						<div class="form-group">Subject Details</div>
						<div class="form-group">
							<input type="text" class="form-control"	 name="SubDetails" required>
						</div>
						<div class="form-group" style="display:none">
							<input type="text" class="form-control" name="WhichInsert" value="postsub">
						</div>
						<div class="form-group">Subject Privacy</div>
						<div class="form-group">
							<select class="form-control" name="SubPrivacy" id="SubPrivacy">
								<option value="0">Only me</option>
								<option value="1">Only Followers</option>
								<option value="2">Everyone</option>
							</select>
						</div>
						<div class="form-group">
							<button class="btn btn-default" type="submit">Insert Details</button>
						</div>
					</fieldset>		
				</form>	
				
				<h1>Old details</h1>
				<?php
				
					$GetSub = GetOldSub();
					
					$GetSubLen = count($GetSub);
					
					if($GetSub == 0)
						echo "<p style='color:blue'>Nothing to show</p>";
					else
					{
						for($i=0; $i<$GetSubLen; $i++)
						{
							?>
								<table class="OldDetailsTable">
									<tr>
										<td><div class="form-group"><strong>Subject Name</strong></div></td>
										<td>
											<div class="form-group">
												<input type="text" class="form-control SubNameOld" value="<?php echo $GetSub[$i]['PostSubName'] ?>">
											</div>
										</td>
									</tr>
									<tr>
										<td><div class="form-group"><strong>Subject Details</strong></div></td>
										<td>
											<div class="form-group">
												<input type="text" class="form-control SubDetailsOld" value="<?php echo $GetSub[$i]['PostSubDetails'] ?>">
											</div>
										</td>
									</tr>
									
									<tr>
										<td><div class="form-group"><strong>Education Privacy</strong></div></td>
										<td>
											<div class="form-group">
												<select class="form-control SubPrivacyOld">
													<option value="0" <?php if($GetSub[$i]['PostSubPrivacy']=='0') echo "selected"; ?> >Only me</option>
													<option value="1" <?php if($GetSub[$i]['PostSubPrivacy']=='1') echo "selected"; ?> >Only Followers</option>
													<option value="2" <?php if($GetSub[$i]['PostSubPrivacy']=='2') echo "selected"; ?> >Everyone</option>
												</select>
											</div>
										</td>
									</tr>
									
									<tr>
										<td align="center" colspan="2">
											<div class="form-group">
												<button class="btn btn-default" <?php echo "onclick='UpdateSub({$GetSub[$i]['PostSubSrNo']},{$i})'"; ?> type="submit">Update</button>
												<button class="btn btn-default" <?php echo "onclick='DeleteSub({$GetSub[$i]['PostSubSrNo']},{$i})'"; ?> type="submit">Delete</button>
											</div>
										</td>
									</tr>
								</table>
								<br>
							<?php		
						}
					}
				?>	
			</div>
			<div id="bottom">
				<?php require_once('footer.php');?>
			</div>
		</div>
	</body>	
</html>