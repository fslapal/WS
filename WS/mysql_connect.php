<?php
include("connect.php");

$conn = Connection();
$sql = "CREATE TABLE IF NOT EXISTS $table (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    date DATE NOT NULL,
    time TIME NOT NULL,
    temp FLOAT(4,2) NOT NULL,
    pres FLOAT(6,2) NOT NULL,
    hum FLOAT(5,2) NOT NULL
    )";

$conn->exec($sql);
$conn = null;
echo "Tabulka úspěšně přidána do databáze!";
?>
