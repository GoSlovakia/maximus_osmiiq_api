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
$voucherid = $_REQUEST["id"];
$title= $_REQUEST["title"];


$VoucherQuery = "SELECT * FROM StudentRewards WHERE ID=".'"'.$voucherid.'"'.";";

$Voucher = mysqli_query($connection, $VoucherQuery);
$vamount = mysqli_fetch_assoc($Voucher);

if($title==""){
	$title= $vamount["Title"];
}

$xp=$vamount["XPAmount"];
$qi=$vamount["QIAmount"];
$qui=$vamount["QUIAmount"];

$sql = "INSERT INTO Inbox (UserID,Title,XPAmount,QUIAmount,QIAmount) VALUES(".$user.",".'"'.$title.'"'.",$xp,$qui,$qi);";

// Debug
//echo $sql;

$result = mysqli_query($connection, $sql);

if($result === FALSE)
{
    die(mysqli_error($connection)); // TODO: better error handling
}
else
	return "Done";


mysqli_close($connection)

?>