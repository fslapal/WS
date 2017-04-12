<?php
/**
  * @file days_select.php
  * @author Filip Šlapal
  * @date April, 2017
  * @brief Prints values from the desired interval.
*/
$sql = "SELECT date, time, pres, temp, hum FROM $table WHERE date >= ? AND date <= ?";
$result = $conn->prepare($sql);
$result->execute(array($dayfrom, $dayto));

if ($result !== FALSE){
  while ($row = $result->fetch()){
    $data[] = "{$row['date']} {$row['time']},{$row['pres']},{$row['temp']},{$row['hum']}\n"; //saving values into an array
  }}
foreach ($data as $export){
  echo $export; //sending values to the Dygraph function
  }
?>
