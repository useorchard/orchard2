<?php
$mysql_hostname = "10.0.1.120";
$mysql_user = "orchard2";
$mysql_password = "lobsterlobstercorn";
$mysql_database = "Cart_0";

$db = mysql_connect($mysql_hostname, $mysql_user, $mysql_password) or die("Could not connect to MySQL.");
mysql_select_db($mysql_database, $db) or die("Again, could not connect to MySQL.");

?>