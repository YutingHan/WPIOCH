<?php
	if(!isset($_SESSION)){
		session_start();
	}
	
	$conn = mysqli_connect("localhost", "root", "","miniproject");
	if($conn->connect_error){
		echo "Unable to connect to database";
		exit;
	}
	
	$mode = $_GET['Mode'];
	$i = 0;

	if($mode){
		
		if ($_GET['Category']=='With Parking Lot'){
			$query = "select * from House where Hid in (SELECT Hid from Utilities where length(Parking)>0)";
		}
		elseif ($_GET['Category']=='Gym in 1 mile') {
			$query = "select * from House where Hid in (SELECT Hid from School_Distance where Gym_Distance<1)";
		}
		else{
			$query = "select * from House where Hid in (SELECT Hid from School_Distance where Library_Distance<1)";
		}
	
		$result = $conn->query($query);
		if($result){
			while ($row = $result->fetch_assoc()) {
			  $house_id[$i]=$row['Hid'];
			  $house_street[$i]=$row['Street'];
			  $house_owner[$i]=$row['user_id'];
			  $house_description[$i]=$row['description'];
			  $house_image[$i]=$row['image'];
			  $house_updatetime[$i]=$row['updatetime'];
			  $house_category[$i]=$row['category'];
			  $house_price[$i]=$row['price'];
			  $house_id[$i]=$row['Hid'];
				
				$query = "select count(*) as likenum from Favorite where Hid=".$house_id[$i];
				$result2 = $conn->query($query);
				if($result2 != null){
					$row2 = $result2->fetch_assoc();
					$likenum[$i] = $row2['likenum'];
				}else{
					$likenum[$i] = 0;
				}	
				$result2->free();
				
				$a[$i] = "<img src='../resources/image/".$house_image[$i]."' height=\"100\" width=\"150\" >";
				$i++;
			}
		}
	}
	else{
		#$search = explode(' ',strtolower($_GET['PostTitle']));
		
			$query = "select * from House where Street like \"%".$_GET['PostTitle']."%\"";
		
	
		$result = $conn->query($query);
		if($result){
			while ($row = $result->fetch_assoc()) {
			  $house_id[$i]=$row['Hid'];
			  $house_street[$i]=$row['Street'];
			  $house_owner[$i]=$row['user_id'];
			  $house_description[$i]=$row['description'];
			  $house_image[$i]=$row['image'];
			  $house_updatetime[$i]=$row['updatetime'];
			  $house_category[$i]=$row['category'];
			  $house_price[$i]=$row['price'];
			  $house_id[$i]=$row['Hid'];
				
				$query = "select count(*) as likenum from Favorite where Hid=".$house_id[$i];
				$result2 = $conn->query($query);
				if($result2 != null){
					$row2 = $result2->fetch_assoc();
					$likenum[$i] = $row2['likenum'];
				}else{
					$likenum[$i] = 0;
				}	
				$result2->free();
				
				$a[$i] = "<img src='../resources/image/".$house_image[$i]."' height=\"100\" width=\"150\" >";
				$i++;
			}
		}
			
		
	}
	
	if($i > 0){
		echo "<div class='container'>";
		echo "<div class='row'>";
		for($j = 0;  $j < $i; $j++){
			echo "<div class='col-md-4 col-sm-6'>";
			echo "<div class='portfolio-item'>";
			// show item image
			echo "<div class='portfolio-image' >";
			echo $a[$j]; 
			echo "</div>";
			// show image inforamtion
			echo "<div class='portfolio-info'>";
			echo "<ul>";
			echo "<li class='portfolio-project-name'><a href='details.php?Hid=".$house_id[$j]."'>".$house_id[$j]."</a></li>";
			echo "<li>Price: ".$house_price[$j]."</li>";
			echo "<li>Location: ".$house_street[$j]."</li>";
			echo "<li>Posted By: ".$house_owner[$j]."</li>";
			#echo "<li>Posted On: ".$house_updatetime[$j]."</li>";     
			#echo "<li>Category: ".$house_category[$j]."</li>";
			echo "<li>Likes ".$likenum[$j]."</li>";
			#echo "<li class='read-more'><a href='details.php?Hid=".$house_id[$j]." class='btn' target='_self'>Read More</a>";
			
			#echo "<class='add-to-cart'><a class='btn' onclick=addToCart(".$item_id[$j].")>Add to Cart</a></li>";
			#echo "<li class='read-more'><a href='details.php?Hid=".$house_id[$j]." class="."'".btn."'"." target='_self'>Read More</a></li>";
			//echo "<class='add-to-cart'><a class='btn' onclick=addToCart(".$house_id[$j].")>Add to Cart</a></li>";
			echo "</ul>";
			echo "</div>";
			echo "</div>";
			echo "</div>";
		}
		echo "</div>";
		echo "</div>";
	}else{
		echo "<h1>No Result!</h1>";
		#echo ($_GET['PostTitle']);
	}
?>