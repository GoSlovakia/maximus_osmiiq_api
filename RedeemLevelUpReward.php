<?php
include 'database.php';
$connection = mysqli_connect($mysql_host,$mysql_user,$mysql_password, $mysql_database);

if (!$connection)
{
	die('Could not connect: ' . mysqli_error($connection));
}

mysqli_query($connection, "SET NAMES 'utf8'");
		
mysqli_select_db($connection, $mysql_database);

$user = $_REQUEST["user"];
$lvl =  $_REQUEST["lvl"];


$LvlItemQuery = "SELECT * FROM XPProgression WHERE Level=$lvl;";

$LvlItem = mysqli_query($connection, $LvlItemQuery);
$rowAmount = mysqli_fetch_assoc($LvlItem);


$qi=$rowAmount["QIReward"];
$qui=$rowAmount["QUIReward"];



$sql = "INSERT INTO UserCurrency(UserID,QUI,QI) VALUES($user,$qui,$qi)
		ON DUPLICATE KEY UPDATE QUI=$qui+QUI, QI=$qi+QI;";

//echo $sql;

$result = mysqli_multi_query($connection, $sql);

if($result === FALSE)
{
    die(mysqli_error($connection)); // TODO: better error handling
}
else
	return "Done";


mysqli_close($connection)


?>