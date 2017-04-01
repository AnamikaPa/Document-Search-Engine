<?php
	session_start();
	
	if(!($_SESSION['username']=='username' && $_SESSION['email']=='')){
	$s = $_SERVER['REQUEST_URI'];
	$l = strlen($s);
	$email = substr($s,29,$l-1);
	
	//echo $email;
	$_SESSION['email']=$email;
	
	$_SESSION['update']="no";
	$host='localhost';
	$user='root';
	$pass='';
	$db='SearchEngine';

	// Create connection
	$conn = new mysqli($host,$user,$pass,$db);
	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	} 
	
	$qry = "SELECT Username FROM users WHERE email = '$email' limit 1";
	$abc = mysqli_query($conn,$qry);
	$row = mysqli_fetch_array($abc);
	//echo $row['Username'];
	$_SESSION['username']=$row['Username'];
	//echo $_SESSION['username'];
	
	
	
	$qry = "SELECT * FROM Document WHERE AUTHOR='$_SESSION[username]' ORDER BY ID desc";
	$abc = mysqli_query($conn,$qry);
	
?>
<html>
	<head>
		<title>User Page</title>
		<link rel="stylesheet" type="text/css" href="css/user_page1.css">
	</head>
	<body>
		<div id="pink">
			<div id="header">
				<a class="logo" href='index.php'></a>
				<img id ="left" src="images/logo.png" OnClick="main.php">
				<div id="right">
					
					<a class="abc" href=<?php echo "main.php?text1=".$email; ?>>Home</a>
					<a class="abc" href="logout.php">Log Out</a>
				</div>
			</div>
			
			<form action="get_started.php" method="post">
			<div id="get_started" >
				<p align="center">Want to form a new Document?</p>
					<input type="hidden" name='username' value="<?php echo $_SESSION['username']; ?>" />
					<input type="submit" name='submit' value="Get Started">		
			</div>
			
			</form>
			<br /><br /><br /><br /><br /><br /><br />
			
			<?PHP
				if(mysqli_num_rows($abc)==0){

					?>
				<div id="no"><?php echo "No Blogs yet :(";?>
				<?php }
				else{
				while($row = mysqli_fetch_array($abc)){ 
					$a = $row['DOC_URL'];
				?>	
			<div id="blog">
				<div id="cat"><?php echo $row['CATEGORY']; ?></div>
				<?php  if($row['DOCUMENT_TYPE']=='image'){ ?>
				<div id="image">
					<?php echo "<a href='$a' download='$a'><img src='$a' align='center' height=300px alt='uploads/$a'></a>";?>
				</div>
				<?php }else ?>
				<div id="abc"  >
				<?php echo "<a style='margin:auto; bacground-color:red;' href='$a' download='$a'>".$a."</a>"; ?>
				</div>
				<div id="desc">
					<h2> <?php echo $row['SUBJECT']; ?> </H2>
					<h3> <?php echo $row['TITLE']; ?> </H3>
					<?php echo substr($row['DESCRIPTION'],0,800)."....."; ?>
					<br /><br /><hr />
					<div >
					<form id="button" action="read_more.php" method="post">
						<input type="hidden" value=<?php echo $row['ID'];?> name="readmore" >
						<input type="submit" value="Read More>>>" name="submit">
					</form>
					<form id="button" action="update.php" method="post">
						<input type="hidden" value=<?php echo $row['ID'];?> name="update">
						<input type="submit" value="Update" name="submit">
					</form>
					
					<form id="button" action="read_more.php" method="post">
						<input type="hidden" value=<?php echo $row['ID'];?> name="del" >
						<input type="submit" value="Delete" name="submit2">
					</form>
					
					</div>
				</div>
			</div>
				<?PHP } }?>
		</div>

<script>
<?php
	if(isset($_SESSION["delete"]) && $_SESSION["delete"]=="yes"){
		?>alert("Successfully Deleted  :)"); <?php
		$_SESSION["delete"]="no";
	}
	if(isset($_SESSION["delete"]) && $_SESSION["delete"]=="error"){
		?>alert("Error!"); <?php
		$_SESSION["delete"]="no";
	}
	if(isset($_SESSION["re"]) && $_SESSION["re"]=="yes"){
		?>alert("Successfully sent to Admin  :)"); <?php
		$_SESSION["re"]="no";
	}
	if(isset($_SESSION["re"]) && $_SESSION["re"]=="error"){
		?>alert("Error!"); <?php
		$_SESSION["re"]="no";
	}
?>
</script>	
<?php
	if(isset($_SESSION["blog"]) && $_SESSION["blog"]=="yes"){
		?><script>alert("Your Document has been uploaded");</script><?php
		$_SESSION["blog"]="no";
	}
	}else{
		include "error_page.php"; 	
	}
?>
	</body>
</html>