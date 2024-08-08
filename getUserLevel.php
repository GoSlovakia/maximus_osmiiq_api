<?php
include 'database.php';

$connection = mysqli_connect($mysql_host,$mysql_user,$mysql_password, $mysql_database);

if (!$connection)
{
	die('Could not connect: ' . mysqli_error($connection));
}

mysqli_query($connection, "SET NAMES 'utf8'");
		
mysqli_select_db($connection, $mysql_database);

$sql = "SELECT XP,UserLevel FROM UserLevel WHERE id = ".$_REQUEST["user"].";";

$result = mysqli_query($connection, $sql);


$resultArray = array();

while($row = mysqli_fetch_assoc($result))
{
	$resultArray[] = $row;
}

echo json_encode($resultArray);

$rowAmount = mysqli_fetch_assoc($result);

if($rowAmount["UserLevel"]==""){
	$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "https://game.maximus2020.sk/maximus/StarterReward.php?user=".$_REQUEST["user"]);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$output = curl_exec($ch);
		curl_close($ch);
}


if($result === FALSE)
{
    die(mysqli_error($connection)); // TODO: better error handling
}







mysqli_close($connection)

?>
