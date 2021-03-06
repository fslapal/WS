<?php
/**
  * @file average.php
  * @author Filip Šlapal
  * @date April, 2017
  * @brief Makes a table with average values from the desired day until today.
*/
$sql = "SELECT temp, pres, hum FROM $table WHERE date >= DATE_SUB(curdate(),INTERVAL ? DAY)";
$result = $conn->prepare($sql);
$result->execute(array($interval)); //find values from the desired day on

if ($result !== FALSE){
  while ($row = $result->fetch()){
    if (@@ROWCOUNT !== 0){ //in case of successful result with rows returned save the values to an array
      $temp[] = $row['temp'];
      $pres[] = $row['pres'];
      $hum[] = $row['hum'];
    }}}

$tempa = empty($temp) ? '' : array_sum($temp) / count($temp); //average values count
$presa = empty($pres) ? '' : array_sum($pres) / count($pres);
$huma = empty($hum) ? '' : array_sum($hum) / count($hum);

if (!empty($temp)){
    echo "<div id='average'>"; //table with values
    echo "<table>";
    echo "<caption>Průměrné hodnoty<caption>";
    echo "<tr><th>Teplota</th><th>Tlak</th><th>Vlhkost</th></tr>";
    echo "<tr><td>".round($tempa,2)."</td>"."<td>".round($presa,2)."</td>"."<td>".round($huma,2)."</td></tr>";
    echo "</table></div>";
    }
else{
    echo "";
    }
?>
