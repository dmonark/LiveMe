<?php
session_start();
if(isset($_SESSION['SesUserID']))
{
	global $con;
	require_once('../dbconfig.php');
	establish_connections(); //This function establishes connection with the database
	GetComment();
}
else
	die("You have no permission on this page right now");

function GetComment()
{
	//connection
	global $con;
		
	//get  variable
	$postid = $_GET['PostID'];
	
	$GetComQuery = "SELECT U.UserName, U.ProfileImgAddress, P.ComInside, P.ComTime FROM userinfo U, postcomment P 
	WHERE P.UserID = U.UserID AND P.PostID = '$postid' ORDER BY P.ComTime DESC";
	
	$GetComResult = mysqli_query($con, $GetComQuery);
	
	if($GetComResult)
	{
		while($row = mysqli_fetch_assoc($GetComResult))
		{
			?>
				<div style="margin: 0px 0px 0px 0px"  class="EveryComment" >
					<div class="media">
						<div class="media-left media-top">
							<img src="<?php echo $row['ProfileImgAddress'] ?>" style="width:30px;height:30px;">
						</div>
						<div class="media-body">
							<div style="float:left;">
								<h5 style="margin:2px 0px 2px 0px" class='media-heading'><?php echo $row['UserName']; ?></h5>
								<h6 style="margin:0px 0px 0px 0px"><small><i>Posted on <?php echo $row['ComTime']; ?></i></small></h6>
							</div>
						</div>
					</div>
					<div>
						<div>
							<h5><?php echo $row['ComInside']; ?></h5>
						</div>
					</div>
				</div>
			<?php
		}
	}
}
?>