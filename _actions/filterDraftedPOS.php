<?php

$pos = $_POST['pos'];

$con = mysql_connect("localhost", 'root', 'Fly0Bird797979');

if (!$con) {
    die('Could not connect!' . mysql_error());
}

mysql_select_db("fantasyfootball_db", $con);

$UpdateRecapFilter = mysql_query("UPDATE `draftsettings` set Value='{$pos}' WHERE Setting='recapFilter'", $con);

