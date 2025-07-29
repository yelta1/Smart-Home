//ESP8266 with relay on board code
#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>
#include <WiFiClient.h>
//----------------------------------------
#define rl 4 // Relay pin

#define btn 5   // TouchSensor pin
//----------------------------------------
const char* ssid = "SmartHome"; //--> Wifi name 
const char* password = "Iitu2024"; //--> Wifi password
//----------------------------------------
String host_or_IPv4 = "http://192.168.1.101/";
String Destination = "";
String URL_Server = "";
//----------------------------------------
String getData = "";
String payloadGet = "";
//----------------------------------------
HTTPClient http; 
WiFiClient client;
//----------------------------------------

void setup() {

  Serial.begin(115200);
  delay(500);

  WiFi.mode(WIFI_STA);
  WiFi.begin(ssid, password); //--> Connect to your WiFi router
  Serial.println("");


  pinMode(rl,OUTPUT);
  pinMode(btn, INPUT);

  Serial.print("Connecting");
  while (WiFi.status() != WL_CONNECTED) {
    Serial.print(".");
  }
  
  Serial.println("");
  Serial.print("Successfully connected to : ");
  Serial.println(ssid);
  Serial.print("IP address: ");
  Serial.println(WiFi.localIP());
  Serial.println();
  //----------------------------------------

  delay(2000);
}

int rl_state = 0;

void relayFunc(){
  getData = "DNAME=" + String(3);
  Destination = "updRL.php";
  URL_Server = host_or_IPv4 + Destination;

  http.begin(client, URL_Server); //--> Specify request destination
  http.addHeader("Content-Type", "application/x-www-form-urlencoded");    //Specify content-type header
  int httpCodeGet = http.POST(getData); //--> Send the request
  payloadGet = http.getString();

  if (payloadGet == "1") {
    digitalWrite(rl, HIGH);
    rl_state = 1;
  }
  if (payloadGet == "0") {
    digitalWrite(rl, LOW);
    rl_state = 0;
  }

  http.end(); 
  delay(1000);

}

void updRLstate(){
  getData = "appliance=Lamp&state=" + String(rl_state); 
  Destination = "update_database.php";
  URL_Server = host_or_IPv4 + Destination;

  http.begin(client, URL_Server); //--> Specify request destination
  http.addHeader("Content-Type", "application/x-www-form-urlencoded");    //Specify content-type header
  int httpCodeGet = http.POST(getData); //--> Send the request
  
  http.end(); 
  delay(1000);
}

void loop() {
  relayFunc();
  //delay(10000);
  if (digitalRead(btn) == HIGH){
    if (rl_state == 0){
        digitalWrite(rl, HIGH);
        rl_state = 1;
        updRLstate();
    } else {
        digitalWrite(rl, LOW);
        rl_state = 0;
        updRLstate();
    }
  }
  delay(1000);
}