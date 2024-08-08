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
$sql = "INSERT INTO JourneyNotif (user,setid) VALUES ($user,".'"'.$_REQUEST["setid"].'"'.");";

$sql .= "INSERT INTO UserNotifs(user,cards,avatarparts,colors,journey,achievements) VALUES ($user,0,0,0,1,0) ON DUPLICATE KEY UPDATE journey=journey+1 ;";


mysqli_multi_query($connection, $sql);

$result = mysqli_store_result($connection); 

if($result === FALSE)
{
    die(mysqli_error($connection)); // TODO: better error handling
}
else
	return "Done";



mysqli_close($connection)

?>