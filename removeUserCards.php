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
$cardid=$_REQUEST["cardID"];
$amount=$_REQUEST["amount"];





$currentcardQuery = "SELECT CardAmount FROM UserCardInventory WHERE UserID=$user AND CardID=".'"'.$cardid.'"'.";";

$currentcard = mysqli_query($connection, $currentcardQuery);
$rowAmount = mysqli_fetch_assoc($currentcard);

if($currentcard === FALSE)
{
   die(mysqli_error($connection)); // TODO: better error handling
}


if($rowAmount["CardAmount"]== "" OR $rowAmount["CardAmount"] - $amount <= 0)
{
	//echo "Delete entry";
	$sql = "DELETE FROM UserCardInventory WHERE UserID = " .$user. ' AND CardID = "'.$cardid.'";';
}
else
{
	//echo "Update entry";
	$total = $rowAmount["CardAmount"]-$amount;
	$sql = "UPDATE UserCardInventory SET CardAmount=$total WHERE UserID=$user AND CardID=".'"'.$cardid.'"'.";";
}



$result = mysqli_query($connection, $sql);

if($result === FALSE)
{
   die(mysqli_error($connection)); // TODO: better error handling
}
else
	echo "Done";


mysqli_close($connection)

?>