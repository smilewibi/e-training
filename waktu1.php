<?php
$today = getdate();
$month = $today['month'];
$mday = $today['mday'];
$year = $today['year'];
$hours = $today['hours'];
$minutes = $today['minutes'];
$seconds = $today['seconds'];
$waktu=$mday.' '.$month.' '.$year.' ';
echo $waktu;
?>