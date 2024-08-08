<?php
include 'database.php';

$connection = mysqli_connect($mysql_host,$mysql_user,$mysql_password, $mysql_database);

if (!$connection)
{
	die('Could not connect: ' . mysqli_error($connection));
}

mysqli_query($connection, "SET NAMES 'utf8'");
		
mysqli_select_db($connection, $mysql_database);

$sql = "INSERT INTO UserColors (UserID, PrimaryColor, SecondaryColor) VALUES (".$_REQUEST["user"].',"'.$_REQUEST["primary"].'","'.$_REQUEST["secondary"].'") ';
$sql .= 'ON DUPLICATE KEY UPDATE PrimaryColor = "' .$_REQUEST["primary"].'", SecondaryColor = "' .$_REQUEST["secondary"].'";';

$result = mysqli_query($connection, $sql);

if($result === FALSE)
{
    die(mysqli_error($connection)); // TODO: better error handling
}
else
	return "Done";

mysqli_close($connection)

?>