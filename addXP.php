<?php
function addXP(int $user,int $amount){
	include 'database.php';
	
	$connection = mysqli_connect($mysql_host,$mysql_user,$mysql_password, $mysql_database);

if (!$connection)
	{
			die('Could not connect: ' . mysqli_error($connection));
	}

	

	mysqli_query($connection, "SET NAMES 'utf8'");
		
	mysqli_select_db($connection, $mysql_database);


	$XpamountQuery = "SELECT XP FROM UserLevel WHERE id=$user;";

	$XpAmount = mysqli_query($connection, $XpamountQuery);

	$rowAmount = mysqli_fetch_assoc($XpAmount);


	if($XpAmount === FALSE)
	{
   		die(mysqli_error($connection)); // TODO: better error handling
	}

	if($rowAmount["XP"]=="")
	{
		echo "Create new entry ".$amount." ".$user;


		$NextLevelQuery = "SELECT Level FROM XPProgression WHERE Total<=$amount ORDER BY Level DESC LIMIT 1;";

		$nextlvl = mysqli_query($connection, $NextLevelQuery);
		$next = mysqli_fetch_assoc($nextlvl);
	
		if($next["Level"]!="")
		{
			$sql = "INSERT INTO UserLevel (id, XP, UserLevel)VALUES ($user,$amount,".$next["Level"].");";
		}
		else
		{
			$sql = "INSERT INTO UserLevel (id, XP, UserLevel) VALUES ( $user,$amount,0);";
		}
	}
	else
	{
		$total = $rowAmount["XP"]+$amount;

		$UserLevelQuerystr = "SELECT UserLevel FROM UserLevel WHERE id=$user";

		$UserLevelQuery = mysqli_query($connection, $UserLevelQuerystr);
		$userlevel = mysqli_fetch_assoc($UserLevelQuery);
		$userlvlVal = $userlevel['UserLevel'];


		$Xpcap = "SELECT Total FROM XPProgression WHERE Level=$userlvlVal;";

		$levelcapquery = mysqli_query($connection, $Xpcap);
		$levelcap = mysqli_fetch_assoc($levelcapquery);

		$sql="";
		if($total>=$levelcap["Total"])
		{
			$remaning= $total-$levelcap["Total"];

			$NextLevelQuery = "SELECT Level FROM XPProgression WHERE Total<=$total ORDER BY Level DESC LIMIT 1;";
			$nextlvl = mysqli_query($connection, $NextLevelQuery);
			$next = mysqli_fetch_assoc($nextlvl);
		
			if($next["Level"]!="")
			{
				$sql = "UPDATE UserLevel SET XP=$total,UserLevel=".$next["Level"]." WHERE id=$user";
			}
			else
			{
			$sql = "UPDATE UserLevel SET XP=$total WHERE id=$user";
			}
		}
		else
		{
		echo "Update entry, Same level $total";
		$sql = "UPDATE UserLevel SET XP=$total WHERE id=$user";
		}
	}
	//echo $sql;

	$result = mysqli_query($connection, $sql);

	if($result === FALSE)
	{
   		die(mysqli_error($connection)); // TODO: better error handling
	}
	else
		echo "Done";

	
	
mysqli_close($connection);
}

	$userid=$_REQUEST["user"];
	$amountin=$_REQUEST["amount"];
addXP($userid,$amountin);

	

?>