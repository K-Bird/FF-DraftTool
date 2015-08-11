<?php

$name = $_POST['name'];
$pos = $_POST['pos'];
$team = $_POST['team'];

$con = mysql_connect("localhost", 'root', 'Fly0Bird797979');

if (!$con) {
    die('Could not connect!' . mysql_error());
}

mysql_select_db("fantasyfootball_db", $con);

$getLastRank = mysql_query("SELECT MAX(Rank) AS Rank FROM `playerpool`",$con);
$lastRankResult = mysql_fetch_array($getLastRank);
$lastRank = $lastRankResult['Rank'];

$nextRank = $lastRank + 1;

$insertPlayer = mysql_query("INSERT INTO `playerpool` (Rank, PlayerName, Position, Team, ByeWeek,Status) VALUES ('{$nextRank}','{$name}','{$pos}','{$team}','0','Available')",$con);
