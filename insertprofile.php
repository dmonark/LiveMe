<?php
session_start();
if(isset($_SESSION['SesUserID']))
{
	global $con;
	require_once('dbconfig.php');
	establish_connections(); //This function establishes connection with the database
	insertprofile();
}
else
	die("You have no permission on this page right now");

function insertprofile()
{
	//connection
	global $con;
	
	//session
	$UserID = $_SESSION['SesUserID'];
	
	//normal variable to decide which profile it is means edu or contacts 		
	$WhichInsert = $_POST['WhichInsert'];
	
	if($WhichInsert == 'contact')
	{
		//normal
		$type = $_POST['ContactType'];
		$details = $_POST['ContactDetails'];
		$privacy = $_POST['ContactPrivacy'];
		
		if(!empty($details))
		{
			$InsertQuery = "INSERT INTO `contactinfo`(`UserID`, `ContactType`, `ContactDetails`, `ContactPrivacy`) VALUES ('$UserID', '$type', '$details', '$privacy')";
			$InsertResult = mysqli_query($con, $InsertQuery);
		}
		if(isset($InsertResult) && $InsertResult)
			header("location:ContactProfile.php");
		else
			header("location:ContactProfile.php?ErrorCode=1");
	}
	elseif($WhichInsert == 'education')
	{
		//normal edu
		$type = $_POST['EducationType'];
		$InsName = $_POST['EduInsName'];
		$InsJoinDate = $_POST['EduJoinDate'];
		$InsEndDate = $_POST['EduEndDate'];
		$EduDetails = $_POST['EducationDetails'];
		$EduPrivacy = $_POST['EducationPrivacy'];
		
		if(!empty($InsName) && !empty($InsJoinDate))
		{
			if(empty($InsEndDate))
			{
				$InsertEduQuery = "INSERT INTO `eduinfo`(`UserID`, `InsName`, `EduType`, `InsJoinDate`, `EduDetails`, `EduPrivacy`) 
								VALUES ('$UserID', '$InsName', '$type', '$InsJoinDate', '$EduDetails', '$EduPrivacy')";
			}
			else
			{	
				$InsertEduQuery = "INSERT INTO `eduinfo`(`UserID`, `InsName`, `EduType`, `InsJoinDate`, `InsEndDate`, `EduDetails`, `EduPrivacy`) 
								VALUES ('$UserID', '$InsName', '$type', '$InsJoinDate', '$InsEndDate', '$EduDetails', '$EduPrivacy')";
			}
			$InsertEduResult = mysqli_query($con, $InsertEduQuery);
		}
		if(isset($InsertEduResult) && $InsertEduResult)
			header("location:EduProfile.php");
		else
			header("location:EduProfile.php?ErrorCode=1");
	}
	elseif($WhichInsert == 'photo')
	{
		//get image number 
		$imageNumQuery = "SELECT count(ImgSrNo) FROM profileimg WHERE UserID = '$UserID'";
		$imageNum = mysqli_fetch_row(mysqli_query($con, $imageNumQuery))[0];
		
		$target_dir = "img/users/";
		
		$target_file2 = $target_dir . basename($_FILES["fileToUpload"]["name"]);
		
		$uploadOk = 1;
		
		$imageFileType = pathinfo($target_file2,PATHINFO_EXTENSION);
		
		//userid image name to set every thing perfect
		$target_file = "{$target_dir}img-{$UserID}-{$imageNum}.{$imageFileType}";
		
		// Check if image file is a actual image or fake image
		$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
		if($check !== false) 
		{
			$uploadOk = 1;
		}
		else 
		{
			echo "File is not an image.";
			$uploadOk = 0;
		}
		
		// Check if file already exists
		if (file_exists($target_file2)) 
		{
			echo "Sorry, file already exists.";
			$uploadOk = 0;
		}
		
		// Check file size
		if ($_FILES["fileToUpload"]["size"] > 500000) 
		{
			echo "Sorry, your file is too large.";
			$uploadOk = 0;
		}
		
		// Allow certain file formats
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) 
		{
			echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
			$uploadOk = 0;
		}
		
		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 0) 
		{
			echo "Sorry, your file was not uploaded.";
			// if everything is ok, try to upload file
		} 
		else 
		{
			if(move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) 
			{
				echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
				
				//database entry for record
				$Time = localtime();
				$Year = $Time[5]+1900;
				$Month = $Time[4]+1;
				$ImgTime = "{$Year}-{$Month}-{$Time[3]} {$Time[2]}:{$Time[1]}:{$Time[0]}";
 	
				$imgName = $_FILES["fileToUpload"]["name"];
				$imgSize = $_FILES["fileToUpload"]["size"];
				
				$ImgInsertQuery = "INSERT INTO `profileimg`(`UserID`, `ImgName`, `ImgSize`, `ImgMyName`, `ImgUploadTime`) VALUES ('$UserID','$imgName','$imgSize','$target_file','$ImgTime')";
				$ImgInsertResult = mysqli_query($con, $ImgInsertQuery);
				
				$ImgInsertQuery2 = "UPDATE `userinfo` SET `ProfileImgAddress` = '$target_file' WHERE `UserID` = $UserID";
				$ImgInsertResult2 = mysqli_query($con, $ImgInsertQuery2);
				
				header("location:EditProfile.php");
			} 
			else 
			{
				header("location:EditProfile.php?ErrorCode=1");
			}
		}
	}
	elseif($WhichInsert == 'postsub')
	{
		$name = $_POST['SubName'];
		$details = $_POST['SubDetails'];
		$privacy = $_POST['SubPrivacy'];
		
		$Time = localtime();
		$Year = $Time[5]+1900;
		$Month = $Time[4]+1;
		$SubTime = "{$Year}-{$Month}-{$Time[3]} {$Time[2]}:{$Time[1]}:{$Time[0]}";
		
		$PostSubQuery = "INSERT INTO `postsubject`(`UserID`, `PostSubName`, `PostSubDetails`, `PostSubPrivacy`, `PostSubDate`) 
							VALUES ('$UserID', '$name', '$details', '$privacy', '$SubTime')";
		$PostSubResult = mysqli_query($con, $PostSubQuery);
		
		if($PostSubResult)
			header("location:PostProfile.php");
		else
			header("location:PostProfile.php?ErrorCode=1");
	}
	elseif($WhichInsert = 'NewPost')
	{
		$postinside = $_POST['PostInside'];
		$postsubject = $_POST['PostSubject'];
		
		$Time = localtime();
		$Year = $Time[5]+1900;
		$Month = $Time[4]+1;
		$NewSubTime = "{$Year}-{$Month}-{$Time[3]} {$Time[2]}:{$Time[1]}:{$Time[0]}";
		
		$NewPostQuery = "INSERT INTO `postdetails`(`PostInside`, `PostSubject`, `WhoPost`) VALUES ('$postinside', '$postsubject', '$UserID')";
		$NewPostResult = mysqli_query($con, $NewPostQuery);
		
		$PostID = mysqli_insert_id($con);
		
		$PostMeQuery = "INSERT INTO `postme`(`RealPostID`, `ShareUserID`, `PostTime`) VALUES ('$PostID', '$UserID', '$NewSubTime')";
		$PostMeResult = mysqli_query($con, $PostMeQuery);
		
		if($NewPostResult && $PostMeResult)
			header("location:Profile.php");
		//else
			//header("location:Error.php");
		else
		{	
			var_dump($NewPostResult);
			var_dump($PostMeResult);
			var_dump($NewPostQuery);
			var_dump($PostMeQuery);
		}
	}
}	
?>