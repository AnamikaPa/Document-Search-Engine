<?php
	session_start();
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

	if($_POST['action'] == "Registration"){
		if($_POST['radio']=="female") $gender = "Female";
		else $gender = 'Male';
		
		$encryp = sha1(md5($_POST['Password']));
		
		$abc = mysqli_query($conn,"SELECT * FROM users WHERE BINARY Username='$_POST[Username]'");
		$def = mysqli_query($conn,"SELECT * FROM users WHERE BINARY Email='$_POST[Email]'");
		
		if(mysqli_num_rows($abc)!=0){
			echo "This Username is already in use<br>";
		}
		if(mysqli_num_rows($def)!=0){
			echo "This Email is already in use";
		}
		else{
			$sql = "INSERT INTO users(Username,Email,Password,Gender,CreationDate,UpdatedDate,IsAdmin) 
			VALUES('$_POST[Username]','$_POST[Email]','$encryp','$gender',CURDATE(),CURDATE(),0)";

			if ($conn->query($sql) === TRUE) {
				$_SESSION['register']="yes";
				$_SESSION['username']=$_POST['Username'];
				echo "done";
			} else {
				echo "Error in Registration";
			}
		}
	}
	else{
			$encryp = sha1(md5($_POST['Password']));
			$abc = mysqli_query($conn,"SELECT * FROM users WHERE BINARY Email='$_POST[Email]' and BINARY Password = '$encryp'");
			
			if(mysqli_num_rows($abc)!=0){
				$_SESSION['email'] = $_POST['Email'];
				echo "done";
			}
			else echo "Username and Password does not match";
	}
	$conn->close();
?>