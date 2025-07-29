<?php
include 'database.php';
  
if (!empty($_POST)) {
    $data = $_POST['DNAME']; 

    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "SELECT Lamp FROM relaystat WHERE ID = 1";

    $q = $pdo->prepare($sql);
    $q->execute();
    $date = $q->fetch(PDO::FETCH_ASSOC);
    Database::disconnect();

    echo $date['Lamp'];
}
?>
