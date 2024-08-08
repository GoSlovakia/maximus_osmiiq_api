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
$typeOfCurrency = $_REQUEST["currencyType"];
$cardID = $_REQUEST["cardID"];


if($typeOfCurrency === "QUI")
{
	$sql = "SELECT QUI FROM UserCurrency WHERE userID = $userID LIMIT 1; 
		SELECT RarityPrices.PriceQUI FROM cards LEFT JOIN RarityPrices ON cards.rarity = RarityPrices.Rarity WHERE ID = '".$cardID."';
		SELECT * FROM cards WHERE id = '".$cardID."';";
}
else
{
	$sql = "SELECT QI FROM UserCurrency WHERE userID = $userID LIMIT 1; 
		SELECT RarityPrices.PriceQI FROM cards LEFT JOIN RarityPrices ON cards.rarity = RarityPrices.Rarity WHERE ID = '".$cardID."';
		SELECT * FROM cards WHERE id = '".$cardID."';";
}


mysqli_multi_query($connection,$sql); 
$result = mysqli_store_result($connection); 
$rowUserCurrency = mysqli_fetch_assoc($result); 



mysqli_free_result($result); 



mysqli_next_result($connection);  
$result = mysqli_store_result($connection); 
$rowCardPrices = mysqli_fetch_assoc($result);


mysqli_free_result($result); 



mysqli_next_result($connection);  
$result = mysqli_store_result($connection); 
$rowCard = mysqli_fetch_assoc($result);





if($typeOfCurrency === "QUI")
{
	$amount = $rowUserCurrency["QUI"] - $rowCardPrices["PriceQUI"];
}
else
{
	$amount = $rowUserCurrency["QI"] - $rowCardPrices["PriceQI"];
}


if($amount >= 0 )
{
	if($typeOfCurrency === "QUI")
	{
		$sql = "UPDATE UserCurrency SET QUI = $amount WHERE userID = $userID";	
	}else
	{
		$sql = "UPDATE UserCurrency SET QI = $amount WHERE userID = $userID";	
	}
	
	echo json_encode($rowCard);
	
	$result = mysqli_query($connection,$sql);
	if($result === FALSE)
	{
		echo -1;
		die(mysqli_error($connection)); // TODO: better error handling
	}
	else
		echo 0;
}
else
	echo 1;

mysqli_close($connection)
?>