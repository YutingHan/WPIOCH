<?php
	if(!isset($_SESSION)){
		session_start();
	}
	
	$conn = mysqli_connect("localhost", "root", "","miniproject");
	if($conn->connect_error){
		echo "Unable to connect to database";
		exit;
	}
	
	$username = $_SESSION['username'];
	$Hid = $_POST['Hid'];
	#$replyid = $_POST['replyid'];
	$content = $_POST['content']; 

	$query = "select max(CommentSeq) as d from Comment where Hid=\"".$_POST['Hid']."\"";
    $result = $conn->query($query);
	if($result && $row = $result->fetch_assoc()){
		$commentseq = $row['d'] + 1;
		$result->free();
		
		$query = "insert into Comment set user_id=\"".$username."\",Hid=".$Hid.",content=\"".$content."\",CommentSeq=".$commentseq;
		if($result = $conn->query($query)){
			echo "reply succeed";
		}else{
			echo "reply fail";
		}
	}else{
		echo "reply fail";
	}
	
   	$conn->close();
?>