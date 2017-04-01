<?php
	session_start();
	if($_SESSION['username']!='username' && $_SESSION['email']!=''){
?>
<html>
	<head>
		<title>Get Started</title>
		<link rel="stylesheet" type="text/css" href="css/get_started_next1.css">
	</head>
	<body>
		<div id="pink">
			<div id="header">
				<a href="main.php"></a>
				<img id ="left" src="images/logo.png" OnClick="main.php">
				<div id="right">
					<a class="abc" href=<?php echo "main.php?text1=".$_SESSION['email']; ?> title="Home"><?PHP echo "Home";?></a>
						<a class="abc" href="logout.php">Log Out</a>
				</div>
			</div>
			<div id="login">	
				<form name="myForm" action="blog_making.php" method="post" enctype="multipart/form-data">
					<input type="text" name="title" placeholder="Title" required>
					<input type="text" name="subject" placeholder="Subject" required>
					<select id="category" name="category">
						<option value="doc" selected>Document</option>
						<option value="image">Image</option>
						<option value="pdf">Pdf</option>
						<option value="ppt">Ppt</option>
						<option value="text">Text</option>
					</select></br></br>

					<textarea type="text" name="desc" placeholder="Description" required></textarea>
					Upload Document
					<input type="file" name="file" accept="application/ppt,application/doc,image/jpeg,image/png,image/tiff,image/bmp,image/gif" id="image" required>
					<input class="button" name="submit" type="submit" value="SUBMIT">
				</form>
			</div>
		</div>
	</body>
</html>
<?php
	
	if(isset($_POST['category'])){
		$_SESSION["category"] = $_POST['category'];
	}
	}else{
		include "error_page.php"; 	
	}
?>