<?php
session_start();
if(isset($_SESSION['SesUserID']))
{	
	require_once('dbconfig.php');
	establish_connections(); //This function establishes connection with the database
}
else
	header("location:login.php?NextURL=EduProfile.php");

function GetEduInfo()
{
	//connection
	global $con;
	
	//session variable
	$UserID = $_SESSION['SesUserID'];

	//main function
	$GetOldEduQuery = "SELECT `EduInfoSrNo`, `InsName`, `EduType`, `InsJoinDate`, `InsEndDate`, `EduDetails`, `EduPrivacy` FROM `eduinfo` WHERE UserID = '$UserID' AND EduDeleteStatus = '0'";
	$GetOldEduResult = mysqli_query($con, $GetOldEduQuery);
	
	while($row = mysqli_fetch_assoc($GetOldEduResult))
		$EduGet[] = $row; 		
	
	if(isset($EduGet))
		return $EduGet;
}
?>
<html>
	<head>
		<title>Edution Profile</title>
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
			function UpdateEdu(EduID, EduNumber)
			{
				console.log('we are in');
				var type = document.getElementsByClassName('EducationTypeOld')[EduNumber].value;
				var name = document.getElementsByClassName('EduInsNameOld')[EduNumber].value;
				var joindate = document.getElementsByClassName('EduJoinDateOld')[EduNumber].value;
				var enddate = document.getElementsByClassName('EduEndDateOld')[EduNumber].value;
				var details = document.getElementsByClassName('EducationDetailsOld')[EduNumber].value;
				var privacy = document.getElementsByClassName('EducationPrivacyOld')[EduNumber].value;
				
				var UpdateQuery = "WhichProfile=education&type="+type+"&name="+name+"&joindate="+joindate+"&enddate="+enddate+"&details="+details+"&privacy="+privacy+"&eduid="+EduID;
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
			function DeleteEdu(EduID, EduNumber)
			{
				var r = confirm('Are you sure want to delete this education details');
				if(r == true)
				{
					var DeleteQuery = "EduID="+EduID;
					var DeleteURL = "ajax/deleteprofile.php?WhichProfile=education&"+DeleteQuery;
				
					xmlhttp = CreateXML();
					xmlhttp.open("GET",DeleteURL,true);
					xmlhttp.onreadystatechange = function() 
					{
						if (this.readyState == 4 && this.status == 200) 
						{
							if(xmlhttp.responseText == '1')
							{	
								console.log('ok');
								document.getElementsByClassName('OldDetailsTable')[EduNumber].style.display="none";
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
				<form action="insertprofile.php" method="POST">
					<div class="form-group"><strong>Education Type</strong></div>
					<div class="form-group">
						<select class="form-control" name="EducationType" id="EducationType">
							<option value="Primary">Primary school</option>
							<option value="High">High school</option>
							<option value="College">College</option>
						</select>
					</div>
					<div class="form-group"><strong>Instituation name</strong></div>
					<div class="form-group">
						<input type="text" class="form-control" id="EduInsName" name="EduInsName" required>
					</div>
					<div class="form-group"><strong>Join Date</strong></div>
					<div class="form-group">	
						<input type="text" onfocus="(this.type='date')" onmouseover="(this.type='date')" onmouseout="(this.type='text')" class="form-control" id="EduJoinDate" name="EduJoinDate" style="width:200px" required/>
					</div>
					<div class="form-group"><strong>End Date</strong></div>
					<div class="form-group">	
						<input type="text" onfocus="(this.type='date')" onmouseover="(this.type='date')" onmouseout="(this.type='text')" class="form-control" id="EduEndDate" name="EduEndDate" style="width:200px"/>
					</div>
					<div class="form-group"><strong>Education Details</strong></div>
					<div class="form-group">
						<input type="text" class="form-control" id="EducationDetails" name="EducationDetails" required>
					</div>
					<div class="form-group" style="display:none">
						<input type="text" class="form-control" name="WhichInsert" value="education">
					</div>
					<div class="form-group"><strong>Education Privacy</strong></div>
					<div class="form-group">
						<select class="form-control" name="EducationPrivacy" id="EducationPrivacy">
							<option value="0">Only me</option>
							<option value="1">Only Followers</option>
							<option value="2">Everyone</option>
						</select>
					</div>
					<div class="form-group">
						<button class="btn btn-default" type="submit">Insert</button>
					</div>
				</form>
				
				<h1>Old Details</h1>
				<div id="OldDetails">
				<?php
					
					$EduInfo = GetEduInfo();
					
					$EduLen = count($EduInfo);
					
					if($EduInfo == 0)
						echo "<p style='color:blue'>Nothing to show</p>";
					else
					{
						for($i=0; $i<$EduLen; $i++)
						{
							?>
							<div class="EveryOldProfile">
								<div class="form-group"><strong>Education Details</strong></div>
								<div class="form-group">
									<strong>Type</strong>
									<select class="form-control EducationTypeOld" name="EducationType" id="EducationType">
										<option value="Primary" <?php if($EduInfo[$i]['EduType']=='Primary') echo "selected"; ?> >Primary school</option>
										<option value="High" <?php if($EduInfo[$i]['EduType']=='High') echo "selected"; ?> >High school</option>
										<option value="College" <?php if($EduInfo[$i]['EduType']=='College') echo "selected"; ?> >College</option>
									</select>
									<strong>Name</strong>
									<input type="text" class="form-control EduInsNameOld" id="EduInsName" value='<?php echo $EduInfo[$i]['InsName']; ?>' name="EduInsName" required>
									<strong>Join Date</strong>
									<input type="text" onfocus="(this.type='date')" onmouseover="(this.type='date')" onmouseout="(this.type='text')" class="form-control EduJoinDateOld" id="EduJoinDate" name="EduJoinDate" style="width:200px" value='<?php echo $EduInfo[$i]['InsJoinDate']; ?>'  required/>
									<strong>End Date</strong>
									<input type="text" onfocus="(this.type='date')" onmouseover="(this.type='date')" onmouseout="(this.type='text')" class="form-control EduEndDateOld" id="EduEndDate" name="EduEndDate" style="width:200px" value='<?php echo $EduInfo[$i]['InsEndDate']; ?>' />
									<strong>Privacy</strong>
									<select class="form-control EducationPrivacyOld" name="EducationPrivacy" id="EducationPrivacy">
										<option value="0" <?php if($EduInfo[$i]['EduPrivacy']=='0') echo "selected"; ?> >Only me</option>
										<option value="1" <?php if($EduInfo[$i]['EduPrivacy']=='1') echo "selected"; ?> >Only Followers</option>
										<option value="2" <?php if($EduInfo[$i]['EduPrivacy']=='2') echo "selected"; ?> >Everyone</option>
									</select>
									<button class="btn btn-default" <?php echo "onclick='UpdateEdu({$EduInfo[$i]['EduInfoSrNo']},{$i})'"; ?> type="submit">Update</button>
									<button class="btn btn-default" <?php echo "onclick='DeleteEdu({$EduInfo[$i]['EduInfoSrNo']},{$i})'"; ?> type="submit">Delete</button>
								</div>
							</div>			
							<br>	
							<?php
						}
					} 
				?>				
				</div>
			</div>
			<div id="bottom">
				<?php require_once('footer.php'); ?>
			</div>
		</div>	
	</body>
</html>