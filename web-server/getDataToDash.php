<?php
  include 'database.php';

  $pdo = Database::connect();
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $sql = 'SELECT fire, water FROM fwstatus';
  $q = $pdo->prepare($sql);
  $q->execute();
  $sensor = $q->fetch(PDO::FETCH_ASSOC);
  

  echo $sensor['fire'];
  echo " ", $sensor['water'];

  

  Database::disconnect();
?>