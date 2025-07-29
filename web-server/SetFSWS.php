<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = $_POST['sensor_data']; // Получение данных от Arduino
    list($fir,$wat) = explode(',', $data); //Делим полученные данные на два
    // Подключение к базе данных MySQL
    $conn = new mysqli("localhost", "root", "2003", "dbstatusled");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    // Вставка данных в таблицу
    $sql = "UPDATE fwstatus SET fire = '$fir', water ='$wat' WHERE ID = 1";
    if ($conn->query($sql) === TRUE) {
        echo "Data inserted successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $conn->close();
} else {
    echo "Invalid request";
}
?>
