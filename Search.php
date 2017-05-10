<?php
session_start();
if(isset($_SESSION['SesUserID']))
{	
	require_once('dbconfig.php');
	establish_connections(); //This function establishes connection with the database
}
else
	header("location:login.php?NextURL=Search.php");

function SearchProcess()
{
	$time = microtime(true); // time in Microseconds

	//connection
	global $con;
	
	//session
	$UserID = $_SESSION['SesUserID'];
	
	//normal
	$SearchKey = $_GET['SearchKey'];
	
	$SearchQuery = "SELECT U.UserID, U.UserName, U.UserGender, U.UserDOB FROM userinfo U WHERE U.UserName LIKE '%$SearchKey%'";
	$SearchResult = mysqli_query($con, $SearchQuery);
		
	while($row = mysqli_fetch_assoc($SearchResult))
	{
		$UID = $row['UserID'];
		
		$GetImageQuery = "SELECT ImgSrNo, ImgMyName FROM profileimg WHERE UserID = '$UID' ORDER BY ImgSrNo DESC LIMIT 1";
		$GetImageResult = mysqli_query($con, $GetImageQuery);
		$GetImage = mysqli_fetch_assoc($GetImageResult)['ImgMyName'];
			
		if($GetImage)	
			$row['Image'] = $GetImage;	
		else
			$row['Image'] = 'img/users/no-profile.jpg';
		
		$Search[] = $row;
	}
	
	return $Search;
}

?>
<html>
	<head>
		<title>Search</title>
		
		<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
		
		<link rel="stylesheet" type="text/css" href="css/styles.css">
		
		<style>
		</style>
	</head>
	<body>
		<div align="center" class="container">
			
			<div id="top">			
				<?php require_once('header.php'); ?>
			</div>
			
			<div id="middle">	
				<div>
					<form action="" method="GET">
						<div class="form-group">
							<input type="text" class="form-control" style="width:400px" <?php if(isset($_GET['SearchKey'])) echo "value='".$_GET['SearchKey']."'"; ?> placeholder="Enter search key word" name="SearchKey">	
						</div>
					</form>
				</div>
			</div>
			
			<div id="bottom">		
				<?php require_once('footer.php'); ?>
			</div>
			
		</div>	
	</body>	
</html>