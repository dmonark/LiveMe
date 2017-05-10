<?php
session_start();
if(isset($_SESSION['SesUserID']))
{	
	require_once('dbconfig.php');
	establish_connections(); //This function establishes connection with the database
}
else
	header("location:login.php?NextURL=ContactProfile.php");

function GetContactInfo()
{
	//connection
	global $con;
	
	//session variable
	$UserID = $_SESSION['SesUserID'];
	
	//main function
	$ContactGetQuery = "SELECT ContactInfoSrNo, ContactType, ContactDetails, ContactPrivacy FROM contactinfo WHERE UserID = '$UserID' AND DeleteStatus = '0' ORDER BY ContactInfoSrNo DESC";
	$ContactGetResult = mysqli_query($con, $ContactGetQuery);
	

	while($row = mysqli_fetch_assoc($ContactGetResult))
		$ContactGet[] = $row; 
	
	if(isset($ContactGet))
		return $ContactGet;
}
?>
<html>
	<head>
		<title>Contact Profile</title>
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
			function UpdateContact(ContactID, ContactNumber)
			{
				var type = document.getElementsByClassName('ContactTypeOld')[ContactNumber].value;
				var details = document.getElementsByClassName('ContactDetailsOld')[ContactNumber].value;
				var privacy = document.getElementsByClassName('ContactPrivacyOld')[ContactNumber].value;
			
				var UpdateQuery = "WhichProfile=contact&type="+type+"&details="+details+"&privacy="+privacy+"&ContactID="+ContactID;
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
			function DeleteContact(ContactID, ContactNumber)
			{
				var r = confirm('Are you sure want to delete this contact details');
				if(r == true)
				{
					var DeleteQuery = "ContactID="+ContactID;
					var DeleteURL = "ajax/deleteprofile.php?WhichProfile=contact&"+DeleteQuery;
					
					xmlhttp = CreateXML();
					xmlhttp.open("GET",DeleteURL,true);
					xmlhttp.onreadystatechange = function() 
					{
						if (this.readyState == 4 && this.status == 200) 
						{
							if(xmlhttp.responseText == '1')
							{	
								document.getElementsByClassName('EveryOldProfile')[ContactNumber].style.display="none";
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
					<div class="form-group"><strong>Contact Type</strong></div>
					<div class="form-group">
						<select class="form-control" name="ContactType" id="ContactType">
							<option value="Address">Address</option>
							<option value="Contact">Contact</option>
						</select>
					</div>
					<div class="form-group"><strong>Contact Details</strong></div>
					<div class="form-group">
						<input type="text" class="form-control" id="ContactDetails" name="ContactDetails" required>
					</div>
					<div class="form-group"><strong>Contact Privacy</strong></div>
					<div class="form-group">
						<select class="form-control" name="ContactPrivacy" id="ContactPrivacy">
							<option value="0">Only me</option>
							<option value="1">Only Followers</option>
							<option value="2">Everyone</option>
						</select>
					</div>
					<div class="form-group" style="display:none">
						<input type="text" class="form-control" name="WhichInsert" value="contact">
					</div>
					<div class="form-group">
						<button class="btn btn-default" type="submit">Insert Details</button>
					</div>				
				</form>
				
				
				<br>
				
				
				<h2>Old Details</h2>
				<div id="OldDetails">
				<?php
					
					$ContactInfo = GetContactInfo();
					
					$ConLen = count($ContactInfo);
					
					if($ConLen == 0)
						echo "<p style='color:blue'>Nothing to show</p>";
					else
					{
						for($i=0;$i<$ConLen;$i++)
						{
							?>
							<div class="EveryOldProfile">	
								<div class="form-group"><strong>Contact Details</strong></div>
								<div class="form-group">
									<strong>Type</strong>
									<select class="form-control ContactTypeOld" name="ContactTypeOld">
										<option value="Address" <?php if($ContactInfo[$i]['ContactType'] == 'Address') echo "selected"; ?>>Address</option>
										<option value="Contact" <?php if($ContactInfo[$i]['ContactType'] == 'Contact') echo "selected"; ?>>Contact</option>
									</select>
									<strong>Details</strong>
									<input type="text" class="form-control ContactDetailsOld" name="ContactDetailsOld" value='<?php echo $ContactInfo[$i]['ContactDetails']; ?>' >
									<strong>Privacy</strong>
									<select class="form-control ContactPrivacyOld" name="ContactPrivacyOld">
										<option value="0" <?php if($ContactInfo[$i]['ContactPrivacy'] == '0') echo "selected"; ?>>Only me</option>
										<option value="1" <?php if($ContactInfo[$i]['ContactPrivacy'] == '1') echo "selected"; ?>>Only Followers</option>
										<option value="2" <?php if($ContactInfo[$i]['ContactPrivacy'] == '2') echo "selected"; ?>>Everyone</option>
									</select>
								</div>
								<div class="form-group">
									<button class="btn btn-default" style="color:blue;" <?php echo "onclick='UpdateContact({$ContactInfo[$i]['ContactInfoSrNo']},{$i})'"; ?> type="submit">Update</button>
									<button class="btn btn-default" style="color:red;" <?php echo "onclick='DeleteContact({$ContactInfo[$i]['ContactInfoSrNo']},{$i})'"; ?> type="submit">Delete</button>
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
			<?php	
				require_once('footer.php');
			?>
			</div>		
		</div>
	</body>
</html>	