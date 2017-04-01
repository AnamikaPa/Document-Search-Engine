<?php
	$c = $_POST['category'];
	//echo $_POST['search'];
	
	$host='localhost';
	$user='root';
	$pass='';
	$db='SearchEngine';

	// Create connection
	$con = new mysqli($host,$user,$pass,$db);
	// Check connection
	if ($con->connect_error) {
		die("Connection failed: " . $cnn->connect_error);
	} 
	
	$data = json_decode(file_get_contents("php://input"));
	$a=$_POST['search'];
	
	$search_exploded = explode ( " ", $a );
	$x = 0; 
	$construct = "";

	if($c == 'author') $d = 'AUTHOR';
	else if($c =='subject') $d = 'SUBJECT';
	else if($c == 'title') $d = 'TITLE';
	else if($c == 'doc_type') $d = 'DOCUMENT_TYPE';
	else if($c == 'cat') $d = 'CATEGORY';
	else $d = 'CREATION_DATE';
	
	
	//echo $c;
	//echo $d;
	foreach( $search_exploded as $search_each ){ 
		$x++; 
		if( $x == 1 ) 
			$construct .="$d LIKE '%$search_each%'"; 
		else 
			$construct .="AND $d LIKE '%$search_each%'"; 
	} 
	
	//echo $construct;
	$query = " SELECT * FROM document WHERE $construct";

	$result = mysqli_query($con,$query);
	$num= mysqli_num_rows($result);
	//echo $num;
	
	$output = "";
	if(mysqli_num_rows($result)>0){
		while($row = mysqli_fetch_array($result)){
			
			$cat = $row['CATEGORY'];
			$url = $row['DOC_URL'];
			$sub = $row['SUBJECT'];
			$title = $row['TITLE'];
			$desc = $row['DESCRIPTION'];
			$output .="<div id='blog'> <div id='cat'> $cat </div> <a id='link' href=$url download=$url >$url </a><div id='desc'><h2> $sub</H2><h3> $title</H3>$desc</div></div>";
		}
		echo $output;
	}
	else{
		echo "<H2 style='color:black; opacity:0.7;filter:alpha(opacity=70);padding:10px;font-size:25px;	background-color:white;	margin-left:45%; auto;width:20%;text-align:center;
' >No Result Found</H2>";
	}
?>