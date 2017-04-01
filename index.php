<script>
	<?php
	session_start();
	
	if($_SESSION["logout"]=="logout"){
		?> alert("You have Sucessfully logged out");<?php
		$_SESSION["logout"] = "loggedin";
	}
	if($_SESSION["username"]=='') $_SESSION["username"] ="username";
	echo $_SESSION['username'];
	?>
</script>
<script src="js/jquery2.0.3.min.js"></script>
<script src="js/angular.min.js"></script>

<script>
	var app = angular.module('myApp',[]);
	app.controller('cntrl',function($scope,$http){
		$scope.search = function(){
			$http.post("search.php",{'a':$scope.keywords})
			.success(function(data){
				if(data!='')$scope.data1 = data;
				else alert("Not Found!");
			});
		}
		
		});
</script>

<style>	
#pink{
	background-color:grey;
}
#middle{
	background-color: white;
	width:25%;
	margin-left: 44%;
	border-radius: 9px;
	padding:0 0 9px 0;
	color:black;
}

#middle h2{
	border-radius: 9px 9px 0 0;
	padding:10px;
}

#middle select, #middle input{
	width:90%;
	height: 30px;
	border-radius:5px;
}

#middle button{
	background-color: rgb(52,173,236);
	width:50%;
	height: 36px;
	color:white;
	border-radius:5px;
}

</style>

<html ng-app = "myApp" >
	<script src="angular.min.js"></script>
	<script src="search.js"></script>
	<head>
		<title>Search Engine</title>
		<link rel="stylesheet" type="text/css" href="css/main1.css">
	</head>
	
	<body ng-controller="cntrl">
		<div id="pink">
			<div id="header">
				<img id ="left" src="images/logo.png" OnClick="main.php" />
				<div id ="right">
					
					<?php
						if(isset($_SESSION["email"]) && $_SESSION["username"] !="username" && $_SESSION["username"]!="Admin"){?>
							<a class="abc" href=<?php echo "main.php?text1=".$_SESSION['email']; ?> title="Home"><?PHP echo "Welcome ".$_SESSION["username"]."!!";?></a>
							<a class="abc" href="logout.php">Log Out</a>
						<?php  }
						else{ ?>
							<a class="abc" href="login.php">Sign In</a>
					<?php } ?>
				</div>
			</div>
			
			<form class="searchform cf">
				<input  ng-model="keywords" type="text" placeholder="Is it me you’re looking for?" required />
				<button type="submit" id="show" ng-click="search()">Search</button>
			</form>
						
			
			<form type="post">
				<button class="advance" type="submit">Advance Search</button>
			</form>
			
			<div id ="middle" align="center">
				<div class="login" >
					<h2 id="form" style="color:white; background-color:royalblue">Advanced</h2>
					<form class="form_settings" name="myForm2">
						<label> Select Type:<br> </label>
						<select id="category" name="category" ng-model="category"  >
							<option value="author" selected>Author</option>
							<option value="cat">Category</option>
							<option value="doc_type">Document Type</option>
							<option value="subject">Subject</option>
							<option value="doc_title">Title</option>
							<option value="creation_date" >Creation Date</option>
						</select></br></br>
						<!--
						<div style='color:white; padding:-20px;'>{{ a = category=='author' || category == 'subject' || category == 'doc_title'; }}</div>
							<input ng-if =(a) type="text" ng-model="cat2" id="search" name="search" placeholder="Search*" required="required" maxlength="100"/><br><br>
						
						<div ng-if =(category=='doc_type')>
							<select ng-model="cat" id="search" name="search">
								<option value="doc" selected>Doc</option>
								<option value="image">Image</option>
								<option value="pdf">Pdf</option>
								<option value="ppt">Ppt</option>
								<option value="text">Text</option>
							</select></br></br>
						</div>
						<div ng-if =(category=='creation_date')>
							<input ng-model="cat3" type="date"  id="search" name="search"  required="required"/><br><br>
						</div>
						
						<input type="text" ng-model="cat2" id="search" name="search" placeholder="Search*" required="required" maxlength="100"/><br><br>
						-->
						<div id="inp"></div>
						<button type = 'button' id="abc" class="submit1" >Search</button>
						
					</form>
				</div>
			</div>
			
			<div id="hide">
			<div id="blog"  ng-repeat ="doc in data1" >
				<div id="cat">{{ doc.CATEGORY }}</div>
				<a id='link' href='{{ doc.DOC_URL }}' download='{{ doc.DOC_URL }}' >{{ doc.DOC_URL }} </a>
				
				<div id="desc">
					<h2> {{ doc.SUBJECT }}</H2>
					<h3> {{ doc.TITLE }} </H3>
					{{ doc.DESCRIPTION }}
				</div>
			</div>
			</div>
			<div id="blog2">
			
			</div>
			
		</div>
	</body>
</html>

<script>
		$(document).ready(function(){
			$("#middle").hide();
		});
		$(".advance").click(function(){
			$("#middle").show();
			
		});
		$("#category").change(function(){
			var a = $('#category').val();
			var data = 'a='+a;
			$.ajax({
				method:"post",
				url: "select.php?",
				data: data,
				success: function(data){
					$("#inp").html(data);
				}
			});
		});
		$(".advance").click(function(){
			$("#hide").hide();
		});
		$("#show").click(function(){
			$("#hide").show();
			$("#blog2").hide();
		});
		$("#abc").click(function(){
			$("#blog2").show();
		});
		$("#abc").click(function(){
			var data = $(".form_settings").serialize();
			$("#hide").hide();
			$.ajax({
				method:"post",
				url: "advance_next.php?",
				data: data,
				success:function(data){
					$("#blog2").html(data);
				}
			});
		});
		
</script>		
