<?php
include 'database.php';

$connection = mysqli_connect($mysql_host,$mysql_user,$mysql_password, $mysql_database);

if (!$connection)
{
	die('Could not connect: ' . mysqli_error($connection));
}

mysqli_query($connection, "SET NAMES 'utf8'");
		
mysqli_select_db($connection, $mysql_database);

$user= $_REQUEST["user"];

$StarterQuery = "SELECT id FROM UserStarter WHERE id=$user";

$Starter = mysqli_query($connection, $StarterQuery);
$rowAmount = mysqli_fetch_assoc($Starter);


if($rowAmount["id"]==""){

	$VoucherQuery = "SELECT * FROM StudentRewards WHERE ID=".'"'."Starter".'"'.";";

$Voucher = mysqli_query($connection, $VoucherQuery);
$vamount = mysqli_fetch_assoc($Voucher);

$xp=$vamount["XPAmount"];
$qi=$vamount["QIAmount"];
$qui=$vamount["QUIAmount"];


	$sql = "INSERT INTO UserStarter (id) VALUES ( $user );"
	.$sql = "INSERT INTO Inbox (UserID,Title,XPAmount,QUIAmount,QIAmount) VALUES(".$user.",".'"'."Starter Bonus".'"'.",$xp,$qui,$qi);";
	

	$result = mysqli_multi_query($connection, $sql);

	if($result === FALSE)
	{
		die(mysqli_error($connection)); // TODO: better error handling
	}
	

}




mysqli_close($connection)

?>