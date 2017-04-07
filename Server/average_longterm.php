<?php

    $sql = "SELECT pres, temp, hum FROM $table WHERE date >= '$dayfrom' AND date <= '$dayto'";

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

  echo "<style>
      table, th, td {
      border: 1px solid black;
      border-collapse: collapse;
      text-align: center;
      }
    table{
        width: 95%;
        margin:auto;
         }
    caption{
      font-size: 20px;
      margin-bottom: 0.5em;
      }
        </style>";

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