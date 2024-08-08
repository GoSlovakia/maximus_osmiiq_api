<?php
include 'database.php';


$connection = mysqli_connect($mysql_host,$mysql_user,$mysql_password,$mysql_database);



if(!$connection)
{
	die('Could not connect: ' . mysqli_error($connection));
}

mysqli_query($connection, "SET NAMES 'utf8'");

mysqli_select_db($connection, $mysql_database);


$userID = $_REQUEST["userID"];
$sql = "SELECT QUI, QI FROM UserCurrency WHERE userID = $userID LIMIT 1;";

mysqli_multi_query($connection,$sql);
$result = mysqli_store_result($connection);
$rowUserCurrency = mysqli_fetch_assoc($result);



$AmountQUI = $rowUserCurrency["QUI"] + $_REQUEST["QUI"];
$AmountQI = $rowUserCurrency["QI"] + $_REQUEST["QI"];
	
	
$sql = "UPDATE UserCurrency SET QUI = $AmountQUI, QI = $AmountQI WHERE userID = $userID";	
	
	
$result = mysqli_query($connection,$sql);
if($result === FALSE)
{
	die(mysqli_error($connection)); // TODO: better error handling
}
else{
	
	echo $AmountQUI. " ---- " .$AmountQI;
}


mysqli_close($connection)
?>