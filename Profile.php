<?php
session_start();
if(isset($_SESSION['SesUserID']))
{	
	require_once('dbconfig.php');
	establish_connections(); //This function establishes connection with the database
}
else
	header("location:login.php?NextURL=Profile.php");

function GetEduInfo()
{
	//connection
	global $con;
	
	//session variable
	$UserID = $_SESSION['SesUserID'];
	
	//main function 
	$GetEduQuery = "SELECT InsName, EduType FROM eduinfo WHERE UserID = '$UserID' AND EduDeleteStatus = '0'";
	$GetEduResult = mysqli_query($con, $GetEduQuery);
	
	while($row = mysqli_fetch_assoc($GetEduResult))
	{
		$GetEdu[] = $row;
	}

	if(isset($GetEdu))
		return $GetEdu;
}

function GetContactInfo()
{
	//connection
	global $con;
	
	//session variable
	$UserID = $_SESSION['SesUserID'];
	
	//main function 
	$GetConQuery = "SELECT ContactType, ContactDetails FROM contactinfo  WHERE UserID = '$UserID' AND DeleteStatus = '0' ORDER BY ContactInfoSrNo DESC";
	$GetConResult = mysqli_query($con, $GetConQuery);
	
	
	while($row = mysqli_fetch_assoc($GetConResult))
	{
		$GetCon[] = $row;
	}

	if(isset($GetCon))
		return $GetCon;	
}

function GetPersonalInfo()
{
	//connection
	global $con;
	
	//session variable
	$UserID = $_SESSION['SesUserID'];
	
	//main function 
	$GetPersonalQuery = "SELECT UserEmail, ProfileImgAddress, UserName, UserGender, UserDOB FROM userinfo WHERE UserID = '$UserID'";
	$GetPersonalResult = mysqli_query($con, $GetPersonalQuery);
	
	$GetPersonal = mysqli_fetch_assoc($GetPersonalResult);

	if(isset($GetPersonal))
		return $GetPersonal;	
}

function GetMyPost()
{
	//connection
	global $con;
	
	//session variable
	$UserID = $_SESSION['SesUserID'];
	
	$AllPostQuery = "SELECT M.PostMeSr, U.UserName, U.ProfileImgAddress, S.PostSubName, P.PostInside, P.WhoPost, M.ShareUserID, M.PostTime 
						FROM postdetails P, postme M, userinfo U, postsubject S 
						WHERE M.RealPostID = P.PostSrNo AND M.PostDelete = '0' AND M.ShareUserID = U.UserID 
						AND P.PostSubject = S.PostSubSrNo AND M.ShareUserID = '$UserID' ORDER BY M.PostMeSr DESC";

	$AllPostResult = mysqli_query($con, $AllPostQuery);

	while($row = mysqli_fetch_assoc($AllPostResult))
		$AllPost[] = $row;

	if(isset($AllPost))
		return $AllPost;
}

function GetMySubject()
{
	//connection
	global $con;
	
	//session variable
	$UserID = $_SESSION['SesUserID'];
	
	//main function
	$GetSubQuery = "SELECT PostSubSrNo, PostSubName FROM postsubject WHERE UserID = '$UserID'";
	$GetSubResult = mysqli_query($con, $GetSubQuery);
	
	while($row = mysqli_fetch_assoc($GetSubResult))
		$GetSub[] = $row;
	
	if(isset($GetSub))
		return $GetSub;
}

function ilikeornot($postid)
{
	//connection
	global $con;
	
	//session variable
	$UserID = $_SESSION['SesUserID'];
	
	//main function
	$NotAgainLikeQuery = "SELECT count(PostLikeSrNo) FROM `PostLike` WHERE `UserID`='$UserID' AND `PostID`='$postid' AND `LikeDelete` = '0'";
	$NotAgainLike = mysqli_fetch_row(mysqli_query($con, $NotAgainLikeQuery))[0];
	
	return $NotAgainLike;
}
function HowManyLike($postid)
{
	//connection
	global $con;
	
	//main	
	$ManyLikeQuery = "SELECT count(PostLikeSrNo) FROM `PostLike` WHERE `PostID`='$postid' AND `LikeDelete` = '0'";
	$ManyLike = mysqli_fetch_row(mysqli_query($con, $ManyLikeQuery))[0];
	
	return $ManyLike;
}	
?>

<html>
	<head>
		<title>Profile</title>
		
		<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<!----link rel="stylesheet" type="text/css" href="css/bootstrap.min.css"--->	
		<link rel="stylesheet" type="text/css" href="css/styles.css">
		
		<style>
			#Personal, #AllDetails
			{
				float:left;
				display:inline;
			}
			#PersonalImage, #PersonalData,#PersonalSubject, #education, #contact, #allpost, #NewPost
			{
				border:1px solid black;
				width:200px;
				-webkit-box-sizing: border-box;
				background-color:#ffc2b3;
				margin: 0px 0px 5px 5px;			
			}
			#PersonalData, #PersonalSubject, #education, #contact
			{
				text-align: left;
				padding: 0px 10px 0px 5px;
			}
			.EveryPost
			{
				border:1px solid black;
				text-align:left;
				-webkit-box-sizing: border-box;
				margin: 5px 5px 5px 5px;
				padding: 5px 5px 5px 5px;
			}			
			#education, #contact, #allpost, #NewPost
			{
				background-color:#f5f5f0;
				width:500px;
			}
			.container
			{
				width:740px;
			}
			.EveryComment
			{
				border : 0px solid black;
			}
			.PostBtn
			{
				display: inline;
				float: left;
				margin: 0px 2px 0px 2px;
			}
		</style>
		<script>
			function CreateXML()
			{
				if (window.XMLHttpRequest) 
				{
					// code for IE7+, Firefox, Chrome, Opera, Safari
					xmlhttp = new XMLHttpRequest();
				} 
				else 
				{
					// code for IE6, IE5
					xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
				}
				return xmlhttp;
			}
			function ViewComment(PostNumber, PostID)
			{	
				xmlhttp = CreateXML();
				var queryViewComments = "PostID="+PostID;
				var ViewCommentsURL = "ajax/ViewOldComments.php?" + queryViewComments;
				xmlhttp.open("GET",ViewCommentsURL,true);
				
				xmlhttp.onreadystatechange = function() 
				{
					if (this.readyState == 4 && this.status == 200) 
					{
						document.getElementsByClassName('PostComment')[PostNumber].style.display = "block";
						//document.getElementsByClassName('Combtn')[PostNumber].disabled = true;
						var list2 = document.getElementsByClassName("OldCom")[PostNumber];
						list2.innerHTML = xmlhttp.responseText;
					}						
				};
				xmlhttp.send(null);
			}
			function AddComment(PostNumber, PostID)
			{
				//no need to call createxml because this already has been declared 
				
				var CommentWord = document.getElementsByClassName("newcmttext")[PostNumber].value;
				var queryComment = "PostID=" + PostID + "&CommentWord=" +CommentWord;
				var CommentURL = "ajax/AddNewComment.php?" + queryComment;
			
				xmlhttp.open("GET", CommentURL, true);
				
				xmlhttp.onreadystatechange = function() 
				{
					if (this.readyState == 4 && this.status == 200) 
					{
						var list = document.getElementsByClassName("OldCom")[PostNumber];
						list.innerHTML = xmlhttp.responseText + list.innerHTML;
						document.getElementsByClassName("newcmttext")[PostNumber].value="";
					}
				};
				xmlhttp.send(null);	
			}
			function AddLike(PostNumber, PostID)
			{
				xmlhttp = CreateXML();
				
				var LikeQuery = "WhatProcess=like&PostID=" +PostID;
				var LikeURL = "ajax/LikeProcess.php?" +LikeQuery;
				
				xmlhttp.open("GET", LikeURL, true);
				
				xmlhttp.onreadystatechange = function()
				{
					if (this.readyState == 4 && this.status == 200) 
					{
						var liketotal = parseInt(document.getElementsByClassName('likenum')[PostNumber].innerHTML);
						document.getElementsByClassName('likebtn')[PostNumber].innerHTML = "<button class='btn btn-primary btn-sm active' onclick='RemoveLike(" +PostNumber+"," +PostID+ ")' ><span class='glyphicon glyphicon-heart'></span> Liked</button>";
						
						liketotal = liketotal + 1;
						document.getElementsByClassName('likenum')[PostNumber].innerHTML = liketotal;
					}
				}
				xmlhttp.send(null);	
			}
			function RemoveLike(PostNumber, PostID)
			{
				xmlhttp = CreateXML();
				
				var LikeQuery = "WhatProcess=unlike&PostID=" +PostID;
				var LikeURL = "ajax/LikeProcess.php?" +LikeQuery;
				
				xmlhttp.open("GET", LikeURL, true);
				
				xmlhttp.onreadystatechange = function()
				{
					if (this.readyState == 4 && this.status == 200) 
					{
						var liketotal = parseInt(document.getElementsByClassName('likenum')[PostNumber].innerHTML);
						document.getElementsByClassName('likebtn')[PostNumber].innerHTML = "<button class='btn btn-primary btn-sm active' onclick='AddLike(" +PostNumber+"," +PostID+ ")' ><span class='glyphicon glyphicon-heart-empty'></span> Like</button>";
						
						liketotal = liketotal - 1;
						document.getElementsByClassName('likenum')[PostNumber].innerHTML = liketotal;
					}
				}
				xmlhttp.send(null);	
			}
			function DeletePost(PostNumber, PostID)
			{
				document.getElementsByClassName("EveryPost")[PostNumber].innerHTML = "<div style='margin: 0px;' class='alert alert-success'><strong>Success!</strong> Post has been deleted.</div>";
			}
		</script>
	</head>
	<body>
		<div class="container">			
			<div id="top">
				<?php require_once('header.php'); ?>
			</div>	
			<div id="middle">	
				<div id="Personal">
					<div  id="PersonalImage">
					<?php 
						$personal = GetPersonalInfo();
						$img = $personal['ProfileImgAddress'];	
						
						if(isset($img) && file_exists($img))
							echo "<img src='{$img}' style='width:198px;'>"; 
						else
							echo "<img src='img/users/no-profile.jpg' style='width:198px;'>";
					?> 
					</div>
					<div id="PersonalData">
						<?php
							$name = $personal['UserName'];
							$dob = $personal['UserDOB'];
							$gender = $personal['UserGender'];
							$email = $personal['UserEmail'];
							echo "<h3>{$name}</h3>";
							echo "<p>{$email}</p>";
							echo "<p>{$dob}</p>";
							echo "<p>{$gender}</p>";
						?>
					</div>
					<div id="PersonalSubject">
						<h3>Post Subject</h3>
						<?php
							$sub = GetMySubject();
							$sublen = count($sub);
							if($sublen==0)
								echo "<p>Nothing to show</p>";
							else
							{
								echo "<ul>";
								for($i=0;$i<$sublen;$i++)
									echo "<li><p>{$sub[$i]['PostSubName']}</p></li>";
								echo "</ul>";
							}
						?>
					</div>
				</div>
				
				<div id="AllDetails">
					<div id="education">
						<h3 style="text-align:center">Education Details</h3>
						<?php
							$education = GetEduInfo();
							$edulen = count($education);
							if($education==0)
								echo "<p>Nothing to show</p>";
							else
							{
								for($i=0; $i<$edulen; $i++)
								{
									if($education[$i]['EduType']=='High')
										$education[$i]['EduType'] = 'High school';
									elseif($education[$i]['EduType'] == 'Primary')
										$education[$i]['EduType'] = 'Primary school';
									echo "<p><strong>{$education[$i]['EduType']}</strong> at {$education[$i]['InsName']}</p>";
								}
							}
						?>
					</div>
					<div id="contact">
						<h3 style="text-align:center">Contact Details</h3>
						<?php
							$contact = GetContactInfo();
							$conlen = count($contact);
							if($conlen == 0)
								echo "<p>Nothing to show</p>";
							else
							{
								for($i=0; $i<$conlen; $i++)
								{
									echo "<p><strong>{$contact[$i]['ContactType']}</strong> :- {$contact[$i]['ContactDetails']}</p>";
								}
							}	
						?>
					</div>
					<div id="NewPost">
						<h5>What's new today tell the world</h5>
						<form action="insertprofile.php" method="POST">
							<div class="form-group">
								<textarea name="PostInside" style="width:90%; height: 100px; resize:none;" class="form-control"></textarea>
							</div>
							<div class="form-group" style="display:none">
								<input type="text" class="form-control" name="WhichInsert" value="NewPost">
							</div>
							<div class="form-group">
								<strong>Subject </strong><select name="PostSubject" style="width:200px;" class="form-control">
								<?php
									$subp = GetMySubject();
									$sublenp = count($subp);
									
									if($sublenp==0)
										echo "<option value='0'>Nothing to show</option>";
									else
									{
										for($i=0;$i<$sublenp;$i++)
										{
											$subid = $subp[$i]['PostSubSrNo'];
											$subname = $subp[$i]['PostSubName'];
											echo "<option value='{$subid}'>{$subname}</option>";
										}
									}
								?>
								</select>
								<button class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-envelope"></span> Post</button>
								<a href="PostProfile.php">Add New Subject</a>
							</div>
						</form>
					</div>
					<div id="allpost">
						<?php 
							$AllPost = GetMyPost(); 
							$AllPostlen = count($AllPost);
							
							if($AllPostlen == 0)
								echo "<p>Nothing to show</p>";
							else
							{
								for($i=0; $i<$AllPostlen; $i++)
								{
								?>
								<div class='EveryPost'>
									
									<div class="PostUp">
										<div class="media">
											<div class="media-left media-top">
												<img src="<?php $PostImgAdd = $AllPost[$i]['ProfileImgAddress']; echo $PostImgAdd; ?>" class="media-object" style="width:40px; height:40px;">
											</div>
											<div class="media-body">
												<?php 
													$PostUserName = $AllPost[$i]['UserName'];
													$PostSubTime = $AllPost[$i]['PostTime'];
													echo "<h4 class='media-heading' >{$PostUserName}<small><i> Posted on {$PostSubTime}</i></small></h4>";												
													$PostSubName = $AllPost[$i]['PostSubName'];
													echo "<p>From <strong>{$PostSubName}</strong> subject</p>";
												?>
											</div>
										</div>
									</div>
									
									<div class="PostMid" >
										<div class="well well-sm" style="margin:0px 0px 5px 0px;">
										<?php
											echo "<p>{$AllPost[$i]['PostInside']}</p>";
										?>
										</div>	
									</div>
									
									<div style="margin:0px 0px 2px 2px;">
										<?php $howlike = HowManyLike($AllPost[$i]['PostMeSr']); echo "<span class='badge likenum'>{$howlike}</span> Likes"; ?>
									</div>
									
									<div style="margin:0px 0px 1px 0px;" class="PostDown">
										<div class="PostBtn likebtn">
										<?php
										$postid = $AllPost[$i]['PostMeSr'];
										$UserID = $_SESSION['SesUserID'];
										$NotAgainLikeQuery = "SELECT count(PostLikeSrNo) FROM `PostLike` WHERE `UserID`='$UserID' AND `PostID`='$postid' AND `LikeDelete` = '0'";
										$NotAgainLike = mysqli_fetch_row(mysqli_query($con, $NotAgainLikeQuery))[0];
										
										if($NotAgainLike == 0)
										{											
										?>
											<button class="btn btn-primary btn-sm active " onclick="AddLike(<?php echo "{$i},{$AllPost[$i]['PostMeSr']}"; ?>)" ><span class="glyphicon glyphicon-heart-empty"></span> Like</button>
										<?php
										}
										elseif($NotAgainLike == 1)
										{
										?>
											<button class="btn btn-primary btn-sm active " onclick="RemoveLike(<?php echo "{$i},{$AllPost[$i]['PostMeSr']}"; ?>)" ><span class="glyphicon glyphicon-heart"></span> Liked</button>
										<?php
										}	
										?>
										</div>
										<div class="PostBtn">
											<button class="btn btn-success btn-sm active Combtn" onclick="ViewComment(<?php echo "{$i},{$AllPost[$i]['PostMeSr']}"; ?>)" ><span class="glyphicon glyphicon-comment"></span> Comments</button>
										</div>
										<div class="PostBtn">
											<button class="btn btn-info btn-sm active disabled"><span class="glyphicon glyphicon-share"></span> Share</button>
										</div>
										<div class="PostBtn">
											<button class="btn btn-warning btn-sm active"><span class="glyphicon glyphicon-edit"></span> Edit</button>	
										</div>
										<div>
											<button class="btn btn-danger btn-sm active" onclick="DeletePost(<?php echo "{$i},{$AllPost[$i]['PostMeSr']}"; ?>)"><span class="glyphicon glyphicon-trash"></span> Delete</button>
										</div>
									</div>
									
									<div class="PostComment" style="display:none;">
										
										<div style="margin: 10px 0px 10px 0px" class="NewCom">
											<div class="media">
												<div class="media-left media-top">
													<img src="<?php $PostImgAdd = $AllPost[$i]['ProfileImgAddress']; echo $PostImgAdd; ?>" class="media-object" style="width:30px; height:30px;">
												</div>
												<div class="media-body">
													<input type="text" style="width:300px;" class="input-sm form-control newcmttext">
													<button class="btn btn-primary btn-sm" onclick="AddComment(<?php echo "{$i},{$AllPost[$i]['PostMeSr']}"; ?>)"  ><span class="glyphicon glyphicon-comment"></span> Comment</button>
												</div>
											</div>	
										</div>
										
										<div class="OldCom" >
										</div>
									
									</div>
									
								</div>
								<?php
								}		
							}	
						?>
					</div>
				</div>
			</div>
			<div id="bottom">
				<?php require_once('footer.php'); ?>
			</div>
		</div>	
	</body>
</html>