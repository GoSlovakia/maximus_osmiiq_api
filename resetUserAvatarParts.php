<?php
include 'database.php';

if(isset($_REQUEST["user"]))
{
	$connection = mysqli_connect($mysql_host,$mysql_user,$mysql_password, $mysql_database);

	if (!$connection)
	{
		die('Could not connect: ' . mysqli_error($connection));
	}

	mysqli_query($connection, "SET NAMES 'utf8'");
			
	mysqli_select_db($connection, $mysql_database);

	$sql = "DELETE FROM useravatarparts WHERE user = " . $_REQUEST["user"];

	$result = mysqli_query($connection, $sql);

	if($result === FALSE)
	{
		die(mysqli_error($connection)); // TODO: better error handling
	}
	else
		return "Done";

	mysqli_close($connection);
}
?>