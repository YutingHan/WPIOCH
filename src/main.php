<?php
if(!isset($_SESSION)){
   	session_start();
}

if (isset($_SESSION['alert'])){
	if ($_SESSION['alert'] == 1){
		$message = "Please login to operate lease function.";
		echo "<script type='text/javascript'>alert('$message');</script>";
		$_SESSION['alert'] = 0;
	}
}

$login = 0;
// only keep user login state when
// there is cookie of username in user's browser and
// the username and pwd in COOKIE are the same as these in SESSION
if (isset($_SESSION['username']) && isset($_SESSION['password'])){
	$login = 1;
}

// module is the current div shown in the middle of the web page
if (isset($_GET['module'])){
    $module = $_GET['module'];
} else {
    $module = 'home';
}

$categoryArray = array("With Parking Lot","Gym in 1 mile","Library in 1 mile");
?>

<!DOCTYPE html>
<html class="no-js">
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>WPIOCH</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width">

    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link href='../css/fonts.css' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="../css/leaflet.css" />
	<link rel="stylesheet" href="../css/main.css">
    <script src="../js/modernizr-2.6.2-respond-1.1.0.min.js"></script>
    <script type="text/javascript">
	
	function validatePost(f){
		var valid = true;
		if (f.PostTitle.value == ""){
			document.getElementById('PostTitleMsg').innerHTML = "Please input your post title";
	        valid = false;  
	    } else {
	        document.getElementById('PostTitleMsg').innerHTML = "";
	    }
	            
	            
	    if (f.Description.value == ""){
	        document.getElementById('DescriptionMsg').innerHTML = "Please input the discription of the product";
	        valid = false;
	               
	    } else {
			document.getElementById('DescriptionMsg').innerHTML = "";
	    }
	            
	    if (f.Category.value == ""){
	       	document.getElementById('CategoryMsg').innerHTML = "Please input cataory";
	        valid = false;
	              
	    } else {
	        document.getElementById('CategoryMsg').innerHTML = "";
       	}
	            
		return valid;
	}
	       
	</script>
</head>
<body>
	<!-- Navigation & Logo-->
	<div class="mainmenu-wrapper">
		<div class="container">
			<div class="menuextras extras">
				<ul>
					<div style="font-size:23px">
				<?php if ($login == 1) { ?>
					<!-- if the user has logged in, show following information -->
					 Welcome, <?=$_SESSION['username']?>
						[<a href="Logout.php">Logout</a>]
				<?php }else { ?>
					<!-- else if the user has not logged in, show following information --> 
						[<a href="Login.php">Login</a>]
				<?php } ?>
					</div>
				</ul>
			</div>
			<nav id="mainmenu" class="mainmenu">
				<ul>
					<li class="logo-wrapper">
						<a href="main.php"><img src="../resources/image/logo.jpeg" alt="LOGO IMG" height="62" width="62"></a>
					</li>
					<li <?php if ($module == 'home' ) {echo 'class="active"'; }?>>
						<a href="main.php">HOME</a>
					</li>
					<li <?php if ($module == 'search') {echo 'class="active"'; }?>>
						<a href="main.php?module=search">SEARCH</a>
					</li>
					<li <?php if ($module == 'buy') {echo 'class="active"'; }?>>
						<a href="main.php?module=buy">RENT</a>
					</li>
					<li <?php if ($module == 'sell') {echo 'class="active"'; }?>>
						<a href="main.php?module=sell">LEASE</a>
					</li>
				</ul>
			</nav>
		</div>
	</div>
 
 	<!-- main part of the homepage -->
	<?php
	switch ($module) {
		case 'home': require('main_home.php'); break;
		case 'buy': require('main_rent.php'); break;
		case 'search': require('main_search.php'); break;
		case 'sell': require('main_sell.php'); break;
		case 'info': header('Location:personal.php'); break;
		default: header('Location:pagenotfound.php');
	}?>
	
	<!-- footer of the homepage -->
	<?php
	require('frame_footer.php');
	?>
	
    <!-- Javascripts -->
	<script src="../js/jquery-1.9.1.min.js"></script>
	<script src="../js/bootstrap.min.js"></script>
	<script src="../js/leaflet.js"></script>
	<script src="../js/jquery.fitvids.js"></script>
	<script src="../js/jquery.sequence-min.js"></script>
	<script src="../js/jquery.bxslider.js"></script>
	<!--<script src="../js/main-menu.js"></script>!-->
	<script src="../js/template.js"></script>
	<!--<script src="../js/main.js"></script>!-->
</body>
</html>