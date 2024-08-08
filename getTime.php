<?php

$info = getdate();
$date = $info['mday'];
$month = $info['mon'];
$year = $info['year'];
$hour = $info['hours'];
$min = $info['minutes'];
$sec = $info['seconds'];

$current_date = "$date/$month/$year/$hour/$min/$sec";
$TimeUntilMidnight = (23-$hour)."-".(59-$min)."-".(60-$sec);

echo $current_date;
?>