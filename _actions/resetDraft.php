<?php

$con = mysql_connect("localhost", 'root', 'Fly0Bird797979');

if (!$con) {
    die('Could not connect!' . mysql_error());
}

mysql_select_db("fantasyfootball_db", $con);

$emptyDraftedPlayers = mysql_query("TRUNCATE `draftedplayers`", $con);
$emptyDraftOrder = mysql_query("TRUNCATE `draftorder`", $con);
$resetPlayerPool = mysql_query("UPDATE `playerpool` set Status='Available' WHERE Status='Drafted'", $con);
$resetWontDraft = mysql_query("UPDATE `playerpool` set Status='W' WHERE DontDraftReset='W'", $con);
$UpdateDraftStatus = mysql_query("UPDATE `draftsettings` set Value='setup' WHERE Setting='draftstatus'", $con);
$UpdateDraftingRow = mysql_query("UPDATE `draftsettings` set Value='0' WHERE Setting='draftingRow'", $con);
$UpdatePlayerPoolFilter = mysql_query("UPDATE `draftsettings` set Value='ALL' WHERE Setting='poolFilter'", $con);
$UpdateTeamsFilter = mysql_query("UPDATE `draftsettings` set Value='None' WHERE Setting='teamsFilter'", $con);

