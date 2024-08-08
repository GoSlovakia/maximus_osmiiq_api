<?php
include'database.php';

$connection = mysqli_connect($mysql_host,$mysql_user,$mysql_password,$mysql_database);

if(!$connection)
{
	die('Could not connect: ' . mysqli_error($connection));
}

mysqli_query($connection, "SET NAMES 'utf8'");

mysqli_select_db($connection, $mysql_database);

$sql = "SELECT COUNT(id) FROM cards";

$results = mysqli_query($connection,$sql);

if($results === false)
{
	die(mysqli_error($connection)); // TODO: better error handling
}

/*$resultArray = array();

while($row = mysqli_fetch_assoc($results))
{
	$resultArray[] = $row;
}*/
$row = mysqli_fetch_assoc($results);

echo $row['COUNT(id)'];

mysqli_close($connection)
?>