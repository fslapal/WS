<?php
/**
  * @file day.php
  * @author Filip Šlapal
  * @date April, 2017
  * @brief Prints values of the desired day.
*/
$sql = "SELECT time, pres, temp, hum FROM $table WHERE date = ?";
$result = $conn->prepare($sql);
$result->execute(array($day));

if ($result !== FALSE){
  while ($row = $result->fetch()){
    $data[] = "$day {$row['time']},{$row['pres']},{$row['temp']},{$row['hum']}\n"; //saving values into an array
  }}
foreach ($data as $export){
  echo $export; //sending values to the Dygraph function
  }
?>
