<?php
/**
  * @file index.php
  * @author Filip Šlapal
  * @date April, 2017
  * @brief Index page
*/
include ("menu.html");
include ("connect.php");
include("datepicker.html");

$conn = Connection();

$int = 7;
$interval = empty($_GET['int']) ? $int : $_GET['int'];

if ($interval == 1){
  $days = ' za poslední den';
  $days_no = ' poslední den';
  }
else if ($interval == 2 || $interval == 3 || $interval == 4){
  $days = ' za poslední '.$interval.' dny';
  $days_no = ' poslední '.$interval.' dny';
  }
else {
  $days = ' za posledních '.$interval.' dní';
  $days_no = ' posledních '.$interval.' dní';
  }

echo "<div class='data'>
<h2>Statistiky ".$days."</h2>
<form action=".$_SERVER['PHP_SELF'].">
  Zde vyberte jiné časové období (maximálně rok):<br><br>
  <input type='number' name='int' min='1' max='365' value='7'>
  <input type='submit' value='Potvrdit'>
</form>
<br>
";

include ("average.php");
include ("extremes.php");

echo "</div>";

echo "<div class='time'>
<h2>Informace</h2>";
echo date("d.m.Y");
echo "<br>";
echo date("h:i");
echo "<br><br>";

echo "Poslední přidaný záznam:<br>";

$sql = "SELECT date, time, pres, temp, hum FROM $table  WHERE id = (SELECT MAX(ID) FROM $table)";
$result = $conn->query($sql);

if ($result !== FALSE){
  while ($row = $result->fetch()){
    echo "<tr>
          <td> {$row['date']} </td>
          <td> {$row['time']} </td>
          <td> {$row['pres']} </td>
          <td> {$row['temp']} </td>
          <td> {$row['hum']} </td>
          </tr>";
   }}

echo "</div>";

echo "<div class='calendar'>
<h2>Vyberte datum pro podrobnosti</h2>
<form action='stats.php'>
<input type='text' id='datepicker1' pattern='[0-9]{4}+-[0-9]{2}+-[0-9]{2}' name='date'>
<input type='submit' value='Potvrdit'></div>";

$conn = null;
?>
