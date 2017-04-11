<?php

$sql = "SELECT time, pres, temp, hum FROM $table WHERE date = '$day'";
$result = $conn->query($sql);


if ($result!==FALSE){
  echo "<table>";
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
