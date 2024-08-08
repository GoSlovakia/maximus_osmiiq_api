<?php
include 'database.php';

$connection = mysqli_connect($mysql_host,$mysql_user,$mysql_password, $mysql_database);

if (!$connection)
{
	die('Could not connect: ' . mysqli_error($connection));
}

mysqli_query($connection, "SET NAMES 'utf8'");
		
mysqli_select_db($connection, $mysql_database);

$sql = "DELETE FROM DailyQuiids WHERE Redeemed=0;
UPDATE DailyQuiids SET Redeemed=0 WHERE Redeemed=1;
INSERT INTO UserGameStats (UserID, StatName, Value) SELECT UserID,'ConsecutiveDailyOffers',Consecutive FROM DailyQuiids ON DUPLICATE KEY UPDATE    
Value = (SELECT Consecutive FROM DailyQuiids WHERE DailyQuiids.UserID=UserGameStats.UserID LIMIT 1) ;";


//echo $sql;

$result = mysqli_multi_query($connection, $sql);

if($result === FALSE)
{
   die(mysqli_error($connection)); // TODO: better error handling
}
else
	echo "Done";

mysqli_close($connection)

?>