<?php
include'database.php';

$connection = mysqli_connect($mysql_host,$mysql_user,$mysql_password,$mysql_database);

if(!$connection)
{
	die('Could not connect: ' . mysqli_error($connection));
}

mysqli_query($connection, "SET NAMES 'utf8'");

mysqli_select_db($connection, $mysql_database);

$sql = "SELECT * FROM CardRotation";

$results = mysqli_query($connection,$sql);

if($results === false)
{
	die(mysqli_error($connection)); // TODO: better error handling
}

$resultArray = array();

while($row = mysqli_fetch_assoc($results))
{
	$resultArray[] = $row;
}

unset($sql);

for($i = 0; $i < count($resultArray);$i++)
{
	$sql .= "SELECT id,title,type,cards.rarity,priceQUI FROM cards LEFT JOIN RarityPrices ON cards.rarity = RarityPrices.Rarity WHERE ID = '".$resultArray[$i]["CardID"]."';";
	
}



$resultsArray = array();
if(mysqli_multi_query($connection,$sql))
{
	do
	{
		if($sqlResult = mysqli_store_result($connection))
		{
			while($rows = mysqli_fetch_assoc($sqlResult))
			{
				$resultsArray[] = $rows; 
			}
			
			mysqli_free_result($sqlResult);
		}
	}while(mysqli_next_result($connection));
}
	


echo json_encode($resultsArray);

mysqli_close($connection)
?>