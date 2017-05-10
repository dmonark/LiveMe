<?php
session_start();
if(isset($_SESSION['SesUserID']))
{
	global $con;
	require_once('../dbconfig.php');
	establish_connections(); //This function establishes connection with the database
	updateprofile();
}
else
	die("You have no permission on this page right now");

function updateprofile()
{
	//connection
	global $con;
		
	//session
	$UserID = $_SESSION['SesUserID'];
	
	//normal
	$WhichProfile = $_GET['WhichProfile'];
	
	if($WhichProfile=='personal')
	{
		//normal
		$name = $_GET['Name'];
		$dob = $_GET['DOB'];
		$gender = $_GET['Gender'];
		
		$UpdatePersonalQuery = "UPDATE `userinfo` SET `UserName`='$name', `UserGender`='$gender', `UserDOB`='$dob' WHERE UserID = '$UserID'";
		$UpdatePersonalResult = mysqli_query($con, $UpdatePersonalQuery);
		if($UpdatePersonalResult)
			echo "1";
		else
			echo "0";
	}
	elseif($WhichProfile=='contact')
	{
		$type = $_GET['type'];
		$details = $_GET['details'];
		$privacy = $_GET['privacy'];
		$contactid = $_GET['ContactID'];
		
		$UpdateContactQuery = "UPDATE `contactinfo` SET `ContactType`='$type',`ContactDetails`='$details',`ContactPrivacy`='$privacy' 
							WHERE UserID = '$UserID' AND ContactInfoSrNo = '$contactid'";
		
		$UpdateContactResult = mysqli_query($con, $UpdateContactQuery);
		
		if($UpdateContactResult)
			echo "1";
		else
			echo "0";
	}
	elseif($WhichProfile=='education')
	{
		$type = $_GET['type'];
		$name = $_GET['name']; 
		$joindate = $_GET['joindate'];
		$enddate = $_GET['enddate'];
		$details = $_GET['details'];
		$privacy = $_GET['privacy'];
		$eduid = $_GET['eduid'];
		
		$UpdateEduQuery = "UPDATE `eduinfo` SET `InsName`='$name',`EduType`='$type',`InsJoinDate`='$joindate',`InsEndDate`='$enddate',`EduDetails`='$details',`EduPrivacy`='$privacy' 
							WHERE `UserID` = '$UserID' AND EduInfoSrNo = '$eduid'";
		$UpdateEduResult = mysqli_query($con, $UpdateEduQuery);
		
		if($UpdateEduResult)
			echo "1";
		else
			echo "0";
	}
	elseif($WhichProfile == 'postsub')
	{
		$name = $_GET['name'];
		$details = $_GET['details'];
		$privacy = $_GET['privacy'];
		$subid = $_GET['SubID'];
		
		$UpdateSubQuery = "UPDATE `postsubject` SET `PostSubName`='$name',`PostSubDetails`='$details',`PostSubPrivacy`='$privacy' 
						WHERE UserID = '$UserID' AND PostSubSrNo = '$subid'";
		$UpdateSubResult = mysqli_query($con, $UpdateSubQuery);
		
		if($UpdateSubResult)
			echo "1";
		else
			echo "0";
	}
}
?>