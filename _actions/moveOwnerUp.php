<?php

$draftPos = $_POST['draftPos'];

$con = mysql_connect("localhost", 'root', 'Fly0Bird797979');

if (!$con) {
    die('Could not connect!' . mysql_error());
}

mysql_select_db("fantasyfootball_db", $con);

if ($draftPos === '1') {
    return;
} else {

    $Pos_Above = $draftPos - 1;

    $OwnerAtCurrentPos = mysql_query("SELECT * FROM `owners` WHERE DraftPosition='{$draftPos}'", $con) or die(mysql_error());
    $getCurrentOwner = mysql_fetch_array($OwnerAtCurrentPos);
    $current = $getCurrentOwner['OwnerName'];
    $OwnerAtAbovePos = mysql_query("SELECT OwnerName FROM `owners` WHERE DraftPosition='{$Pos_Above}'", $con) or die(mysql_error());
    $getAboveOwner = mysql_fetch_array($OwnerAtAbovePos);
    $above = $getAboveOwner['OwnerName'];

    $setCurrentToAbove = mysql_query("Update `owners` set DraftPosition='{$Pos_Above}' WHERE OwnerName='{$current}'", $con) or die(mysql_error());
    $setAboveToCurrent = mysql_query("Update `owners` set DraftPosition='{$draftPos}' WHERE OwnerName='{$above}'", $con) or die(mysql_error());
}
