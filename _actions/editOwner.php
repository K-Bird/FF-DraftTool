<?php

$newName = $_POST['newName'];
$rowID = $_POST['rowID'];

$con = mysql_connect("localhost", 'root', 'Fly0Bird797979');

if (!$con) {
    die('Could not connect!' . mysql_error());
}

mysql_select_db("fantasyfootball_db", $con);

$UpdateOwner = mysql_query("UPDATE `owners` set OwnerName='{$newName}' WHERE Row_ID='{$rowID}'", $con);

$updatedOwner = mysql_query("Select * from `owners` Where Row_ID='{$rowID}'", $con) or die(mysql_error());
$checkUpdateOwner = mysql_fetch_array($updatedOwner);
echo $checkUpdateOwner['OwnerName'];

