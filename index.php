<?php
	if(!isset($_SESSION)){
    	session_start();   	
	}
    header("Location:src/main.php");
?>