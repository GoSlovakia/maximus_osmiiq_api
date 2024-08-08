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

$sql = "SELECT Redeemed FROM DailyQuiids WHERE UserID=$user";

$result = mysqli_query($connection, $sql);


$rowAmount = mysqli_fetch_assoc($result);
if($result === FALSE)
{
	echo 0;
    	die(mysqli_error($connection)); // TODO: better error handling
}
else{
	if($rowAmount["Redeemed"]!="")
		echo $rowAmount["Redeemed"];
	else
		echo 0;
}

mysqli_close($connection)

?>