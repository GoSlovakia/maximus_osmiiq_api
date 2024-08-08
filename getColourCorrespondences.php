<?php
include 'database.php';

$connection = mysqli_connect($mysql_host,$mysql_user,$mysql_password, $mysql_database);

if (!$connection)
{
	die('Could not connect: ' . mysqli_error($connection));
}

mysqli_query($connection, "SET NAMES 'utf8'");
		
mysqli_select_db($connection, $mysql_database);

$sql = "SELECT code, variation, xtermindex FROM colourcorrespondences;";

$result = mysqli_query($connection, $sql);

if($result === FALSE)
{
    die(mysqli_error($connection)); // TODO: better error handling
}

$resultArray = array();

while($row = mysqli_fetch_assoc($result))
{
	$resultArray[] = $row;
}

echo json_encode($resultArray);

mysqli_close($connection)

?>