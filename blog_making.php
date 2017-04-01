<?php
	session_start();
	if(isset($_POST['title'])){
		echo $_POST['title'];
	}
	if(isset($_POST['desc'])){
		echo $_POST['desc'];	
	}
	echo $_SESSION['username'];
	echo $_SESSION["category"];
	echo $_SESSION['email'];
	echo $_POST['subject'];
	echo $_POST['desc'];
	echo $_POST['category'];
	
	if(isset($_POST['submit'])){
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
		
		//to store the info into bloggerInfo
		$abc = mysqli_query($conn,"SELECT * FROM users WHERE (BINARY USERNAME='$_SESSION[username]') ");
		$def = mysqli_fetch_array($abc);
		echo $def['Username'];
				/*ECHO $image_name=$_FILES['image']['name'];
				ECHO $image_type=$_FILES['image']['type'];
				ECHO $image_size=$_FILES['image']['size'];
				ECHO $image_tmp_name=$_FILES['image']['tmp_name'];
				
				if($image_name=='' && $image_size==false){
					echo "<script> alert('plz apload an image'); </script>";
				}
				else{
					move_uploaded_file($image_tmp_name,"images/$image_name");
					echo "image Uploaded";
				}
				*/
				
		$file_name=$_FILES['file']['name'];
		$file_temp=$_FILES['file']['tmp_name'];
		$target_dir="uploads/";
		$target_file = $target_dir . basename($file_name);
		$content=$_POST['title']." ".$_POST['subject']." ".$_POST['category']." ".$_POST['desc']." ".$_SESSION['category']." ".$target_file." ";

		if(move_uploaded_file($file_temp,$target_file)){;
			if($_SESSION["category"]=='pdf'||$_SESSION["category"]=='doc'){
				$docObj = new Filetotext($target_file);
				$content.= $docObj->convertToText();
			}
			else if($_SESSION["category"]=='text'){
				$content.=file_get_contents($target_file);	
			}
		}	
			ECHO $def['Username'];
			
			$sql = mysqli_query($conn,"INSERT INTO Document(USER_ID,TITLE,SUBJECT,DOCUMENT_TYPE,DESCRIPTION,CATEGORY,DOC_URL,CONTENT,AUTHOR,CREATION_DATE,UPDATED_DATE)
			VALUES ('$def[UserId]','$_POST[title]','$_POST[subject]','$_POST[category]','$_POST[desc]','$_SESSION[category]','$target_file','$content','$def[Username]',CURDATE(),CURDATE())");
			$_SESSION["blog"]="yes";
		
			ECHO $def['Username'];
		
		
		if ($sql) {
			//?><H1 align="center" id="sub1">You successfully formed blog in.. :)</B></U></H1> <?php
		
		} else {
			echo htmlspecialchars (mysql_error ());
			?><H1 align="center" id="sub1">unable to form blog</B></U></H1> <?php
		}
		echo $def['Email'];
		header("Location: main.php?text1=".$def['Email']);
	}
?>