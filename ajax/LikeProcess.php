<?php
session_start();
if(isset($_SESSION['SesUserID']))
{
	global $con;
	require_once('../dbconfig.php');
	establish_connections(); //This function establishes connection with the database
	LikePrs();
}
else
	die("You have no permission on this page right now");

function LikePrs()
{
	//connection
	global $con;
	
	//session variable
	$UserID = $_SESSION['SesUserID'];
	
	//get variable
	$WhichProcess = $_GET['WhatProcess'];
	if($WhichProcess == "like")
		LikePost();
	elseif($WhichProcess == "unlike")
		UnLikePost();
}

function LikePost()
{
	//connection
	global $con;
	
	//session variable
	$UserID = $_SESSION['SesUserID'];
	
	//get variable
	$postid = $_GET['PostID'];
	
	$Time = localtime();
	$Year = $Time[5]+1900;
	$Month = $Time[4]+1;
	$LikeTime = "{$Year}-{$Month}-{$Time[3]} {$Time[2]}:{$Time[1]}:{$Time[0]}";
	
	$NotAgainLikeQuery = "SELECT count(PostLikeSrNo) FROM `PostLike` WHERE `UserID`='$UserID' AND `PostID`='$postid' AND `LikeDelete` = '0'";
	$NotAgainLike = mysqli_fetch_row(mysqli_query($con, $NotAgainLikeQuery))[0];
	
	$LikeQuery = "INSERT INTO `PostLike`(`PostID`, `UserID`, `LikeTime`) VALUES ('$postid', '$UserID', '$LikeTime')";
	$LikeResult = mysqli_query($con, $LikeQuery);
}
function UnLikePost()
{
		//connection
	global $con;
	
	//session variable
	$UserID = $_SESSION['SesUserID'];
	
	//get variable
	$postid = $_GET['PostID'];
	
	//main
	$UnLikeQuery = "UPDATE `PostLike` SET `LikeDelete`='1' WHERE `UserID`='$UserID' AND `PostID`='$postid'";
	$UnLikeResult = mysqli_query($con, $UnLikeQuery);	
}
?>