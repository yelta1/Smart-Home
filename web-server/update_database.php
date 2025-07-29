<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $appliance = $_POST['appliance'];
    $state = $_POST['state'];

    // Assuming you have a Database class or use a direct connection here
    $pdo = new PDO("mysql:host=localhost;dbname=dbstatusled", "root", "2003");

    $sql = "UPDATE relaystat SET $appliance = :state";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':state', $state, PDO::PARAM_INT);

    if ($stmt->execute()) {
        echo "Database updated successfully!";
    } else {
        echo "Error updating database.";
    }
    if ($pdo !== null) {
        $pdo = null;
    }
}
?>
