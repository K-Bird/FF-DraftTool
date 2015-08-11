<?php

$pool_ID = $_POST['pool_ID'];

$con = mysql_connect("localhost", 'root', 'Fly0Bird797979');

if (!$con) {
    die('Could not connect!' . mysql_error());
}

mysql_select_db("fantasyfootball_db", $con);

$currentDraftRow = mysql_result(mysql_query("SELECT Value from `draftsettings` WHERE Setting='draftingRow'",$con),0);
$insertIDs = mysql_query("INSERT INTO `draftedplayers` (playerpool_ID, draftorder_ID) VALUES ('{$pool_ID}','{$currentDraftRow}')",$con);

$setPlayerToDrafted = mysql_query("UPDATE `playerpool` SET Status='Drafted' WHERE Row_ID='{$pool_ID}'",$con);

$nextDraftRow = $currentDraftRow + 1;
$incrementDraftRow = mysql_query("UPDATE `draftsettings` SET Value='{$nextDraftRow}' WHERE Setting='draftingRow'",$con);