<?php
if(!isset($_SESSION)){
   	session_start();
}
?>

<!DOCTYPE html>
<html class="no-js">
<head>
	<title>Login</title>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width">

	<link rel="stylesheet" href="../css/bootstrap.min.css">
	<link href='../css/fonts.css' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="../css/leaflet.css" />
	<!--[if lte IE 8]>
		<link rel="stylesheet" href="css/leaflet.ie.css" />
	<![endif]-->
	<link rel="stylesheet" href="../css/main.css">

	<script src="../js/modernizr-2.6.2-respond-1.1.0.min.js"></script>
	<script type="text/javascript" src="../js/SHA-1.js"></script>
	<script>
		var userURL = "";
		<?php
		if (isset($_SESSION['userURL'])){
		?>
			var userURL = "<?=$_SESSION['userURL']?>";
		<?php } ?>
		function validate(f){
			var valid = true;
			var email_match=/@wpi.edu$/;
			var match = /^([0-9]|[A-Z]|[a-z]){1,20}$/;
                
			if (f.un.value == ""){
				document.getElementById('unMsg').innerHTML = "Please input your WPI email address!";
				valid = false;
			}else if (!f.un.value.match(email_match)) {
				document.getElementById('unMsg').innerText = "Only WPI email address are allowed!";
				valid = false;
			}else {
				document.getElementById('unMsg').innerHTML = "";
			}
			if (f.pwd.value == ""){
				document.getElementById('pwdMsg').innerHTML = "Please input your password!";
				valid = false;
			}else if (!f.pwd.value.match(match)) {
				document.getElementById('pwdMsg').innerText = "Only digits and letters are allowed!";
				valid = false;
			}else {
				document.getElementById('pwdMsg').innerHTML = "";
			}
			return valid;
		}
            
		function login (){
			// validate input
			var f = document.getElementById('loginForm');
			if (!validate(f)){
				console.log('input invalid');
				return false;
			}
                
			var str = f.pwd.value;
			var req = null;
			if(window.XMLHttpRequest){
				req = new XMLHttpRequest();
			} else if(window.ActiveXObject){
				req = new ActiveXObject("Microsoft.XMLHTTP");
			} else if(req == null){
				alert("Your browser does not support XML.");
			}
                
			var stateChange = function(){
				console.log(req.responseText);
				if(req.readyState == 4){
					if(req.responseText == "failure"){
						document.getElementById('loginMsg').innerHTML = "Password incorrect!";
					} else if(req.responseText == "success"){
						document.getElementById('loginMsg').innerHTML = "";
						window.location = "main.php";
					} else if(req.responseText == "No Result"){
						document.getElementById('loginMsg').innerHTML = "No record on your Email. Please register first";
				    } else{
						f.loginBtn.value = "Login";
						document.getElementById('loginMsg').innerHTML = req.responseText;
					}
				} else{                	
					f.loginBtn.value = "Loging in...";
				}

			}
                
			req.onreadystatechange = stateChange;
			req.open("POST", "../AJAX/Login.php", true);
			req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			req.send("email=" + f.un.value + "&password=" + f.pwd.value);

			// start waiting animation
		}
	</script>  
</head>
<body>
	<!-- Navigation & Logo-->
	<div class="mainmenu-wrapper">
		<div class="container">
			<nav id="mainmenu" class="mainmenu">
				<br><br/>
				<ul>
					<li class="logo-wrapper">
						<a href="../index.php"><img src="../resources/image/logo.jpeg" alt="LOGO IMG"  height="62" width="62"></a>
					</li>
					<li>
						<a href="main.php?">HOME</a>
					</li>
					<li>
						<a href="main.php?module=search">SEARCH</a>
					</li>
					<li>
						<a href="main.php?module=buy">RENT</a>
					</li>
					<li>
						<a href="main.php?module=sell">LEASE</a>
					</li>
			</ul>
			</nav>
		</div>
	</div>
		
	<!-- Page Title -->
	<div class="section section-breadcrumbs">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<h1>Login Page</h1>
				</div>
			</div>
		</div>
	</div>
        
	<div class="section">
		<div class="container">
			<div class="row">
				<div class="col-sm-5">
					<div class="basic-login">
						<form name="loginForm" id="loginForm">
							<!-- username -->
							<div class="form-group">
								<label for="login-username"><i class="icon-user"></i> <b>WPI email</b></label>
								<input class="form-control" id="un" name="un" type="text" placeholder=" "> 
								<span id="unMsg" name="unMsg" style='color:red'></span>
							</div>
							<!-- password -->
							<div class="form-group">
								<label for="login-password"><i class="icon-lock"></i> <b>Password</b></label>
								<input class="form-control" id="pwd" name="pwd" type="password" placeholder=" ">
								<span id="pwdMsg" name="pwdMsg" style='color:red'></span>
							</div>
							<!-- submit -->
							<div class="form-group">
								<a href="register.php" class="forgot-password"> Do not have an username?</a>	
								<input name="loginBtn" id="loginBtn" type="button" onclick="login()" class="btn pull-right" value="Login">
								<p id="loginMsg" style='color:red'/>
								<div class="clearfix"></div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>	

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
	<script src="../js/main-menu.js"></script>
	<script src="../js/template.js"></script>
	<script src="../js/main.js"></script>
</body>
</html>