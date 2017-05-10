<?php
session_start();
if(isset($_SESSION['SesUserID']))
{
	global $con;
	require_once('../dbconfig.php');
	establish_connections(); //This function establishes connection with the database
	AddComment();
}
else
	die("You have no permission on this page right now");

function AddComment()
{
	//connection
	global $con;
	 
	//session variable
	$UserID = $_SESSION['SesUserID'];

	//get variable
	$postid = $_GET['PostID'];
	$cmtword = $_GET['CommentWord'];
	
	//image address
	$ImgAddQuery = "SELECT UserName, ProfileImgAddress FROM userinfo WHERE UserID = '$UserID'";
	$ImgAddResult = mysqli_query($con, $ImgAddQuery);
	$ImgAdd2 = mysqli_fetch_assoc($ImgAddResult);
	$ImgAdd = $ImgAdd2['ProfileImgAddress'];
	$namecmt = $ImgAdd2['UserName'];
	
	//main
	$Time = localtime();
	$Year = $Time[5]+1900;
	$Month = $Time[4]+1;
	$CmtTime = "{$Year}-{$Month}-{$Time[3]} {$Time[2]}:{$Time[1]}:{$Time[0]}";

	$CmtInsertQuery = "INSERT INTO `postcomment`(`PostID`, `UserID`, `ComInside`, `ComTime`) VALUES ('$postid', '$UserID', '$cmtword', '$CmtTime')";
	$CmtInsertResult = mysqli_query($con, $CmtInsertQuery);
	
	if($CmtInsertResult)
	{
		?>
		<div style="margin: 0px 0px 0px 0px"  class="EveryComment" >
			<div class="media">
				<div class="media-left media-top">
					<img src="<?php echo $ImgAdd; ?>" style="width:30px;height:30px;">
				</div>
				<div class="media-body">
					<div style="float:left;">
						<h5 style="margin:2px 0px 2px 0px" class='media-heading'><?php echo $namecmt; ?></h5>
						<h6 style="margin:0px 0px 0px 0px"><small><i>Posted on <?php echo $CmtTime; ?></i></small></h6>
					</div>
				</div>
			</div>
			<div>
				<div>
					<h5><?php echo $cmtword; ?></h5>
				</div>
			</div>
		</div>
	<?php
	}
}
?>