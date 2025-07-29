<?php
include 'database.php';
  
if (!empty($_POST)) {
    $data = $_POST['DNAME']; 

    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    if ($data==0){
        $sql = "SELECT Air FROM relaystat WHERE ID = 1";
    } elseif($data == 1) {
        $sql = "SELECT Router FROM relaystat WHERE ID = 1";
    } elseif($data == 2) {
        $sql = "SELECT Fridge FROM relaystat WHERE ID = 1";
    } elseif($data == 3) {
        $sql = "SELECT Lamp FROM relaystat WHERE ID = 1";
    }
    $q = $pdo->prepare($sql);
    $q->execute();
    $date = $q->fetch(PDO::FETCH_ASSOC);
    Database::disconnect();

    
    if ($data==0){
        echo $date['Air'];
    } elseif($data == 1) {
        echo $date['Router'];    
    } elseif($data == 2) {
        echo $date['Fridge'];
    } elseif($data == 3) {
        echo $date['Lamp'];
    }
}
?>
