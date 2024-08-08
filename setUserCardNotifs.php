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
$sql = "INSERT INTO CardNotif (user,cardid) VALUES ($user,".'"'.$_REQUEST["cardid"].'"'.");";

$sql .= "INSERT INTO UserNotifs(user,cards,avatarparts,colors,journey,achievements) VALUES ($user,1,0,0,0,0) ON DUPLICATE KEY UPDATE cards=cards+1 ;";


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