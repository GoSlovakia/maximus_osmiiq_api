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
$adjid=$_REQUEST["adjID"];
$nameid=$_REQUEST["nameID"];

$currentTitles = "SELECT UserID,AdjID,NameID FROM UserTitles WHERE UserID=$user ;";

$selection = mysqli_query($connection, $currentTitles);
$rowAmount = mysqli_fetch_assoc($selection);


if(empty($rowAmount["UserID"]))
{

	echo "Create new entry ".$rowAmount["NameID"];
	
	if(!is_null($nameid)&&!is_null($adjid))
	{

		$sql= "INSERT INTO UserTitles (UserID, AdjID, NameID) VALUES ( $user,".'"'.$adjid.'"'.",".'"'.$nameid.'"'.");";
	}
		else
	{
		mysqli_close($connection);
		die("No entry found. Fill all variables");
	}
	//echo $sql;

}
	else
{
	echo "Updating entry";
	$nameid= (!is_null($nameid)) ? $nameid : $rowAmount["NameID"];
	$adjid= (!is_null($adjid)) ? $adjid : $rowAmount["AdjID"];
	
	$sql = "UPDATE UserTitles SET AdjID=".'"'.$adjid.'"'.", NameID=".'"'.$nameid.'"'." WHERE UserID=$user";
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