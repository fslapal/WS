<?php

$sql = "SELECT time, pres, temp, hum FROM $table WHERE date = '$day'";

$result = $conn->query($sql);


if ($result!==FALSE){
  while ($row = $result->fetch()){

    $data[] = "$day {$row['time']},{$row['pres']},{$row['temp']},{$row['hum']}\n";

  }}

  foreach ($data as $export){
  echo $export;
  }


?>
