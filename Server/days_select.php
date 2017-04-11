<?php
$sql = "SELECT date, time, pres, temp, hum FROM $table WHERE date >= '$dayfrom' AND date <= '$dayto'";
$result = $conn->query($sql);

if ($result!==FALSE){
  while ($row = $result->fetch()){
    $data[] = "{$row['date']} {$row['time']},{$row['pres']},{$row['temp']},{$row['hum']}\n";
  }}
  foreach ($data as $export){
  echo $export;
  }
?>
