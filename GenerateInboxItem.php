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
$title=$_REQUEST["title"];
$xp=$_REQUEST["xp"];
$qui=$_REQUEST["qui"];
$qi=$_REQUEST["qi"];

$sql = "INSERT INTO Inbox (UserID,Title,XPAmount,QUIAmount,QIAmount) VALUES($user,".'"'.$title.'"'.",$xp,$qui,$qi);";


$result = mysqli_query($connection, $sql);

if($result === FALSE)
{
   die(mysqli_error($connection)); // TODO: better error handling
}
else
	echo "Done";

mysqli_close($connection)

?>