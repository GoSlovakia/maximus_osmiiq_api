<?php
include 'database.php';

$connection = mysqli_connect($mysql_host,$mysql_user,$mysql_password, $mysql_database);

if (!$connection)
{
	die('Could not connect: ' . mysqli_error($connection));
}

$user = $_REQUEST["user"];
$setid=$_REQUEST["setID"];

mysqli_query($connection, "SET NAMES 'utf8'");
		
mysqli_select_db($connection, $mysql_database);

$sql = "INSERT INTO UserSets (UserID, SetID) VALUES ( $user,".'"'.$setid.'"'.");";

$result = mysqli_query($connection, $sql);


if($result === FALSE)
{
   die(mysqli_error($connection)); // TODO: better error handling
}
else
	echo "Done";


mysqli_close($connection)

?>