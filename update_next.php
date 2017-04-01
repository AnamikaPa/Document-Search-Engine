<?php

if(isset($_POST['submit1'])){
	$file_name=$_FILES['file']['name'];
		$file_temp=$_FILES['file']['tmp_name'];
		$target_dir="uploads/";
		$target_file = $target_dir . basename($file_name);
		$content=$_POST['title']." ".$_POST['subject']." ".$_POST['category']." ".$_POST['desc']." ".$_SESSION['category']." ";

	if(move_uploaded_file($file_temp,$target_file)){;
			if($_SESSION["category"]=='pdf'||$_SESSION["category"]=='doc'){
				$docObj = new Filetotext($target_file);
				$content.= $docObj->convertToText();
			}
			else if($_SESSION["category"]=='text'){
				$content.=file_get_contents($target_file);	
			}
		}
		
	$qry = "UPDATE Document SET TITLE='$_POST[title]',CONTENT ='$content',DOC_URL='$target_file',CATEGORY='$_POST[category]',SUBJECT='$_POST[subject]',DESCRIPTION='$_POST[desc]',UPDATED_DATE=CURDATE() WHERE ID='$_POST[ID]'";
	$_SESSION['id'] = $_POST['ID'];
	$abc = mysqli_query($conn,$qry);
	
	if($abc) echo "success";
	mysqli_close($conn);
	$_SESSION['update']="yes";
	header("Location: read_more.php");
}

?>