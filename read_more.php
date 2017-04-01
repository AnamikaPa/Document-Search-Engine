<?php
	session_start();
	if($_SESSION['update']=="yes"){
		?><script>alert("You had Successfully Updated your Blog.. :)");</script><?php
		$_SESSION['update']="no";
	}
	
	if(isset($_POST['readmore'])){
	$_SESSION['id'] = $_POST['readmore'];
	}
	
	$host='localhost';
	$user='root';
	$pass='';
	$db='searchengine';

	// Create connection
	$conn = new mysqli($host,$user,$pass,$db);
	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	} 
	
	$qry = "SELECT * FROM Document WHERE ID='$_SESSION[id]'";
	$abc = mysqli_query($conn,$qry);
	$row = mysqli_fetch_array($abc);
	
?>

<html>
	<head>
		<title>Read More</title>
		<link rel="stylesheet" type="text/css" href="css/read_more.css">
	</head>
	<body>
		<div id="pink">
			<div id="header">
				<a class="logo" href="main.php"></a>
				<img id ="left" src="images/logo.png" OnClick="main.php">
				<div id="right"><?php
						if($_SESSION["username"] !="username" && $_SESSION["username"]!="Admin"){?>
							<a class="abc" href=<?php echo "main.php?text1=".$_SESSION['email']; ?> title="Home">Home</a>
							<a class="abc" href="logout.php">Log Out</a>
						<?php  }
						else if($_SESSION["username"] !="username" && $_SESSION["username"]=="Admin"){?>
							<a class="abc" href="admin.php" title="Home"><?PHP echo "Welcome ".$_SESSION["username"]."!!";?></a>
							<a class="abc" href="logout.php">Log Out</a>
						<?php  }
						else{ ?>
							<a class="abc" href="login.php">Sign In</a>
					<?php } ?>
				</div>
			</div>
			<div id="blog">
				<?PHP
					$ab = mysqli_query($conn,"SELECT * FROM document WHERE ID='$row[ID]'");	
					$de = mysqli_fetch_array($ab);
					$a = $de['DOC_URL'];
					
				?>
				
				<div id="cat"><?php echo $row['CATEGORY']; ?></div>
				<?php  if($row['DOCUMENT_TYPE']=='image'){ ?>
				<div id="image">
					<?php echo "<a style='text-align:center;' href='$a' download='$a'><img src='$a' align='center' height=300px alt='uploads/$a'></a>";?>
				</div>
				<?php }else ?>
				<div id="abc"  >
				<?php echo "<a style='margin:auto; text-align:center; bacground-color:red;' href='$a' download='$a'>".$a."</a>"; ?>
				</div>
				<div id="desc">
					<h2> <?php echo $row['SUBJECT']; ?> </H2>
					<h3> <?php echo $row['TITLE']; ?> </H3>
					<?php echo substr($row['DESCRIPTION'],0,800)."....."; ?>
					<br /><br /><hr />
					<div >
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
		</div>
	</body>
</html>



<?php 
if(isset($_POST['submit2'])){
	$qry = "delete from  Document WHERE ID='$_POST[del]'";
	$_SESSION['id'] = $_POST['del'];
	$abc = mysqli_query($conn,$qry);
	
	$_SESSION['delete']="yes";
	header("Location: main.php?text2=".$_SESSION['email']);
}
mysqli_close($conn);?>