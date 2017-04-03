<?php
function Connection(){
include("variables.php");

    try {
			$conn = new PDO("mysql:host=$servername;dbname=$db", $username, $password);
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}

    catch (PDOException $e) {
			echo $e->getMessage();
			exit();
		}

    return $conn;

	}

?>
