<?php
	if(!isset($_SESSION)){
	   	session_start();
	}
	setcookie("username",false);
	setcookie("password",false);
	$_SESSION['username'] = null;
	$_SESSION['password'] = null;
	header("Location:main.php");
	session_destroy();
?>
