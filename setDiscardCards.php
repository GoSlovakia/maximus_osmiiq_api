<?php
include 'database.php';

// ***********************************************************
// ***********************************************************
// ********************** OPTIMIZAR ISTO!!! ******************
// ***********************************************************
// ***********************************************************

$connection = mysqli_connect($mysql_host,$mysql_user,$mysql_password,$mysql_database);



if(!$connection)
{
	die('Could not connect: ' . mysqli_error($connection));
}

mysqli_query($connection, "SET NAMES 'utf8'");

mysqli_select_db($connection, $mysql_database);


$userID = $_REQUEST["userID"];
$cardID = $_REQUEST["cardID"];
$cardsAmount = $_REQUEST["cardsAmount"];
$amountQUI = $_REQUEST["amountQUI"];

$sql = "UPDATE UserCardInventory SET CardAmount = '$cardsAmount' WHERE CardID = '$cardID' AND UserID = '$userID'; 
		UPDATE UserCurrency SET QUI = '$amountQUI' WHERE userID = '$userID';";	
$result = mysqli_multi_query($connection,$sql);

if($result === FALSE)
{
	die(mysqli_error($connection)); // TODO: better error handling
}

mysqli_close($connection)
?>