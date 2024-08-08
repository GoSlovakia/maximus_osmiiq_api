<?php
include 'database.php';

if(isset($_REQUEST["username"]) && isset($_REQUEST["password"]))
{
	$connection = mysqli_connect($mysql_host,$mysql_user,$mysql_password, $mysql_database);

	if (!$connection)
	{
		die('Could not connect: ' . mysqli_error($connection));
	}

	mysqli_query($connection, "SET NAMES 'utf8'");
			
	mysqli_select_db($connection, $mysql_database);

	$sql = 'SELECT id, role FROM users WHERE username="'.$_REQUEST["username"].'" AND password="'.$_REQUEST["password"].'";';

	//echo $sql;
	$result = mysqli_query($connection, $sql);

	if($result === FALSE)
	{
		die(mysqli_error($connection)); // TODO: better error handling
	}

	$resultArray = array();

	while($row = mysqli_fetch_assoc($result))
		$resultArray[] = $row;


	mysqli_close($connection);
	
	if(isset($resultArray[0]["id"]))
	{
		echo json_encode($resultArray);
	}
	else
		return301();
}
else
	return301();

function return301()
{
	ob_start();
	header('HTTP/1.0 401 Unauthorized');
	echo 'Unauthorized';
	exit;
	
}
?>