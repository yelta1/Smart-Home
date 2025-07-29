<?php
include 'database.php';
  


    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "SELECT temp, humi FROM tempstat WHERE ID = 1";

    $q = $pdo->prepare($sql);
    $q->execute();
    $date = $q->fetch(PDO::FETCH_ASSOC);
    Database::disconnect();

    echo $date['temp'];
    echo " ", $date['humi'];

?>
