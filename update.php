<?php
	session_start();
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
	$_SESSION['id']=$_POST['update'];
	
	$qry = "SELECT * FROM Document WHERE ID='$_SESSION[id]'";
	$abc = mysqli_query($conn,$qry);
	$row = mysqli_fetch_array($abc);
	$r_title = $row['TITLE'];
	$r_sub = $row['SUBJECT'];
	$r_desc = $row['DESCRIPTION'];
	$r_cat = $row['CATEGORY'];
?>

<html>
	<head>
		<title>Get Started</title>
		<link rel="stylesheet" type="text/css" href="css/update1.css">
	</head>
	<body>
		<div id="pink">
			<div id="header">
				<a class="logo" href="main.php"></a>
				<img id ="left" src="images/logo.png" OnClick="main.php">
				<div id="right">
					<a class="abc" href = <?php echo "main.php?text1=".$_SESSION['email']; ?> >Home</a>
					<a class="abc" href="logout.php">Log Out</a>
				</div>
			</div>
			<div id="login">	
				<form name="myForm" action="update.php" method="post" enctype="multipart/form-data">
					<input type="text" name="title" placeholder="Title" value = "<?=$r_title ?>" required>
					<input type="text" name="subject" placeholder="Subject" value = "<?=$r_sub ?>" required>
					<select id="category" name="category" value = "<?=$r_cat ?>">
						<option value="doc" selected>Document</option>
						<option value="image">Image</option>
						<option value="pdf">Pdf</option>
						<option value="ppt">Ppt</option>
						<option value="text">Text</option>
					</select></br></br>
					<input type="hidden" value=<?php echo $_SESSION['id'];?> name='ID'>
					<textarea type="text" name="desc" placeholder="Description" required><?php echo $r_desc; ?></textarea>
					Upload Document
					<input type="file" name="file" accept="application/ppt,application/doc,image/jpeg,image/png,image/tiff,image/bmp,image/gif" id="image" required>
					<input class="button" name="submit1" type="submit" value="SUBMIT">
				</form>
			</div>
		</div>
	</body>
</html>

<?PHP
if(isset($_POST['submit1'])){
	$file_name=$_FILES['file']['name'];
		$file_temp=$_FILES['file']['tmp_name'];
		$target_dir="uploads/";
		$target_file = $target_dir . basename($file_name);
		$content=$_POST['title']." ".$_POST['subject']." ".$_POST['category']." ".$_POST['desc']." ".$_SESSION['category']." ";

	echo $target_file;
	echo $content;
	
	if(move_uploaded_file($file_temp,$target_file)){;
			if($_SESSION["category"]=='pdf'||$_SESSION["category"]=='doc'){
				$docObj = new Filetotext($target_file);
				$content.= $docObj->convertToText();
			}
			else if($_SESSION["category"]=='text'){
				$content.=file_get_contents($target_file);	
			}
		}
		
	$qry = "UPDATE Document SET TITLE='$_POST[title]',CONTENT ='$content',DOC_URL='$target_file',DOCUMENT_TYPE='$_POST[category]',SUBJECT='$_POST[subject]',DESCRIPTION='$_POST[desc]',UPDATED_DATE=CURDATE() WHERE ID='$_POST[ID]'";
	$_SESSION['id'] = $_POST['ID'];
	$abc = mysqli_query($conn,$qry);
	
	if($abc) echo "success";
	else echo "Error";
	
	mysqli_close($conn);
	
	
	$_SESSION['update']="yes";
	header("Location: read_more.php");
}
?>