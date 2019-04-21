<?php
	if(!isset($_SESSION)){
		session_start();
	}
	
	$conn = mysqli_connect("localhost", "root", "","miniproject");
	if($conn->connect_error){
		echo "Unable to connect to database";
		exit;
	}
	
	$user_id = $_SESSION['username'];
	$Hid = $_POST['Hid'];
	$state = $_POST['s']; 
    
    if($state == 1){
        $query =" insert into Favorite set user_id=\"".$user_id."\",Hid=".$Hid;
        $result = $conn->query($query);
	} else if($state == 2) {
        $query =" delete from Favorite where user_id=\"".$user_id."\" and Hid=".$Hid;
        $result = $conn->query($query);
	}
	
	$query = "select count(*) as d from Favorite where Hid=".$Hid;
    $result = $conn->query($query);
	if($result && $row = $result->fetch_assoc()){
		$likenum = $row['d'];
		echo $likenum;
	}else{
		echo "try again";
	}
	
   	$conn->close();
?>