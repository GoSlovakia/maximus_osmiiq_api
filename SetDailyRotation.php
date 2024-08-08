<?php
include 'database.php';

$connection = mysqli_connect($mysql_host,$mysql_user,$mysql_password, $mysql_database);

if (!$connection)
{
	die('Could not connect: ' . mysqli_error($connection));
}

mysqli_query($connection, "SET NAMES 'utf8'");
		
mysqli_select_db($connection, $mysql_database);

$sql = "SELECT id FROM game_maximus_sk.cards ORDER BY RAND() LIMIT 5;";


$result = mysqli_query($connection, $sql);

if($result === FALSE)
{
   die(mysqli_error($connection)); // TODO: better error handling
}
else
	echo "Done fetching cards";

$sql = "DELETE FROM CardRotation; INSERT INTO CardRotation(CardID) VALUES ";




foreach($result as $value)
{
		$sql.="(\"".$value['id']."\"),";
		//$sql.="teste";
}

$sql=substr($sql,0,-1);
$sql.=";";

mysqli_multi_query($connection,$sql); 

echo "Daily Rotation Updated ".$sql;


mysqli_close($connection)

?>