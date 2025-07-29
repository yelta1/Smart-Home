
setInterval(testt, 500);
setInterval(tempUpdate, 10000);



$(document).ready(function () {
    $('.checkbox').on('change', function () {
      var appliance = $(this).data('appliance');
      var state = this.checked ? 1 : 0;

      // Send the data to the PHP script using AJAX
      $.ajax({
        type: 'POST',
        url: 'update_database.php',
        data: { appliance: appliance, state: state },
        success: function (response) {
          console.log(response); // Log the server response (optional)
        },
        error: function (error) {
          console.error('Error:', error);
        }
      });
    });
  });


function testt(){
    var pose = document.getElementById("fireText");
    var pose2 = document.getElementById("waterText");
        // Send the data to the PHP script using AJAX
        $.ajax({
          type: 'GET',
          url: 'getDataToDash.php',
          success: function (response) {
            var parts = response.split(" ");
            if (parts.length >= 1) {
              pose.innerHTML = parts[0];
            }
            if (parts.length >= 2) {
              pose2.innerHTML = parts[1];
            }

            if (parts[0] != "OK"){
                alarm("Fire");
            }
            
            if (parts[1] != "OK"){
                alarm("Water");
            }
          },
          error: function (error) {
            console.error('Error:', error);
          }
        });
}

function tempUpdate(){
  var elem1 = document.getElementById("temp_text");
  var elem2 = document.getElementById("humi_text");

  $.ajax({
    type: 'GET',
    url: 'GetData.php',
    success: function (response) {
      var parts = response.split(" ");
      if (parts.length >= 1) {
        elem1.innerHTML = parts[0] + " ℃";
      }
      if (parts.length >= 2) {
        elem2.innerHTML = parts[1] + " %";
      }
    },
    error: function (error) {
      console.error('Error:', error);
    }
  });
}



function alarm(app){
    if (app === "Fire"){
        showAlert(1);
    } 
    if (app === "Water"){
        showAlert(2);
    }
}

function showAlert(code) {
    if (code == 1){
        var fireAlert = document.getElementById("fireAlert");
        fireAlert.style.display = "block";
    } 

    if (code == 2){
        var fireAlert = document.getElementById("waterAlert");
        fireAlert.style.display = "block";
    }
    
}

function closeAlert() {
    var fireAlert = document.getElementById("fireAlert");
    var waterAlert = document.getElementById("waterAlert");
    fireAlert.style.display = "none";
    waterAlert.style.display = "none";
}
