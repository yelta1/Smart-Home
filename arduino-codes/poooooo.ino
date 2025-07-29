//ESP32 WEMOS D1 code

#include <WiFi.h>
#include <HTTPClient.h>

#define fs 36 //Fire Sensor Pin
int const ws = 14;        // Water Sensor Pin (GPIO14[digitalPin on WeMOS])

const char* ssid = "SmartHome";
const char* password = "Iitu2024";

String host_or_IPv4 = "http://192.168.1.101/";
String Destination = "";
String URL_Server = "";

String getData = "";
String payloadGet = "";

HTTPClient http;
WiFiClient client;

void setup() {
  Serial.begin(115200);
  delay(500);

  WiFi.begin(ssid, password);
  Serial.println("");

  pinMode(ws, INPUT);
  pinMode(fs, INPUT);

  Serial.print("Connecting");
  while (WiFi.status() != WL_CONNECTED) {
    Serial.print(".");
  }
  Serial.println("");
  Serial.print("Successfully connected to: ");
  Serial.println(ssid);
  Serial.print("IP address: ");
  Serial.println(WiFi.localIP());
  Serial.println();

  delay(2000);
}

void loop() {
    int val_fs = analogRead(fs);
    val_fs = val_fs/4;
    int val_ws = digitalRead(ws);
    Serial.println("FS: " + String(val_fs));
    Serial.println("WS: " + String(val_ws));
    String data = "";
    if (val_fs <= 20) {
      data += "Detected";
    } else {
      data += "OK";
    }
      data+=",";

    if (val_ws == 1){
      data += "Detected";
    } else {
      data += "OK";
    }

    String datas = data;
    getData = "sensor_data=" + String(datas);
    Destination = "SetFSWS.php";
    URL_Server = host_or_IPv4 + Destination;
    Serial.println("----------------Connect to Server-----------------");
    Serial.println("Get LED Status from Server or Database");
    Serial.print("Request Link : ");
    Serial.println(URL_Server);
    http.begin(client, URL_Server); //--> Specify request destination
    http.addHeader("Content-Type", "application/x-www-form-urlencoded");    //Specify content-type header
    int httpCodeGet = http.POST(getData); //--> Send the request
  
    Serial.println("----------------Closing Connection----------------");
    http.end(); //--> Close connection
    Serial.println();
    Serial.println("Please wait 10 seconds for the next connection.");
    Serial.println();
    delay(1000);
}