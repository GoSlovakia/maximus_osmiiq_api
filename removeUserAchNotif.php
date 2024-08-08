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
$sql = "DELETE FROM AchNotif WHERE user=$user AND achid=".'"'.$_REQUEST["achid"].'"'."; UPDATE UserNotifs SET achievements=(SELECT COUNT(*) FROM AchNotif WHERE user=$user) WHERE user=$user;";


mysqli_multi_query($connection, $sql);

$result = mysqli_store_result($connection); 

if($result === FALSE)
{
    die(mysqli_error($connection)); // TODO: better error handling
}
else
	return "Done";



mysqli_close($connection)

?>