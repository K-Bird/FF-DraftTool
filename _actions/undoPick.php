<?php

$con = mysql_connect("localhost", 'root', 'Fly0Bird797979');

if (!$con) {
    die('Could not connect!' . mysql_error());
}

mysql_select_db("fantasyfootball_db", $con);

$currentDraftRow = mysql_result(mysql_query("SELECT Value from `draftsettings` WHERE Setting='draftingRow'",$con),0);
$previousDraftRow = $currentDraftRow - 1;

$draftedPlayerRow = mysql_result(mysql_query("SELECT playerpool_ID FROM `draftedplayers` WHERE draftorder_ID='{$previousDraftRow}'",$con),0);
$setDraftedPlayerToAVL = mysql_query("UPDATE `playerpool` SET Status='Available' WHERE Row_ID='{$draftedPlayerRow}'",$con);

$decrementDraftRow = mysql_query("UPDATE `draftsettings` SET Value='{$previousDraftRow}' WHERE Setting='draftingRow'",$con);

$removeDraftedRow = mysql_query("DELETE FROM `draftedplayers` WHERE draftorder_ID='{$previousDraftRow}'",$con);