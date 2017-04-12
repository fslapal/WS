<?php
/**
  * @file import.php
  * @author Filip Šlapal
  * @date April, 2017
  * @brief Imports sent values to the database.
*/
include("connect.php");
$conn = Connection();

$year = empty($_POST['y']) ? '' : $_POST['y'];
$month = empty($_POST['m']) ? '' : $_POST['m'];
$day = empty($_POST['d']) ? '' : $_POST['d'];
$hour = empty($_POST['h']) ? '' : $_POST['h'];
$minute = empty($_POST['a']) ? '' : $_POST['a'];
$temp = empty($_POST['t']) ? '' : $_POST['t'];
$pres = empty($_POST['p']) ? '' : $_POST['p'];
$hum = empty($_POST['hu']) ? '' : $_POST['hu'];
$password = empty($_POST['pass']) ? '' : $_POST['pass'];

$time = $hour.":".$minute;
$date = $year."-".$month."-".$day;

if ($password == $pass){
  $sql = "INSERT INTO $table (date, time, temp, pres, hum)
  VALUES (?, ?, ?, ?, ?)";
  $result = $conn->prepare($sql);
  $result->execute(array($date, $time, $temp, $pres, $hum));
  $conn = null;
  }

else{
  echo "Password isn't correct!";
  return false;
  }
?>
