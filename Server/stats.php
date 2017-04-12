<?php
/**
  * @file stats.php
  * @author Filip Šlapal
  * @date April, 2017
  * @brief Shows statistics and grah for the desired day.
*/
$today = date("Y-m-d");
$day = empty($_GET['date']) ? $today : $_GET['date'];

include ('menu.html');
include ('connect.php');
$conn = Connection();

echo "<h2>Hodnoty za den: ".$day."</h2>";
echo "<div id='day'>";
include ('day.php');
echo "</div>";

include ('graph.html');
include ('day_data.php');
?>
