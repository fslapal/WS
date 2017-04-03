<?php
include ("connect.php");
include ("menu.html");

echo "<br>";

$conn = Connection();


    $sql = "SELECT date, time, pres, temp, hum FROM $table ORDER BY date DESC LIMIT 20";
    $result = $conn->query($sql);

    if ($result!==FALSE){

      echo "<br><table>";
      echo "<caption>Výpis posledních zaznamenaných hodnot</caption>";
      echo "<tr><th>Datum</th><th>Čas</th><th>Tlak</th><th>Teplota</th><th>Vlhkost</th></tr>";


      while ($row = $result->fetch()){
         echo "<tr>
               <td> {$row['date']} </td>
               <td> {$row['time']} </td>
               <td> {$row['pres']} </td>
               <td> {$row['temp']} </td>
               <td> {$row['hum']} </td>
               </tr>";
       }
        echo "</table>";

    }

    $conn=null;
?>
