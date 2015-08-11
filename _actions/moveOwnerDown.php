<?php

$draftPos = $_POST['draftPos'];

$con = mysql_connect("localhost", 'root', 'Fly0Bird797979');

if (!$con) {
    die('Could not connect!' . mysql_error());
}

mysql_select_db("fantasyfootball_db", $con);

if ($draftPos === '10') {
    return;
} else {

    $Pos_Below = $draftPos + 1;

    $OwnerAtCurrentPos = mysql_query("SELECT * FROM `owners` WHERE DraftPosition='{$draftPos}'", $con) or die(mysql_error());
    $getCurrentOwner = mysql_fetch_array($OwnerAtCurrentPos);
    $current = $getCurrentOwner['OwnerName'];
    $OwnerAtBelowPos = mysql_query("SELECT OwnerName FROM `owners` WHERE DraftPosition='{$Pos_Below}'", $con) or die(mysql_error());
    $getBelowOwner = mysql_fetch_array($OwnerAtBelowPos);
    $above = $getBelowOwner['OwnerName'];

    $setCurrentToBelow = mysql_query("Update `owners` set DraftPosition='{$Pos_Below}' WHERE OwnerName='{$current}'", $con) or die(mysql_error());
    $setBelowToCurrent = mysql_query("Update `owners` set DraftPosition='{$draftPos}' WHERE OwnerName='{$above}'", $con) or die(mysql_error());
}

