<?php
/**
  * @file averages.php
  * @author Filip Šlapal
  * @date April, 2017
  * @brief Makes a table and a graph with values from the desired interval
*/
$today = date("Y-m-d");
$lastyear = date("Y")-1;
$oney = date("$lastyear-m-d");

$dayfrom = empty($_GET['from']) ? $oney : $_GET['from'];
$dayto = empty($_GET['to']) ? $today : $_GET['to'];

include("datepicker.html");
include ('menu.html');
include ('connect.php');
$conn = Connection();

echo "
<div class='cals'>
Vyberte data od kdy do kdy:
<br><br>
<form action=".$_SERVER['PHP_SELF'].">
<input type='text' id='datepicker1' pattern='[0-9]{4}+-[0-9]{2}+-[0-9]{2}' name='from'>
<input type='text' id='datepicker2' pattern='[0-9]{4}+-[0-9]{2}+-[0-9]{2}' name='to'>
<input type='submit' value='Potvrdit'>
</div>

<div class='title'>
<h2>Hodnoty od: ".$dayfrom." do ".$dayto."</h2>
</div>";

echo "<div class='values'>";
include ('average_longterm.php');
include ('extremes_longterm.php');

echo "<div id='day'>";
include ('days_select.php');
echo "</div>";

echo "<br>";
include ('graph.html');
echo "</div>";

$conn = null;
?>
