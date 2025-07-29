<?php     
  require 'database.php';
  
  if (!empty($_POST)) {
    $data = $_POST['data'];
      
    // insert data
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "UPDATE relaystat SET Lamp = ? WHERE ID = 1";
    $q = $pdo->prepare($sql);
    $q->execute(array($data));
    Database::disconnect();
  }
?>