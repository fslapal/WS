<?php

    $sql = "SELECT temp, pres, hum FROM $table WHERE date >= DATE_SUB(curdate(),INTERVAL $interval DAY)";

    $result = $conn->query($sql);

    if ($result!==FALSE){
       while ($row = $result->fetch()){
          if (@@ROWCOUNT!==0){

              $temp[] = $row['temp'];
              $pres[] = $row['pres'];
              $hum[] = $row['hum'];

       }}}


       $tempa = empty($temp) ? '' : array_sum($temp) / count($temp);
       $presa = empty($pres) ? '' : array_sum($pres) / count($pres);
       $huma = empty($hum) ? '' : array_sum($hum) / count($hum);

       if (!empty($temp)){

  echo "<div id='average'>";
  echo "<table>";
  echo "<caption>Průměrné hodnoty<caption>";
  echo "<tr><th>Teplota</th><th>Tlak</th><th>Vlhkost</th></tr>";
  echo "<tr><td>".round($tempa,2)."</td>"."<td>".round($presa,2)."</td>"."<td>".round($huma,2)."</td></tr>";
  echo "</table>
        </div>";
      }

      else{
  echo "";

      }


?>
