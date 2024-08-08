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
$boosterID = $_REQUEST["boosterID"];



$sql = "SELECT QUI,QI FROM UserCurrency WHERE userID = $userID LIMIT 1; 
	SELECT BoosterPriceQUI,PriceQI,CommonMin,CommonMax,RareMin,RareMax,EpicMin,EpicMax,LegendaryMin,LegendaryMax,TotalCards FROM Boosters WHERE BoosterID = $boosterID;";

	


mysqli_multi_query($connection,$sql); 
$result = mysqli_store_result($connection); 
$rowUserCurrency = mysqli_fetch_assoc($result); 



mysqli_free_result($result); 



mysqli_next_result($connection);  
$result = mysqli_store_result($connection); 
$rowBooster = mysqli_fetch_assoc($result);




$amountQUI = $rowUserCurrency["QUI"] - $rowBooster["BoosterPriceQUI"];
$amountQI = $rowUserCurrency["QI"] - $rowBooster["PriceQI"];



if($amountQUI >= 0  && $amountQI>=0)
{
	
	$sql = "UPDATE UserCurrency SET QUI = $amountQUI,QI = $amountQI WHERE userID = $userID";	
	
	
	
	$result = mysqli_query($connection,$sql);
	if($result === FALSE)
	{
		echo "Couldnt deduct the funds from the user!";
		die(mysqli_error($connection)); // TODO: better error handling
	}/*
	else
		echo "Success"; */
	
	
	
	$totalCards = $rowBooster["TotalCards"];
	$totalCards = $totalCards - ($rowBooster["LegendaryMin"] + $rowBooster["EpicMin"] + $rowBooster["RareMin"]);
	$legendaryCards = 0;
	$epicCards = 0;
	$rareCards = 0;
	
	
	if($totalCards > 0)
	{
		for($i = 0; $i < $rowBooster["LegendaryMax"];$i++)
		{
			if(mt_rand(0,100) > 95)
			{				
				$totalCards = $totalCards - 1;

				$legendaryCards = $legendaryCards + 1;
				
				if($totalCards <= 0)
					break;
			}
		}
		
		for($i = 0; $i < $rowBooster["EpicMax"];$i++)
		{
			if(mt_rand(0,100) > 90)
			{
				if($totalCards <= 0)
					break;
				
				$totalCards = $totalCards - 1;
				
				$epicCards = $epicCards + 1;
			}
		}
		
		for($i = 0; $i < $rowBooster["RareMax"];$i++)
		{
			if(mt_rand(0,100) > 80)
			{
				if($totalCards <= 0)
					break;
				
				$totalCards = $totalCards - 1;
				
				$rareCards = $rareCards + 1;
			}
		}
	}
	
	unset($sql);
	$sql = "SELECT id,title,singleworddescription,rarity,'set',type FROM cards WHERE rarity = 'L' ORDER BY RAND() LIMIT " .$rowBooster["LegendaryMin"] + $legendaryCards.";
	SELECT id,title,singleworddescription,rarity,'set',type FROM cards WHERE rarity = 'E' ORDER BY RAND() LIMIT " .$rowBooster["EpicMin"] + $epicCards.";
	SELECT id,title,singleworddescription,rarity,'set',type FROM cards WHERE rarity = 'R' ORDER BY RAND() LIMIT " .$rowBooster["RareMin"] + $rareCards.";
	SELECT id,title,singleworddescription,rarity,'set',type FROM cards WHERE rarity = 'C' ORDER BY RAND() LIMIT " .$totalCards.";";
	
	$resultArray = array();
	if(mysqli_multi_query($connection,$sql))
	{
		do
		{
			if($sqlResult = mysqli_store_result($connection))
			{
				while($row = mysqli_fetch_assoc($sqlResult))
				{
					$resultArray[] = $row; 
				}
				mysqli_free_result($sqlResult);
			}
		}while(mysqli_next_result($connection));
	} 	
	// echo "Update do dinheiro ainda está comentado";
	echo json_encode($resultArray);
}
else
	echo "Not enough currency!";

mysqli_close($connection)
?>