<?php
if($_POST)
{
	global $con;
	require_once('dbconfig.php');
	establish_connections();
	newuser();               //This function adds the new user

}

function newuser()
{
	//Connection preparation
	global $con;
	
	
	//Variable declaration
	$name = $_POST['username'];
	$email = $_POST['useremail'];
	$dob=$_POST['userdob'];
	$password = $_POST['userpass']; 
	$gender =$_POST['usergender'];
	
	//Output data
	$query = "INSERT INTO userinfo (UserEmail, UserName, UserPassword, UserGender, UserDOB) VALUES ('$email', '$name', '$password','$gender', '$dob')"; 
	
	//Functionality
	if(test_availabilty($email) && mysqli_query($con, $query)) 
	{
		$UserID = mysqli_insert_id($con);
		$OTPsendStatus = CreateOTP($UserID);
		if($OTPsendStatus)
		{
			$_SESSION['SesUserID']=$UserID;
			header("location: CheckOTP.php");
		}
	}
	else
	{
		echo "{$email} this email already has account";
		echo "<br><a href='login.php'>Login</a>";
	}
}


//this function check email in database if its their then say no to new account
function test_availabilty($email)
{
	global $con;
	$query = "SELECT * FROM userinfo WHERE UserEmail='$email'";
	$query_result = mysqli_query($con,$query);
	return !mysqli_fetch_row($query_result)[0];
}

function CreateOTP($UserID)
{
	//connection
	global $con;
	
	$SysOTP = rand(100000,999999);
	$AllReadyQuery = "UPDATE `otpsenddata` SET `OTPStatus`='1' WHERE UserID = '$UserID'";
	$AllReadyResult = mysqli_query($con, $AllReadyQuery);
	
	$Time = localtime();
	$Year = $Time[5]+1900;
	$Month = $Time[4]+1;
	$OTPsendTime = "{$Year}-{$Month}-{$Time[3]} {$Time[2]}:{$Time[1]}:{$Time[0]}";
 	
	$InsertOTPQuery = "INSERT INTO `otpsenddata`(`UserID`, `SysOTP`, `OTPSendTime`, `OTPStatus`, `WhatOTP`) 
						VALUES ('$UserID','$SysOTP','$OTPsendTime','0','0')"; 
	$InsertOTPResult = mysqli_query($con, $InsertOTPQuery);
	
	$email2 = $_POST['useremail'];
	//sendOTPmail($email2, $SysOTP);
	
	if($AllReadyResult && $InsertOTPResult)
		return true;
	else
		return false;
}

//this function will send otp on user mail id to verify
function sendOTPmail($email,$randomSelectOTP)
{
	$mail = new PHPMailer();
	
	$mail->IsSMTP();
	$mail->Host = "smtp.gmail.com";
	$mail->Password = "Password";
	$mail->Port = 587;
	$mail->SMTPAuth = true;
	$mail->SMTPDebug = 1;
	$mail->SMTPSecure = "tls";
	$mail->Username = "janicebing47@gmail.com";
	
	//set from
	$mail->SetFrom("janicebing47@gmail.com");
	
	//set body
	$mail->Body = "Welcome user your OTP is {$randomSelectOTP} check it on our website. go on"; 
	
	//set address
	$mail->addAddress($email);
	
	//mail will send
	$mail->Send();
}

?>