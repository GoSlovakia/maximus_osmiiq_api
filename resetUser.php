<?php
include 'database.php';

if(isset($_REQUEST["user"]))
{
	$connection = mysqli_connect($mysql_host,$mysql_user,$mysql_password, $mysql_database);

	if (!$connection)
	{
		die('Could not connect: ' . mysqli_error($connection));
	}

	mysqli_query($connection, "SET NAMES 'utf8'");
			
	mysqli_select_db($connection, $mysql_database);

	$sql = "DELETE Inbox,UserCardInventory,UserColors,useravatarparts,UserCurrency,UserGameStats,UserSets,DailyQuiids,UserLevel,UserStarter,UserTitles,AvatarPartsNotif,CardNotif,ColorNotif,JourneyNotif,UserNotifs FROM Inbox
LEFT JOIN AchNotif
ON AchNotif.user = Inbox.UserID
LEFT JOIN UserCardInventory
ON UserCardInventory.UserID = Inbox.UserID
LEFT JOIN UserColors
ON UserColors.UserID = Inbox.UserID
LEFT JOIN useravatarparts
ON useravatarparts.user = Inbox.UserID
LEFT JOIN UserCurrency
ON UserCurrency.userID = Inbox.UserID
LEFT JOIN UserGameStats
ON UserGameStats.UserID = Inbox.UserID
LEFT JOIN UserSets
ON UserSets.UserID = Inbox.UserID
LEFT JOIN DailyQuiids
ON DailyQuiids.UserID = Inbox.UserID
LEFT JOIN UserLevel
ON UserLevel.id = Inbox.UserID
LEFT JOIN UserTitles
ON UserTitles.UserID = Inbox.UserID
LEFT JOIN 
UserStarter On UserStarter.id = Inbox.UserID
LEFT JOIN AvatarPartsNotif
ON AvatarPartsNotif.user = Inbox.UserID
LEFT JOIN CardNotif
ON CardNotif.user = Inbox.UserID
LEFT JOIN ColorNotif
ON ColorNotif.user = Inbox.UserID
LEFT JOIN JourneyNotif
ON JourneyNotif.user = Inbox.UserID
LEFT JOIN UserNotifs
ON UserNotifs.user = Inbox.UserID
WHERE Inbox.UserID=" . $_REQUEST["user"].";";
	$sql.="INSERT INTO Inbox (UserID,Title,XPAmount,QUIAmount,QIAmount) VALUES(".$_REQUEST["user"].",".'"Begin Testing!N1"'.",0,0,10);";
	$sql.="INSERT INTO Inbox (UserID,Title,XPAmount,QUIAmount,QIAmount) VALUES(".$_REQUEST["user"].",".'"Begin Testing!N2"'.",0,0,10);";
	$sql.="INSERT INTO Inbox (UserID,Title,XPAmount,QUIAmount,QIAmount) VALUES(".$_REQUEST["user"].",".'"Begin Testing!N3"'.",0,0,10);";
	$sql.="INSERT INTO Inbox (UserID,Title,XPAmount,QUIAmount,QIAmount) VALUES(".$_REQUEST["user"].",".'"Quiids!N1"'.",0,10000,0);";
	$sql.="INSERT INTO Inbox (UserID,Title,XPAmount,QUIAmount,QIAmount) VALUES(".$_REQUEST["user"].",".'"Quiids!N2"'.",0,10000,0);";
	$sql.="INSERT INTO Inbox (UserID,Title,XPAmount,QUIAmount,QIAmount) VALUES(".$_REQUEST["user"].",".'"Quiids!N3"'.",0,10000,0);";
	$sql.="INSERT INTO Inbox (UserID,Title,XPAmount,QUIAmount,QIAmount) VALUES(".$_REQUEST["user"].",".'"And your XP!N1"'.",200,0,0);";
	$sql.="INSERT INTO Inbox (UserID,Title,XPAmount,QUIAmount,QIAmount) VALUES(".$_REQUEST["user"].",".'"And your XP!N2"'.",200,0,0);";
	$sql.="INSERT INTO Inbox (UserID,Title,XPAmount,QUIAmount,QIAmount) VALUES(".$_REQUEST["user"].",".'"And your XP!N3"'.",200,0,0);";
	$sql.="INSERT INTO Inbox (UserID,Title,XPAmount,QUIAmount,QIAmount) VALUES(".$_REQUEST["user"].",".'"And your XP!N4"'.",200,0,0);";
	$sql.="INSERT INTO Inbox (UserID,Title,XPAmount,QUIAmount,QIAmount) VALUES(".$_REQUEST["user"].",".'"And your XP!N5"'.",200,0,0);";
	$sql.="INSERT INTO Inbox (UserID,Title,XPAmount,QUIAmount,QIAmount) VALUES(".$_REQUEST["user"].",".'"And your XP!N6"'.",200,0,0);";
	$sql.="INSERT INTO Inbox (UserID,Title,XPAmount,QUIAmount,QIAmount) VALUES(".$_REQUEST["user"].",".'"And your XP!N7"'.",200,0,0);";

	

	$result = mysqli_multi_query($connection, $sql);

	if($result === FALSE)
	{
		die(mysqli_error($connection)); // TODO: better error handling
	}
	else
		return "Done";

	mysqli_close($connection);
}
?>