<?php
	if(!isset($_SESSION)){
		session_start();
	}

	$login = 0;
	// only keep user login state when
	// there is cookie of username in user's browser and
	// the username and pwd in COOKIE are the same as these in SESSION
	if (isset($_SESSION['username']) && isset($_SESSION['password'])){
		$login = 1;
	}
	
    $conn = mysqli_connect("localhost", "root", "","miniproject");
	if($conn->connect_error){
		echo "Unable to connect to database";
		exit;
	}
	
	$Hid = $_GET['Hid'];
	
    $query="select Appliances FROM `Utilities` where Hid=".$Hid;
    $result = $conn->query($query);
    if($result){
	     if($row = $result->fetch_assoc()){
            $appliance=$row['Appliances'];
            $result->free();
            }
        }
        else{$appliance="No information.";}

    $query="select Parking FROM `Utilities` where Hid=".$Hid;
    $result = $conn->query($query);
    if($result){
	     if($row = $result->fetch_assoc()){
            $Parking=$row['Parking'];
            $result->free();
            }
        }
        else{$Parking="No information.";}

    $query="select heating FROM `Utilities` where Hid=".$Hid;
    $result = $conn->query($query);
    if($result){
	     if($row = $result->fetch_assoc()){
            $heating=$row['heating'];
            $result->free();
            }
        }
        else{$heating="No information.";}

    $query="select sDistance FROM `Supermarket_Distance` WHERE Supermarket_Name=\"Price_chopper\" and Hid=".$Hid;
    $result = $conn->query($query);
    if($result){
	     if($row = $result->fetch_assoc()){
            $distance=$row['sDistance'];
            $result->free();
            }
        }
        else{$distance="No information.";}

    $query = "select * from House where Hid=".$Hid;
    $result = $conn->query($query);
	
	if($result){
		if($row = $result->fetch_assoc()){
			// get information of this item
			$Hid=$row['Hid'];
			$street=$row['Street'];
			$owner=$row['user_id'];
			$description=$row['description'];
			$image=$row['image'];
			$image2=$row['image2'];
			$updatetime=$row['updatetime'];
			$category=$row['category'];
			$price=$row['price'];
			$longitude=$row['Longitude'];
			$latitude=$row['Latitude'];
			

			
			
			$result->free();
			
			// get like number
			$likenum = 0;
			
			$query = "select count(*) as likenum from Favorite where Hid=".$Hid;
		    $result = $conn->query($query);
			if($result && $row = $result->fetch_assoc()){
				$likenum = $row['likenum'];
				$result->free();
			}
			
			// get like state
			// 1-unlike, 2-like
			$state = 1;
			if (isset($_SESSION['username']) && isset($_SESSION['password']))
			{
			   $query = "select count(*) as d from Favorite where Hid=".$Hid." and username=\"".$_SESSION['username']."\"";
			   $result = $conn->query($query);
			   if($result && $row = $result->fetch_assoc())
			   {
				  $state = $row['d'] + 1;
				  $result->free();
			   }
	        }
	

			
			// get owner information
			$query = "select * from User where user_id=\"".$owner."\"";
			$result = $conn->query($query);
			if($result && $row = $result->fetch_assoc()){
				$owner_gender = $row['gender'];
				$owner_wechat = $row['wechat'];
				$owner_mobile = $row['mobile'];
				$owner_email = $row['email'];
				$owner_preference = $row['preference'];
				
				$result->free();
			}
			
			// get comment of this item
			$comment_count = 0;
			
			$query = "select * from Comment where Hid=".$Hid;
			$result = $conn->query($query);
			if($result){
				while($row = $result->fetch_assoc()){
					$comment_seq[$comment_count] = $row['CommentSeq'];
					$comment_username[$comment_count] = $row['user_id'];
					$comment_content[$comment_count] = $row['content'];
					$comment_updatetime[$comment_count] = $row['update_time'];
					$comment_count++;
				}
				$result->free();
			}
		}else{
			header("Location:main.php?module=404");
		}
	}else{
		header("Location:main.php?module=404");
	}	    
?>

<!DOCTYPE html>
<html class="no-js">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Product Details</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width">

    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/icomoon-social.css">
    <link rel='stylesheet' href='../css/fonts.css'>
    <link rel="stylesheet" href="../css/leaflet.css" />
	<!--[if lte IE 8]>
	    <link rel="stylesheet" href="css/leaflet.ie.css" />
	<![endif]-->
	<link rel="stylesheet" href="../css/main.css">

    <script src="../js/mode rnizr-2.6.2-respond-1.1.0.min.js"></script>
    <script>
        var i = <?=$state?> ;
        var a = <?=$likenum?> ;
        function userLike(){

			if( <?=$login?> == 0){
				//document.getElementById('likestate').innerHTML = " &nbsp"; 
				//$('#likestate').fadeIn(200);
				document.getElementById('likestate').innerHTML = " <a href='login.php' target='_blank'> Please login</a> and refresh";
				//$('#likestate').fadeOut(1000);
                return false;
            }else{

				var req = null;
				if(window.XMLHttpRequest){
					req = new XMLHttpRequest();
				} else if(window.ActiveXObject){
					req = new ActiveXObject("Microsoft.XMLHTTP");
				} else if(req == null){
					alert("Your browser does not support XML.");
				}
					
				var stateChange = function(){
					if (req.readyState == 4 && req.status == 200){
						document.getElementById('likenum').innerHTML = req.responseText;
					}
				} 
					
				req.onreadystatechange = stateChange;
				req.open("POST", "../AJAX/Like.php", true);
				req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
				req.send("Hid=<?=$Hid?>&s=" + i);
		          
				document.getElementById('likestate').innerHTML = " &nbsp"; 
				$('#likestate').fadeIn(200);
				if (i == 1){
					document.getElementById('likestate').innerHTML = " +1 Liked"; 
					document.getElementById('like1').setAttribute('src', "../resources/image/heartRed.png");
					i = 2;
					$('#likestate').fadeOut(1000);
				}else if (i == 2){
					document.getElementById('likestate').innerHTML = " -1 Canceled";
					document.getElementById('like1').setAttribute('src', "../resources/image/heartWhite.png");
					i = 1;
					$('#likestate').fadeOut(1000);
				}
			}
		}
            
		function validateComment(f){	
			var valid = true;
	        if (f == ""){
				document.getElementById('CommentCon').innerHTML = "Please input your comment";
				valid = false;
			} else {
				document.getElementById('CommentCon').innerHTML = "";
			}
	        return valid;
        }
		
		function reply(replyid){
			var content = document.getElementById("content").value;
			if(validateComment(content)){
				var req = null;
				if(window.XMLHttpRequest){
					req = new XMLHttpRequest();
				} else if(window.ActiveXObject){
					req = new ActiveXObject("Microsoft.XMLHTTP");
				} else if(req == null){
					alert("Your browser does not support XML.");
				}
					
				var stateChange = function(){
					if (req.readyState == 4 && req.status == 200){
						alert(req.responseText);
						window.location.reload();
					}
				} 
					
				req.onreadystatechange = stateChange;
				req.open("POST", "../AJAX/AddComment.php", true);
				req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
				req.send("Hid=<?=$Hid?>&content=" + content);
			}
		}
		
		function sendEmail(){
			var message = prompt("please input the message");
			if(message != ""){
				document.getElementById("emailMsg").innerHTML = "";
				
				var req = null;
				if(window.XMLHttpRequest){
					req = new XMLHttpRequest();
				} else if(window.ActiveXObject){
					req = new ActiveXObject("Microsoft.XMLHTTP");
				} else if(req == null){
					alert("Your browser does not support XML.");
				}
					
				var stateChange = function(){
					if (req.readyState == 4 && req.status == 200){
						alert(req.responseText);
					}
				} 
					
				req.onreadystatechange = stateChange;
				req.open("POST", "../AJAX/SendMessage.php", true);
				req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
				req.send("owner=<?=$owner?>&email=<?=$owner_email?>&message=" + message);
			}else{
				document.getElementById("emailMsg").innerHTML = "<br/>empty message!";
			}
		}
    </script>
</head>
<body>        
	<!-- Navigation & Logo-->
	<div class="mainmenu-wrapper">
		<div class="container">
			<div class="menuextras">
				<div class="extras">
					<ul>
					<?php if ($login == 1) { ?> 
						<div style="font-size:23px"> Welcome, <?=$_SESSION['username']?> 
							<span>&nbsp;&nbsp;</span>
							[<a href="logout.php?">Logout</a>]
						</div>
  
            		<?php } else { ?> 
						<a href="login.php?" target="_blank" style="font-size:24px">Login</a>
            		<?php } ?>
         
			      	</ul>
				</div>
		    </div>
		    <nav id="mainmenu" class="mainmenu">
				<ul>
					<nav id="mainmenu" class="mainmenu">
				<ul>
					<li class="logo-wrapper">
						<a href="../index.php"><img src="../resources/image/logo.jpeg" alt="LOGO IMG" height="62" width="62"></a>
					</li>
					<li>
						<a href="main.php?">HOME</a>
					</li>
					
				</ul>
			</nav>
				</ul>
			</nav>
		</div>
	</div>

    <!-- Page Title -->
	<div class="section section-breadcrumbs">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<h1>Item Details</h1>
				</div>
			</div>
		</div>
	</div>
        
    <div class="section">
    	<div class="container">
    		<div class="row">
			
    			<!-- Product Image & Available Colors -->
    			<div class="col-sm-6">
    				<div class="product-image-large">
    					<?php
    					if($image != NULL){
							echo "<img src='../resources/image/".$image."' height=\"300\" width=\"450\">";
    					}
						?>
    				</div>
    				<div class="product-image-large">
    					<?php
    					if($image != NULL){
							echo "<img src='../resources/image/".$image2."' height=\"300\" width=\"450\">";
    					}
						?>
    				</div>
    			</div>
				
    			<!-- Product Summary & Options -->
    			<div class="col-sm-6 product-details">
    				<h4> <?=$Hid?></h4>
					<h5>Price:</h5>
    				<p>USD$&nbsp;<?=$price?></p>
					<h5>Like
	    			<?php if ($state == 2){?>
	    				<img src="../resources/image/heartRed.png" id="like1" style='cursor: pointer' onclick="userLike()"/>
	    			<?php } else {?>
	    				<img src="../resources/image/heartWhite.png" id="like1" style='cursor: pointer' onclick="userLike()"/>
	    			<?php } ?>
	    				<span id='likenum'><?=$likenum?></span>
	    				<p id='likestate'></p>
    				</h5>
    				<h5>Post by:</h5>
    				<p><?=$owner?></p>
    				<h5>Appliance: </h5>
    				<p>	<?=$appliance?></p>
    				<h5>Parking: </h5>
    				<p>	<?=$Parking?></p>
    				<h5>Heating: </h5>
    				<p>	<?=$heating?></p>
    				<h5>Price Chopper: </h5> 
    				<p>	<?=$distance?> miles</p>
    				

	    		</div>
    			
    			<!-- Full Description & Specification -->
    			<div class="col-sm-12">
    				<div class="tabbable">
						<!-- description, contact, comment NAVIGATION -->
						<ul class="nav nav-tabs product-details-nav">
							<li class="active"><a href="#tab1" data-toggle="tab">Details</a></li>
							<li><a href="#tab2" data-toggle="tab">Contact Information</a></li>
							<li><a href="#tab3" data-toggle="tab">Comment</a></li>
						</ul>
						
						<div class="tab-content product-detail-info">
						
							<!-- Full Description -->
							<div class="tab-pane active" id="tab1">
								<h4>Product Description</h4>
								<?php echo $description; ?>
							</div>
							
							<!-- Owner Contact -->
							<div class="tab-pane" id="tab2">
								<table>
									<tr>
										<td>Phone number:</td>
										<td><h5><?php echo $owner_mobile; ?></h5></td>
									</tr>
									<tr>
										<td>Wechat:</td>
										<td><h5><?php echo $owner_wechat; ?></h5></td>
									</tr>
									<!--tr>
										<td>Email:</td>
										<td><h5><?php echo $owner_email; ?></h5></td>
									</tr-->
									<tr style="text-align: right">
										<td ><h4><button onclick="sendEmail()" class="btn">Email to Seller</button><span id="emailMsg" style='color:red'></span></h4></td>
										
									</tr>
									</table>
							</div>
							
							<!-- Comment -->
							<div class="tab-pane" id="tab3">
								<?php
								// get comment of this item
								$comment_count = 0;
								
								$query = "select * from Comment where Hid=".$Hid;
								$result = $conn->query($query);
								if($result){
									while($row = $result->fetch_assoc()){
										$comment_seq[$comment_count] = $row['CommentSeq'];
										$comment_username[$comment_count] = $row['user_id'];
										$comment_content[$comment_count] = $row['content'];
										$comment_updatetime[$comment_count] = $row['update_time'];
										$comment_count++;
									}
									$result->free();
									for($i = 0; $i < $comment_count; $i++){
										$floor = $i + 1;
								?>
								<!-- comment title -->
								<table width="100%" border="0" cellspacing="2" cellpadding="0">
            						<tr>
            							<td height="16" bgcolor="DFE1E3">
											<h5><b>&nbsp;&nbsp;<?php echo $floor."F    "?></b></h5>
            							</td>
            							<td height="16" bgcolor="DFE1E3" style="text-align: right">
            								<h6>&nbsp;<?php echo $comment_username[$i]." at ".$comment_updatetime[$i]; ?>&nbsp;&nbsp;<a onclick="reply(<?=$comment_seq[$i]?>)">reply</a><h6>
            							</td>
            						</tr>
           						</table>
								<!-- comment content -->
            					<table width="100%" border="0" cellspacing="5" cellpadding="0" > 
            						<tr>
            							<td width="49%" height="16"><h5>&nbsp;<?php echo $comment_content[$i];  ?></h5></td>
            						</tr>
									<?php
										$query = "select * from Comment where Hid=".$Hid;
										$result = $conn->query($query);
										if($result){
											while($row = $result->fetch_assoc()){
										?>
											<tr>
												
											</tr>
										<?php
											}
											$result->free();
										?>
									</table>
									<?php
										}
									}
								}
								?>
								<br/>
								<!-- add comment -->
							    <div class='form-group'>
									<label><i class='icon-user'></i> <b>Your Comment</b></label>
									<textarea  id="content" class='form-control' rows='6' cols='20' name='Comment' placeholder='Please comment here'></textarea>
									<span id='CommentCon' name='CommentCon' style='color:red'></span>
									<input type="hidden" name="PostId" value="<?=$postid?>">
									<?php if($login){?>
									<br><input id="submit_comment" type="button" value="Submit" class='btn pull-right' onclick="reply(<?php $Hid?>)">
									<br>
									<?php  } 
									else{
										echo"<a href='../pages/login.php' target='_blank'> Please login</a> first to comment";
									}
									?>
		                        </div> 
							</div>
						</div>
					</div>
    			</div>
    			<div class="col-sm-12">
    				<style>
                     #map {
                     height: 400px;  /* The height is 400 pixels */
                     width: 100%;  /* The width is the width of the web page */
                          }
                    </style>
                    <h3>Map</h3>
                       <!--The div element for the map -->
                       <div id="map"></div>
                       <script>                      
                        function initMap() {
                        	   var lati= "<?php echo $latitude ?>";
                               var lngi= "<?php echo $longitude ?>";
                               var locationRio = {lat: parseFloat(lngi), lng: parseFloat(lati)};
                               var map = new google.maps.Map(document.getElementById('map'), {
                                 zoom: 18,
                                 mapTypeId: 'satellite',
                                 center: locationRio,
                                 gestureHandling: 'cooperative'
                               }

                               );
                               var marker = new google.maps.Marker({
                                 position: locationRio,
                                 map: map,
                                 title: 'Your target housing!'
                               });
                               map.setTilt(45);
                             }
                       </script>
    <!--Load the API from the specified URL
    * The async attribute allows the browser to render the page while the API loads
    * The key parameter will contain your own API key (which is not needed for this tutorial)
    * The callback parameter executes the initMap() function
    -->
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAiK_r_uOuYA6-HkigYT836v8htv_hyXdU&callback=initMap">
    </script>
    			</div>
    			<!-- End Full Description & Specification -->
	    	</div>
		</div>
	</div>
<?php
	require('frame_footer.php');
	$conn->close();
?>
    <!-- Javascripts -->
    <script src="../js/jquery-1.9.1.min.js"></script>
	<script src="../js/bootstrap.min.js"></script>
	<script src="../js/leaflet.js"></script>
	<script src="../js/jquery.fitvids.js"></script>
	<script src="../js/jquery.sequence-min.js"></script>
	<script src="../js/jquery.bxslider.js"></script>
	<script src="../js/main-menu.js"></script>
	<script src="../js/template.js"></script>
</body>
</html>