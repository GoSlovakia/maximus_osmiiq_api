<?php
    header("Access-Control-Allow-Origin: *");
    $total = count($_FILES['files']['name']);
    $uploadError = false;
	/*
	include 'database.php';

	$connection = mysqli_connect($mysql_host,$mysql_user,$mysql_password, $mysql_database);

	if (!$connection)
	{
		die('Could not connect: ' . mysqli_error($connection));
	}

	mysqli_query($connection, "SET NAMES 'utf8'");
			
	mysqli_select_db($connection, $mysql_database);

	$sql = "SELECT svalue FROM settings WHERE skey = 'JPEG_FOLDER' LIMIT 1;";

	$result = mysqli_query($connection, $sql);

	if($result === FALSE)
	{
		die(mysqli_error($connection)); // TODO: better error handling
	}

	$value = mysqli_fetch_assoc($result);
	

	mysqli_close($connection);
	*/

    $target_dir = "PNGs/";
	$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
	$uploadOk = 1;
	$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
	// Check if image file is a actual image or fake image
	if(isset($_POST["submit"])) {
	  $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
	  if($check !== false) {
		echo "File is an image - " . $check["mime"] . ".";
		$uploadOk = 1;
	  } else {
		echo "File is not an image.";
		$uploadOk = 0;
	  }
}
	
?>