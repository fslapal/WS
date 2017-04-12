<?php
/**
  * @file import.php
  * @author Filip Šlapal
  * @date April, 2017
  * @brief Shows a graph.
*/
$today = date("Y-m-d");
$day = empty($_GET['date']) ? $today : $_GET['date'];
$int = 7;
$interval = empty($_GET['int']) ? $int : $_GET['int'];

include ('menu_localhost.html');
include ('connect_localhost.php');
$conn = Connection();

echo "<br>";
include ('day.php');
include ('graph.html');
?>
