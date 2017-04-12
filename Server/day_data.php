<?php
/**
  * @file day_data.php
  * @author Filip Šlapal
  * @date April, 2017
  * @brief Selects values of the desired day.
*/
$sql = "SELECT time, pres, temp, hum FROM $table WHERE date = ?";
$result = $conn->prepare($sql);
$result->execute(array($day)); //select values recorded on the desired date

if ($result !== FALSE){
  echo "<table>"; //table with values
  echo "<caption>Výpis zaznamenaných hodnot</caption>";
  echo "<tr><th>Čas</th><th>Teplota</th><th>Vlhkost</th><th>Tlak</th></tr>";
  while ($row = $result->fetch()){
     echo "<tr>
           <td> {$row['time']} </td>
           <td> {$row['pres']} </td>
           <td> {$row['temp']} </td>
           <td> {$row['hum']} </td>
           </tr>";
     }
 echo "</table>";
 }
else{
  echo "Nejsou k dispozici hodnoty!";
  }
?>
