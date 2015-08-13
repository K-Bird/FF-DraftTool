<?php

$poolRank = $_POST['poolRank'];

$con = mysql_connect("localhost", 'root', 'Fly0Bird797979');

if (!$con) {
    die('Could not connect!' . mysql_error());
}

mysql_select_db("fantasyfootball_db", $con);

if ($poolRank === '1') {
    return;
} else {

    $Rank_Above = $poolRank - 1;

    $PlayerAtCurrentPos = mysql_query("SELECT * FROM `playerpool` WHERE Rank='{$poolRank}'", $con) or die(mysql_error());
    $getCurrentPlayer = mysql_fetch_array($PlayerAtCurrentPos);
    $current = $getCurrentPlayer['PlayerName'];
    $PlayerAtAbovePos = mysql_query("SELECT PlayerName FROM `playerpool` WHERE Rank='{$Rank_Above}'", $con) or die(mysql_error());
    $getAbovePlayer = mysql_fetch_array($PlayerAtAbovePos);
    $above = $getAbovePlayer['PlayerName'];

    $setCurrentToAbove = mysql_query("Update `playerpool` set Rank='{$Rank_Above}' WHERE PlayerName='{$current}'", $con) or die(mysql_error());
    $setAboveToCurrent = mysql_query("Update `playerpool` set Rank='{$poolRank}' WHERE PlayerName='{$above}'", $con) or die(mysql_error());
}
