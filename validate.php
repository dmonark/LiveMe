<?php
if(isset($_POST['useremail']))
{
	session_start();
	global $con;
	require_once('dbconfig.php');
	establish_connections();
	login_check();
}
else
{
	header("location:login.php");
}

function login_check()
{
	//variable
	$email = $_POST['useremail'];
	$password = $_POST['userpass']; 
	
	//connection
	global $con;
	
	//validate input
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
	{
		die("Invalid address"); 
	}
	
	//Login fetching part
	$check = 0;
	$query = "SELECT * FROM userinfo WHERE UserPassword='$password' AND UserEmail='$email'";
	$result = mysqli_query($con,$query);
	
	if($result)
	{ 
		while($row=mysqli_fetch_assoc($result))
		{
			if($email==$row['UserEmail']&& $password==$row['UserPassword'])
			{
				$id=$row['UserID'];
				$blockStatus=$row['UserBlock'];
				$check=1;
				ipDetailsFetch($id, $blockStatus);
			}
		}
	}
		
			
	if($check==0)
	{
		if(isset($_POST['nexturl']))
		{
			$nexturl = $_POST['nexturl'];
			header("location:login.php?errorcode=1&NextURL={$nexturl}");
		}
		else
		{
			header("location:login.php?errorcode=1");
		}
	}
	
	else if($check == 1)
	{
		if($blockStatus == 1)
		{	
			$_SESSION['SesUserID']=$id;
			header("location:CheckOTP.php");
		}
		else if($blockStatus==0)
		{
			$_SESSION['SesUserID'] = $id;
			if(isset($_POST['nexturl']))
			{
				$nexturl = $_POST['nexturl'];
				header("location:{$nexturl}");
			}
			else
				header("location:Newsfeed.php");
		}
		else if($blockStatus==2)
		{
			echo "You are block on this website";
		}
	}
}

function ipDetailsFetch($id)//this function will enter ip and userid into databse on every time you login
{
	//connection
	global $con;
	
	//$IPaddress = $_SERVER['REMOTE_ADDR'];
	$IPaddress = '27.251.37.55';
	
	$Time = localtime();
	$Year = $Time[5]+1900;
	$Month = $Time[4]+1;
	$LoginTime = "{$Year}-{$Month}-{$Time[3]} {$Time[2]}:{$Time[1]}:{$Time[0]}";
 	
	$IPinsertQuery = "INSERT INTO `logindetails`( `UserID`, `IP`, `LoginTime`) VALUES ('$id', '$IPaddress', '$LoginTime')";
	$IPresult = mysqli_query($con, $IPinsertQuery);
	if($IPresult)
		echo "ok";
}
?>