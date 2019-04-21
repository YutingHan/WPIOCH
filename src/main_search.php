<script>
function search(mode,category)  {
		// mode: 0 Title/ 1 Category
		
		var xmlHttp = null;
		var url;
		
		// XMLHttpRequest initilization
		if(window.XMLHttpRequest){
			xmlHttp = new XMLHttpRequest();
		}else if(window.ActiveXObject){
			xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
		}
		
		if(xmlHttp != null){
			xmlHttp.onreadystatechange = function(){
				if(xmlHttp.readyState == 4 && xmlHttp.status == 200){
					document.getElementById("searchMessage").innerHTML = xmlHttp.responseText;
				}
			}
			
			// mode 0 is to search with user's input
			// mode 1 is to search specific predefined classification
			if (mode == 0){
				if(document.getElementById("searchTitle").value == ""){
					document.getElementById("searchMessage").innerHTML = "<div class='error-page-wrapper'>Please input your criteria</div>";
					return;
				}else{
					document.getElementById("searchMessage").innerHTML = "";
					url = "../AJAX/search.php?Mode=0&PostTitle=" + document.getElementById("searchTitle").value;
				}
			}else if (mode == 1){
				url="../AJAX/search.php?Mode=1&Category=" + category;
			}
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
		}else{
			alert("Your browser does not support XML!");
		}
	}
</script>
<div class="section section-breadcrumbs">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<h1>Search</h1>
			</div>
		</div>
	</div>
</div>

<div class='section'>
	<div class='container'>
		<div class='row' style='padding-left:22.5%'>
			<div class='col-sm-9 blog-sidebar' >
				<h4 style='text-align:center'>Search by street</h4>
				<form>
					<!--input type='text' display='none'-->
					<div class='input-group'>
						<input type='text' id='searchTitle' class='form-control' style='text-align: left' onkeydown="if(event.keyCode==13){return false;}">
						
						<span class='input-group-btn'>
							<input type='button' value='search' onclick='search(0,0)' class='btn'>
						</span>
					
					</div>
				</form>
				
				<h4 style='display: inline'>&nbsp&nbspCategories:&nbsp&nbsp</h4>
				<span class='blog-categories'>
				<?php
					for($k=0;$k<count($categoryArray);$k++){
				?>
				<span style='cursor: pointer' onclick='search(1,"<?=$categoryArray[$k]?>")'> <?=$categoryArray[$k]?> &nbsp/&nbsp </span>
				<?php } ?>
				</span>
				
			</div>
		</div>
	</div> 
</div>

<div class="section">
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<div id='searchMessage'></div>				
			</div>
		</div>
	</div>
</div>

