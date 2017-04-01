<?php
	session_start();
	$_SESSION["username"] = "username";
	$_SESSION["logout"] = "logout";
	$_SESSION['email']="";
	header("Location: index.php");
?>