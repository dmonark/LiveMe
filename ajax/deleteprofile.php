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
		
	$WhichProfile = $_GET['WhichProfile'];
	
	if($WhichProfile=='contact')
	{
		$contactid = $_GET['ContactID'];
		
		$UpdateContactQuery = "UPDATE `contactinfo` SET `DeleteStatus`='1' WHERE `UserID` = '$UserID' AND `ContactInfoSrNo` = '$contactid'";
		$UpdateContactResult = mysqli_query($con, $UpdateContactQuery);
		
		if($UpdateContactResult)
			echo "1";
		else
			echo "0";
	}
	elseif($WhichProfile=='education')
	{
		$eduid = $_GET['EduID'];
			
		$DeleteEduQuery = "UPDATE `eduinfo` SET `EduDeleteStatus`='1' WHERE `UserID` = '$UserID' AND `EduInfoSrNo` = '$eduid'";	
		$DeleteEduResult = mysqli_query($con, $DeleteEduQuery);
			
		if($DeleteEduResult)
			echo "1";
		else
			echo "0";
	}
	elseif($WhichProfile == 'postsub')
	{
		$subid = $_GET['SubID'];
		
		$DeleteSubQuery = "UPDATE `postsubject` SET `PostSubDelete`='1' WHERE `UserID` = '$UserID' AND `PostSubSrNo` = '$subid'";
		$DeleteSubResult = mysqli_query($con, $DeleteSubQuery);
		
		if($DeleteSubResult)
			echo "1";
		else
			echo "0";
	}	
}
?>