<?php
    // show a list of posts
	// connect MySQL
    $servername = 'localhost';
    $username = 'root';
    $password = '';
    $database = 'miniproject';
    $conn = mysqli_connect($servername, $username, $password, $database);
    if ($conn->connect_error) {
		echo "Unable to connect to database";
		exit;
	}

    $i = 0;
	$a = array();
	
	if(isset($_SESSION['username'])){
		$query = "select * from House where user_id not in(\"".$_SESSION['username']."\")";
	}else{
		$query = "select * from House";
	}
    $result = $conn->query($query);

	if($result != null){
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

	}else{
		echo "Sorry. There is no house for rent";
	}
	
	$result->free();
   	$conn->close();
?>

<script type="text/javascript">
function addToCart(postid)
{
	var req = null;
	if(window.XMLHttpRequest){
		req = new XMLHttpRequest();
	} else if(window.ActiveXObject){
		req = new ActiveXObject("Microsoft.XMLHTTP");
	} else if(req == null){
		alert("Your browser does not support XML.");
	}
					
	var stateChange = function()
	{
		if (req.readyState == 4 && req.status == 200){
			
			alert(req.responseText);
		}
	} 
					
	req.onreadystatechange = stateChange;
	req.open("POST", "../AJAX/AddToCart.php", true);
	req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	req.send("Hid="+Hid);
}
</script>

<div class="section section-breadcrumbs">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<h1>Houses For Rent</h1>
			</div>
		</div>
	</div>
</div>

<div class='section'>
	<div class='container'>
		<div class='row'>
		<?php
 	   for($j = 0;  $j < $i; $j++){
    	?>
    		<div class='col-md-4 col-sm-6'>
				<div class='portfolio-item'>
					<!-- show item image -->
					<div class='portfolio-image' >
				    	<?php echo $a[$j]; ?> 
					</div>
					<!-- show image inforamtion -->
					<div class='portfolio-info'>
						<ul>
							<li class='portfolio-project-name'><a href='details.php?Hid=<?=$house_id[$j]?>'><?=$house_id[$j]?></a></li>
							<li>Price: <?=$house_price[$j]?></li>
							<li>Location: <?=$house_street[$j]?></li>
							<li>Posted By: <?=$house_owner[$j]?></li>
						    <li>Likes <?=$likenum[$j]?></li>
							<li class='read-more'><a href='details.php?Hid=<?=$house_id[$j]?>' class='btn' target='_self'>Read More</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
		<?php } ?>
		</div>
	</div>
</div>