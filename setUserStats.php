<?php
include 'database.php';

$connection = mysqli_connect($mysql_host,$mysql_user,$mysql_password, $mysql_database);

if (!$connection)
{
	die('Could not connect: ' . mysqli_error($connection));
}

$user = $_REQUEST["user"];
$stat = $_REQUEST["statname"];
$value = $_REQUEST["value"];
$setType = $_REQUEST["set"];

mysqli_query($connection, "SET NAMES 'utf8'");
		
mysqli_select_db($connection, $mysql_database);

if(!is_null($setType))
	$current = "SELECT UserID,StatName,Value,setType FROM UserGameStats WHERE UserID =$user AND StatName=".'"'.$stat.'"'."AND setType=".'"'.$setType.'"'.";";
else
	$current = "SELECT UserID,StatName,Value,setType FROM UserGameStats WHERE UserID =$user AND StatName=".'"'.$stat.'"'.";";

$selection = mysqli_query($connection, $current);
$rowAmount = mysqli_fetch_assoc($selection);

if($rowAmount["UserID"]=="")
{
	
	if($stat!=""&&!is_null($value)&&!is_null($setType))
	{

		$sql = "INSERT INTO UserGameStats(UserID,Statname,Value,setType) VALUES($user,".'"'.$stat.'"'.",$value,$setType)";
		//echo $sql;

	}
	else if($stat!=""&&!is_null($value))
	{
		$sql = "INSERT INTO UserGameStats(UserID,Statname,Value,setType) VALUES($user,".'"'.$stat.'"'.",$value,NULL)";
		//echo $sql;
	}
	
}
else
{
	
	if(!is_null($setType))
	{
		$sql = "UPDATE UserGameStats SET Value=$value WHERE UserID=$user AND StatName=".'"'.$stat.'"'."AND setType=$setType";
	}
		else
	{
		$sql = "UPDATE UserGameStats SET Value=$value WHERE UserID=$user AND StatName=".'"'.$stat.'"'.";";
	}

	//echo $sql;
}


$result = mysqli_query($connection, $sql);

if($result === FALSE)
{
    die(mysqli_error($connection)); // TODO: better error handling
}
else
	return "Done";


mysqli_close($connection)

?>