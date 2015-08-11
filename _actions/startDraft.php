<?php

$con = mysql_connect("localhost", 'root', 'Fly0Bird797979');

if (!$con) {
    die('Could not connect!' . mysql_error());
}

mysql_select_db("fantasyfootball_db", $con);

$UpdateDraftStatus = mysql_query("UPDATE `draftsettings` set Value='active' WHERE Setting='draftstatus'", $con);
$UpdateDraftingRow = mysql_query("UPDATE `draftsettings` set Value='1' WHERE Setting='draftingRow'", $con);
$UpdateTeamFilter = mysql_query("UPDATE `draftsettings` set Value='Started' WHERE Setting='teamsFilter'", $con);

