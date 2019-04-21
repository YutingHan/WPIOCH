<?php
	if(!isset($_SESSION)){
	   	session_start();
	}
	
	$conn = mysqli_connect("localhost", "root", "","miniproject");
	if($conn->connect_error){
		echo "Unable to connect to database";
		exit;
	}
	
	$_SESSION['login'] = 0;

	$email = $_POST["email"];
	$password = $_POST["password"];
	$rst = false;
	
	$sql = "select uPassword from User where user_id=\"".$email."\"";
	$result = $conn->query($sql);
	
	if(!$result){
		die ("No Result");
	} else{
		$result->data_seek(0);
		$row = $result->fetch_assoc();
		if($password == $row['uPassword'])
		{
			$rst = true;
			$_SESSION['username'] = $email;
		    $_SESSION['password'] = $password;
		    $_SESSION['login'] = 1;
		}
	}
	
	if($rst){
		echo "success";
	}else{
		echo "failure";
 	}
?>