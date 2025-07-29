<?php
  include 'database.php';

  $pdo = Database::connect();
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $sql = 'SELECT temp, humi FROM tempstat LIMIT 1';
  
  $q = $pdo->prepare($sql);
  $q->execute();
  $data = $q->fetch(PDO::FETCH_ASSOC);

  $sql = "SELECT 
  DAY(NOW()) as nowday, 
  CASE 
      WHEN MONTH(NOW()) = 1 THEN 'Қаңтар'
      WHEN MONTH(NOW()) = 2 THEN 'Ақпан'
      WHEN MONTH(NOW()) = 3 THEN 'Наурыз'
      WHEN MONTH(NOW()) = 4 THEN 'Сәуір'
      WHEN MONTH(NOW()) = 5 THEN 'Мамыр'
      WHEN MONTH(NOW()) = 6 THEN 'Маусым'
      WHEN MONTH(NOW()) = 7 THEN 'Шілде'
      WHEN MONTH(NOW()) = 8 THEN 'Тамыз'
      WHEN MONTH(NOW()) = 9 THEN 'Қыркүйек'
      WHEN MONTH(NOW()) = 10 THEN 'Қазан'
      WHEN MONTH(NOW()) = 11 THEN 'Қараша'
      WHEN MONTH(NOW()) = 12 THEN 'Желтоқсан'
  END as nowmonth,
  YEAR(NOW()) as nowyear;";
  $q = $pdo->prepare($sql);
  $q->execute();
  $date = $q->fetch(PDO::FETCH_ASSOC);

  Database::disconnect();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Умный дом</title>
    <link rel="stylesheet" type="text/css" href="css/style_dash.css" />
    <link rel="stylesheet" type="text/css" href="icon/ionicons.min.css">
    <script src="jquery.js"></script>
    <script src="scripts.js"></script>
    
</head>
<body>
<div class="dashboard">
  <header>
    <div class="f fe">
      <div class="ion-android-sunny big-ion"></div>
      <div class="heading">
        <h5 class="date"><?php echo $date['nowday'] ." ".$date['nowmonth']." ".$date['nowyear'];?></h5>
        <h2 class="title">Күн ашық</h2>
      </div>
    </div>
    
    <div class="weather f">
      <div>
      <strong id="temp_text">LoadC</strong>
        <p>Температура</p>
      </div>
      <div>
      <strong id="humi_text">Load%</strong>
        <p>Ылғалдылық</p>
      </div>
    </div>
  </header>
  <section>
  <!-- Category -->
    <div class="category">
      <ul>
        <li><a href="#!" class="active">Қонақ бөлмесі</a></li>
        <li><a href="#!">Ас үй</a></li>
        <li><a href="#!">Дәліз</a></li>
        <li><a href="#!">Ауа райы</a></li>
      </ul>
    </div>
  <!-- Appliances -->
    <div class="appliances">
      
      <div class="appliance">
        <input type="checkbox" name="a" id="a" class="checkbox" data-appliance="Lamp">
        <label for="a">
          <i class="l"></i>
          <strong>Шам</strong>
          <span data-o="opened" data-c="closed"></span>
          <small></small>
        </label>
      </div>
      
      <div class="appliance">
        <input type="checkbox" name="a" id="b" class="checkbox" data-appliance="Router" >
        <label for="b">
          <i class="r"></i>
          <strong>Роутер</strong>
          <span data-o="opened" data-c="closed"></span>
          <small></small>
        </label>
      </div>
      
      <div class="appliance">
        <input type="checkbox" name="a" id="c" class="checkbox" data-appliance="Air">
        <label for="c">
          <i class="a"></i>
          <strong>Желдеткіш</strong>
          <span data-o="opened" data-c="closed"></span>
          <small></small>
        </label>
      </div>
      
      <div class="appliance">
      <input type="checkbox" name="a" id="d" class="checkbox" data-appliance="Fridge">
        <label for="d">
          <i class="f"></i>
          <strong>Тоңазытқыш</strong>
          <span data-o="opened" data-c="closed"></span>
          <small></small>
        </label>
      </div>

      <div style="pointer-events: none; cursor: default;" class="appliance minebox">
        <label for="e" style="color: white;">
          <i class="ion-fireball ion"></i>
          <strong>Өрт</strong>
          <span id="fireText"></span>
        </label>
      </div>
      
      <div style="pointer-events: none; cursor: default;" class="appliance minebox">
        <label for="f" style="color: white;">
          <i class="ion-waterdrop ion"></i>
          <strong>Су</strong>
          <span id="waterText"></span>
        </label>
      </div>  
      
    </div>
  </section>
</div>

<!-- Custom fire alert -->
<div id="fireAlert" class="fireAlert flashingBackground">
        <div class="fireAlertContent">
            <span class="closeBtn" onclick="closeAlert()">&times;</span>
            <h2>Fire Alert!</h2>
            <p>There is a fire detected in the building. Please evacuate immediately!</p>
        </div>
    </div>

    <!-- Custom Water alert -->
<div id="waterAlert" class="fireAlert flashingBackground">
        <div class="fireAlertContent">
            <span class="closeBtn" onclick="closeAlert()">&times;</span>
            <h2>Water Alert!</h2>
            <p>There is a water detected in the building. Please check immediately!</p>
        </div>
    </div>
<script>
    /*setInterval(function(){
        location.reload();
    }, 10000);
*/
</script>

</body>
</html>
