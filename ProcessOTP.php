<?php
if(isset($_POST['userotp']))
{
	global $con;
	require_once('dbconfig.php');
	establish_connections(); //This function establishes connection with the database
	otpcheck();//This function check user otp and verify email
}

function otpcheck()
{
	//connection 
	global $con;
	
	//Session variable
	$UserID = $_SESSION['SesUserID'];	
	
	//user enter variable
	$UserEnterOTP=$_POST['userotp'];
	$newblock='00';
	
	//system variable
	$OTPQuery = "SELECT SysOTP FROM otpsenddata WHERE UserID = '$UserID' AND OTPStatus = '0' AND WhatOTP = '0'";
	$OTPResult = mysqli_query($con,$OTPQuery);
	if($OTPResult)
	{
		$SysOTP = mysqli_fetch_assoc($OTPResult)['SysOTP'];
		if($SysOTP === $UserEnterOTP)
		{
			$UserBlockStatus = "UPDATE userinfo SET UserBlock = '0' WHERE UserID = '$UserID'";
			$UserBlockResult = mysqli_query($con, $UserBlockStatus);
			
			$OTPStatusQuery = "UPDATE `otpsenddata` SET `OTPStatus`='1' WHERE UserID = '$UserID'";	
			$OTPStatusResult = mysqli_query($con, $OTPStatusQuery);
				
			if($UserBlockResult && $OTPStatusResult)
			{
				header("location:EditProfile.php");
			}				
		}
		else
		{
			
			var_dump($SysOTP);
			var_dump($UserEnterOTP);
			//header("location:CheckOTP.php?errorcode=1");
		}
	}
	else
	{
		var_dump($OTPQuery);
	}
}
?>