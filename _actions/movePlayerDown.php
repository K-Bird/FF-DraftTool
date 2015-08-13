<?php

$poolRank = $_POST['poolRank'];

$con = mysql_connect("localhost", 'root', 'Fly0Bird797979');

if (!$con) {
    die('Could not connect!' . mysql_error());
}

mysql_select_db("fantasyfootball_db", $con);

if ($poolRank === '300') {
    return;
} else {

    $Rank_Below = $poolRank + 1;

    $PlayerAtCurrentPos = mysql_query("SELECT * FROM `playerpool` WHERE Rank='{$poolRank}'", $con) or die(mysql_error());
    $getCurrentPlayer = mysql_fetch_array($PlayerAtCurrentPos);
    $current = $getCurrentPlayer['PlayerName'];
    $PlayerAtBelowPos = mysql_query("SELECT PlayerName FROM `playerpool` WHERE Rank='{$Rank_Below}'", $con) or die(mysql_error());
    $getBelowPlayer = mysql_fetch_array($PlayerAtBelowPos);
    $above = $getBelowPlayer['PlayerName'];

    $setCurrentToBelow = mysql_query("Update `playerpool` set Rank='{$Rank_Below}' WHERE PlayerName='{$current}'", $con) or die(mysql_error());
    $setBelowToCurrent = mysql_query("Update `playerpool` set Rank='{$poolRank}' WHERE PlayerName='{$above}'", $con) or die(mysql_error());
}

