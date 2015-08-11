<?php

$con = mysql_connect("localhost", 'root', 'Fly0Bird797979');

if (!$con) {
    die('Could not connect!' . mysql_error());
}

mysql_select_db("fantasyfootball_db", $con);

$clearTable = mysql_query("TRUNCATE TABLE `draftorder`", $con);

$rounds = 16;
$draftRound = 1;
$roundPick = 1;
$overallPick = 1;

while ($draftRound <= $rounds) {

    if ($draftRound % 2 == 0) {
        $getOwnersAndPositions = mysql_query("SELECT * FROM `owners` ORDER BY DraftPosition DESC", $con);
        while ($ownerRow = mysql_fetch_array($getOwnersAndPositions)) {

            $updateDraftOrder = mysql_query("INSERT into `draftorder` (Round, Pick, Overall, Owner) Values ('{$draftRound}','{$roundPick}','{$overallPick}','{$ownerRow['OwnerName']}')", $con);
            $overallPick++;
            $roundPick++;
        }
    }
    if ($draftRound % 2 != 0) {
        $getOwnersAndPositions = mysql_query("SELECT * FROM `owners` ORDER BY DraftPosition ASC", $con);
        while ($ownerRow = mysql_fetch_array($getOwnersAndPositions)) {

            $updateDraftOrder = mysql_query("INSERT into `draftorder` (Round, Pick, Overall, Owner) Values ('{$draftRound}','{$roundPick}','{$overallPick}','{$ownerRow['OwnerName']}')", $con);
            $overallPick++;
            $roundPick++;
        }
    }

    $roundPick = 1;
    $draftRound++;
}


$updateDraftSettings = mysql_query("UPDATE `draftsettings` set Value='Y' WHERE Setting='draftOrderSet'", $con);
