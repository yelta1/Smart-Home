#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>
#include <WiFiClient.h>
#include <DHT.h>
//----------------------------------------

#define DHTPIN D2      // Пин, к которому подключен DHT11
#define DHTTYPE DHT11 
//----------------------------------------SSID and Password of your WiFi router.
const char* ssid = ""; //--> Your wifi name or SSID.
const char* password = ""; //--> Your wifi password.
//----------------------------------------

//----------------------------------------Web Server address / IPv4
// If using IPv4, press Windows key + R then type cmd, then type ipconfig (If using Windows OS).
// String host_or_IPv4 = "http://Your_Host_or_IP";
// Example :
// String host_or_IPv4 = "http://192.168.1.103/";
String host_or_IPv4 = "your_host_ip";

String Destination = "";
String URL_Server = "";
//----------------------------------------

//----------------------------------------
String getData = "";
String payloadGet = "";
//----------------------------------------

//----------------------------------------
HTTPClient http; //--> Declare object of class HTTPClient
WiFiClient client;
//----------------------------------------
DHT dht(DHTPIN, DHTTYPE);
void setup() {
  // put your setup code here, to run once:
  Serial.begin(115200);
  delay(500);

  WiFi.mode(WIFI_STA);
  WiFi.begin(ssid, password); //--> Connect to your WiFi router
  Serial.println("");
    
  pinMode(ON_Board_LED,OUTPUT); //--> On Board LED port Direction output
  digitalWrite(ON_Board_LED, HIGH); //--> Turn off Led On Board

  pinMode(LED_D8,OUTPUT); //--> LED port Direction output
  digitalWrite(LED_D8, LOW); //--> Turn off Led

  //----------------------------------------Wait for connection
  Serial.print("Connecting");
  while (WiFi.status() != WL_CONNECTED) {
    Serial.print(".");
    //----------------------------------------Make the On Board Flashing LED on the process of connecting to the wifi router.
    digitalWrite(ON_Board_LED, LOW);
    delay(250);
    digitalWrite(ON_Board_LED, HIGH);
    delay(250);
    //----------------------------------------
  }
  //----------------------------------------
  digitalWrite(ON_Board_LED, HIGH); //--> Turn off the On Board LED when it is connected to the wifi router.
  //----------------------------------------If successfully connected to the wifi router, the IP Address that will be visited is displayed in the serial monitor
  Serial.println("");
  Serial.print("Successfully connected to : ");
  Serial.println(ssid);
  Serial.print("IP address: ");
  Serial.println(WiFi.localIP());
  Serial.println();
  //----------------------------------------

  delay(2000);

  dht.begin();
}

void loop() {
  // put your main code here, to run repeatedly:
  float humidity = dht.readHumidity();
  float temperature = dht.readTemperature();
  //----------------------------------------
  // From my tests, after uploading the program code, the connection for the first time may fail (-1). But the next connection is fine/runs smoothly.
  //----------------------------------------

  //----------------------------------------Getting Data from MySQL Database
  String datas = String(humidity) + "," + String(temperature);
  getData = "sensor_data=" + String(datas);
  Destination = "SetTemp.php";
  URL_Server = host_or_IPv4 + Destination;
  Serial.println("----------------Connect to Server-----------------");
  Serial.println("Get LED Status from Server or Database");
  Serial.print("Request Link : ");
  Serial.println(URL_Server);
  http.begin(client, URL_Server); //--> Specify request destination
  http.addHeader("Content-Type", "application/x-www-form-urlencoded");    //Specify content-type header
  int httpCodeGet = http.POST(getData); //--> Send the request
  payloadGet = http.getString(); //--> Get the response payload from server
  Serial.print("Response Code : "); //--> If Response Code = 200 means Successful connection, if -1 means connection failed. For more information see here : https://en.wikipedia.org/wiki/List_of_HTTP_status_codes
  Serial.println(httpCodeGet); //--> Print HTTP return code
  Serial.print("Returned data from Server : ");
  Serial.println(payloadGet); //--> Print request response payload
  
  Serial.println("----------------Closing Connection----------------");
  http.end(); //--> Close connection
  Serial.println();
  Serial.println("Please wait 10 seconds for the next connection.");
  Serial.println();
  delay(30000); //--> GET Data at every 10 seconds. From the tests I did, when I used the 5 second delay, the connection was unstable.
}
