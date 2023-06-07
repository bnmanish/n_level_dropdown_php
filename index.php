<?php
	ini_set('display_errors', '1');
	// database connection 
	$host = "localhost";
	$db_user_name = "developermanish95@gmail.com";
	$db_user_password = "Manish@@2020";
	$db_name = "n_level_dropdown";
	$conn = mysqli_connect($host,$db_user_name,$db_user_password,$db_name);
	if(!$conn){
		echo "database connection error";
		die;
	}

	// insert category data in database
	if(isset($_POST['submit'])){
		$category = $_POST['category'];
		$name = $_POST['name'];
		$qry = "insert into categories (parent_id,name) values ('".$category."','".$name."')";
		$res = mysqli_query($conn,$qry);
		if($res){
			echo "Category added!";
		}

	}

	// creating recursion function to create a tree of category
	function categoryTree($parent_id=0,$prefix=""){
		global $conn;
		$qry2 = "select * from categories where parent_id='".$parent_id."' order by name";
		$res2 = mysqli_query($conn,$qry2);
		if(mysqli_num_rows($res2) > 0){
			while($row = mysqli_fetch_array($res2)){
				echo $options = "<option value='".$row['id']."'>".$prefix.$row['name']."</option>";
				categoryTree($row['id'],$prefix.'&nbsp;&nbsp;&nbsp;');
			}
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>N Level Dynamic Dropdown</title>
</head>
<body>
	<form method="post">
		Category : 
		<select name="category">
			<option value="0">-- Select --</option>
			<?php categoryTree() ?>
		</select>
		<br>
		name : 
		<input type="text" name="name">
		<br>
		<input type="submit" name="submit">
	</form>

</body>
</html>