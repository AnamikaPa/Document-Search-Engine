<?php
	
	if($_SERVER['REQUEST_METHOD'] == "POST"){
		if($_POST['a'] == 'doc_type'){
			echo '<select ng-model="cat" id="search" name="search">
					<option value="doc" selected>Doc</option>
					<option value="image">Image</option>
					<option value="pdf">Pdf</option>
					<option value="ppt">Ppt</option>
					<option value="text">Text</option>
				</select></br></br>';
		}
		else if($_POST['a'] == 'cat'){
					
			echo '<select ng-model="cat" id="search" name="search">
					<option selected>Business & Services</option>
					<option >Health & Wellness</option>
					<option >Art & Entertainment</option>
					<option >Education & Organizations</option>
					<option >Family,Home & Lifestyle</option>
					<option >Writing & Books</option>
					<option >Politics & Policy</option>
				</select></br></br>';
		}
		else if($_POST['a']=='creation_date')echo '<input ng-model="cat" type="date"  id="search" name="search"  required="required"/><br><br>';
		else if($_POST['a']=='author' || $_POST['a']=='subject' || $_POST['a'] = 'doc_title'){
			echo '<input type="text" ng-model="cat" id="search" name="search" placeholder="Search*" required="required" maxlength="100"/><br><br>';
		}
	}
?>