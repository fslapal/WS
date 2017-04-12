<?php
/**
  * @file connect.php
  * @author Filip Šlapal
  * @date April, 2017
  * @brief Establishes the connection.
*/
function Connection(){
  include ("variables.php"); //including variables

  try{
    $conn = new PDO("mysql:host=$servername;dbname=$db", $username, $password); //creating a new PDO connection
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //setting error handling
  }
  catch (PDOException $e){
    echo $e->getMessage(); //in case of an unsuccessful connection print an error message
    exit();
  }
  return $conn;
  }
?>
