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
$title =  $_REQUEST["Title"];


$InboxItemQuery = "SELECT * FROM Inbox WHERE UserID=$user AND Title=".'"'.$title.'"'." AND Claimed!=1;";

$InboxItem = mysqli_query($connection, $InboxItemQuery);
$rowAmount = mysqli_fetch_assoc($InboxItem);


$qi=$rowAmount["QIAmount"];
$qui=$rowAmount["QUIAmount"];
$amount=$rowAmount["XPAmount"];



$sql = "INSERT INTO UserCurrency(UserID,QUI,QI) VALUES($user,$qui,$qi)
		ON DUPLICATE KEY UPDATE QUI=$qui+QUI, QI=$qi+QI;
		UPDATE Inbox SET Claimed=1 WHERE UserID=$user AND Title=".'"'.$title.'"'.";";


if($amount>0){
	echo $amount." XP";

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "https://game.maximus2020.sk/maximus/addXP.php?user=".$user."&amount=".$amount);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	$output = curl_exec($ch);
	curl_close($ch);
}




$result = mysqli_multi_query($connection, $sql);

if($result === FALSE)
{
    die(mysqli_error($connection)); // TODO: better error handling
}
else
	return "Done";


mysqli_close($connection)


?>