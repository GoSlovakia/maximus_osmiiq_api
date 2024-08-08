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
$sql = "SELECT QUI, QI FROM UserCurrency WHERE userID = $userID LIMIT 1; SELECT * FROM ExchangeQI WHERE ID = ".$_REQUEST["ID"].";";

mysqli_multi_query($connection,$sql);
$result = mysqli_store_result($connection);
$rowUserCurrency = mysqli_fetch_assoc($result);


mysqli_free_result($result);


mysqli_next_result($connection);
$result = mysqli_store_result($connection);
$rowExchangeQi = mysqli_fetch_assoc($result);


$AmountQI = ($rowUserCurrency["QI"] - $rowExchangeQi["QIPrice"]);


if($AmountQI >= 0 )
{
	$AmountQUI = $rowUserCurrency["QUI"] + $rowExchangeQi["QUIRecieved"];
	
	
	$sql = "INSERT INTO UserCurrency(userID,QUI,QI) VALUES($userID,$AmountQUI,$AmountQI) ON DUPLICATE KEY UPDATE QUI = $AmountQUI, QI = $AmountQI;";	
	
	
	$result = mysqli_multi_query($connection,$sql);
	if($result === FALSE)
	{
		echo -1;
		die(mysqli_error($connection)); // TODO: better error handling
	}
	else
		echo 0;

	//xp
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "https://game.maximus2020.sk/maximus/addXP.php?user=".$userID."&amount=".$rowExchangeQi["XPReward"]);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	$output = curl_exec($ch);
	curl_close($ch);
	
	echo "XP Rewarded".$rowExchangeQi["XPReward"];


}
else
	echo 1; 


mysqli_close($connection)
?>