<?php
/**
  * @file extremes_longterm.php
  * @author Filip Šlapal
  * @date April, 2017
  * @brief Makes a table with extreme values from the desired interval.
*/
$sql = "SELECT MAX(temp), MAX(pres), MAX(hum) FROM $table WHERE date >= ? AND date <= ?";
$result = $conn->prepare($sql);
$result->execute(array($dayfrom, $dayto));

if ($result !== FALSE){
  while ($row = $result->fetch()){
    if (@@ROWCOUNT !== 0){
      $tempmax = $row['MAX(temp)'];
      $presmax = $row['MAX(pres)'];
      $hummax = $row['MAX(hum)'];
    }}}
$sql = "SELECT MIN(temp), MIN(pres), MIN(hum) FROM $table WHERE date >= ? AND date <= ?";
$result = $conn->prepare($sql);
$result->execute(array($dayfrom, $dayto));

if ($result !== FALSE){
  while ($row = $result->fetch()){
    if (@@ROWCOUNT !== 0){
      $tempmin = $row['MIN(temp)'];
      $presmin = $row['MIN(pres)'];
      $hummin = $row['MIN(hum)'];
        }}}
echo "<br>";
if (!empty($temp)){
  echo "<div id='max'>";
  echo "<table>";
  echo "<caption>Maximální hodnoty</caption>";
  echo "<tr><th>Teplota</th><th>Tlak</th><th>Vlhkost</th></tr>";
  echo "<tr><td>".$tempmax."</td>"."<td>".$presmax."</td>"."<td>".$hummax."</td></tr>";
  echo "</table></div>";
  echo "<div id='min'>";
  echo "<table>";
  echo "<caption>Minimální hodnoty</caption>";
  echo "<tr><th>Teplota</th><th>Tlak</th><th>Vlhkost</th></tr>";
  echo "<tr><td>".$tempmin."</td>"."<td>".$presmin."</td>"."<td>".$hummin."</td></tr>";
  echo "</table></div>";
  }
else{
  echo "Od ".$dayfrom." do ".$dayto." nejsou v databázi žádné záznamy!";
  }
?>
