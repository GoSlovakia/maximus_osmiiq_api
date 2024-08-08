<?php
include 'database.php';

$connection = mysqli_connect($mysql_host,$mysql_user,$mysql_password, $mysql_database);

if (!$connection)
{
	die('Could not connect: ' . mysqli_error($connection));
}

mysqli_query($connection, "SET NAMES 'utf8'");
		
mysqli_select_db($connection, $mysql_database);

$user=$_REQUEST["user"];

$sql = "INSERT INTO DailyQuiids (UserID, Redeemed, Consecutive) VALUES ($user,1,0)
 ON DUPLICATE KEY UPDATE Redeemed = 1, Consecutive = Consecutive+1;";

$result = mysqli_query($connection, $sql);

if($result === FALSE)
{
    die(mysqli_error($connection)); // TODO: better error handling
}
else
	return "Done";

mysqli_close($connection)

?>