<?php

$pool_ID = $_POST['pool_ID'];

$con = mysql_connect("localhost", 'root', 'Fly0Bird797979');

if (!$con) {
    die('Could not connect!' . mysql_error());
}

mysql_select_db("fantasyfootball_db", $con);

$setPlayerNote = mysql_query("UPDATE `playerpool` SET Note='' WHERE Row_ID='{$pool_ID}'",$con);
