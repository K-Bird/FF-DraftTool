<?php

$owner = $_POST['owner'];

$con = mysql_connect("localhost", 'root', 'Fly0Bird797979');

if (!$con) {
    die('Could not connect!' . mysql_error());
}

mysql_select_db("fantasyfootball_db", $con);

$UpdatePoolFilter = mysql_query("UPDATE `draftsettings` set Value='{$owner}' WHERE Setting='teamsFilter'", $con);

