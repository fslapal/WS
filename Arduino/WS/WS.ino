/*!
   @file WS.ino
   @author Filip Šlapal
   @date April, 2017
   @brief Weather station power by Arduino.
*/

#include <SPI.h>
#include <SD.h>
#include <Wire.h>
#include <TimeLib.h>
#include <DS1307RTC.h>
#include <LiquidCrystal.h>

#include "cactus_io_BME280_I2C.h"

/*!
  BME280 I2C address
*/
BME280_I2C bme(0x76);  //address of BME -> 0x76

char x;

/*!
  \brief Setting up LCD

  @param lcd (RS, E, D4, D5, D6, D7)
*/
LiquidCrystal lcd(x, x, x, x, x, x);

/*!
  WIFI SSID
*/
#define ssid "x"// SSID
/*!
  WIFI password
*/
#define pass "x"// Network Password
/*!
  Whole host server address
*/
#define host "x"// Webhost
/*!
  Shortened host server address
*/
#define host1 "x"
/*!
  Password for server
*/
#define password "x"
/*!
  Deviding sign in SD strings
*/
#define sign "x"
/*!
  SD card module pin
*/
#define cs_pin x
/*!
  Temperature from BME280
*/
float temperature;
/*!
  Humidity from BME280
*/
float humidity;
/*!
  Pressure from BME280
*/
float pressure;
/*!
  Second from RTM
*/
String s;
/*!
  Hour from RTM
*/
String h;
/*!
  Minute from RTM
*/
String mi;
/*!
  Minute to display on LCD (including null)
*/
String mi_0;
/*!
  Day from RTM
*/
String d;
/*!
  Year from RTM
*/
String y;
/*!
  Month from RTM
*/
String mo;
/*!
  SD card string - sign characters included
*/
String lex;
/*!
  SD card string - sign characters excluded
*/
String l;
/*!
  SD card string - sign characters included
*/
String lx;
/*!
  SD card string - count of strings to send
*/
int count;
/*!
  Integer for array
*/
int i;
/*!
  Integer for for() loop
*/
int a;
/*!
  Time variable
*/
int tim;
/*!
  Storing time from the beginning of program
*/
int oldtim;
/*!
  Interval in hours to start send procedure
*/
#define interval_hour x
/*!
  Interval in ms to repeat send procedure
*/
int interval = interval_hour * 60 * 60;
/*!
  Interval in seconds to start send procedure
*/
#define interval_second x
/*!
  Interval in ms to repeat lcd procedure
*/
int interval_lcd = interval_second;
/*!
  Time variable
*/
int tim_lcd;
/*!
  Storing time from the beginning of program
*/
int oldtim_lcd;
/*!
  Assigning month names
*/
const char *monthName[12] = {
  "Jan", "Feb", "Mar", "Apr", "May", "Jun",
  "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"
};
/*!
  RTC data storage
*/
tmElements_t tm;
/*!
  \brief Executed only once
*/
void setup(){
  //LCD initialization
  lcd.begin(20, 4);

  Serial1.begin(115200);
  Serial.begin(9600);

  //SD card initialization
  if (!SD.begin(cs_pin)){
    Serial.println("Card failed, or not present!");
    }
  else {
    Serial.println("Card initialized!");
    }


  bool parse = false;
  bool config = false;

  // get the date and time the compiler was run
  if(getDate(__DATE__) && getTime(__TIME__)){
    parse = true;
    // and configure the RTC with this info
    if(RTC.write(tm)){
      config = true;
      }
    }

  if(parse && config){
    Serial.println("Time set successfully!");
    }
  else if(parse){
    Serial.println("Configuration wasn't done!");
    }
  else{
    Serial.println("Parsing wasn't successful!");
    }
  //BME280 initialization
  if(!bme.begin()){
    Serial.println("BME280 doesn't work!");
    }
  else{
    Serial.println("BME280 works!");
    }

  bme.setTempCal(-1);// Temperature correction

  lcd.setCursor(0, 0);
  lcd.print("Starting WS...");
  lcd.setCursor(0, 1);
  lcd.print("Components:");
  lcd.setCursor(0, 2);
  lcd.print("BME280, RTC");
  lcd.setCursor(0, 3);
  lcd.print("Catalex SD, ESP8266");

  oldtim = 0;
  oldtim_lcd = 0;
  }
/*!
  \brief Repeated loop
*/
void loop(){
  /*!
    \briefRTC data read
  */
  if(RTC.read(tm){
    h = (tm.Hour);
    s = (tm.Second);
    mi = (tm.Minute);
    d = (tm.Day);
    mo = (tm.Month);
    y = (tmYearToCalendar(tm.Year));
    }
  else{
    }

  if(mi == "0" || mi == "1" || mi == "2" || mi == "3" || mi == "4" || mi == "5" || mi == "6" || mi == "7" || mi == "8" || mi == "9"){
    mi_0 = "0";
    mi_0 += mi;
    }
  else{
    mi_0 = mi;
    }


  //Reading data from BME280
  bme.readSensor();

  pressure = (bme.getPressure_MB());
  humidity = (bme.getHumidity());
  temperature = (bme.getTemperature_C());

  tim = millis() / 1000;
  tim_lcd = millis() / 1000;

  if(tim_lcd == oldtim_lcd + interval_lcd){
    lcd.clear();
    lcd.setCursor(0, 0);
    lcd.print(d);
    lcd.print(".");
    lcd.print(mo);
    lcd.print(".");
    lcd.print(y);
    lcd.print(" ");
    lcd.print(" ");
    lcd.print(h);
    lcd.print(":");
    lcd.print(mi_0);

    lcd.setCursor(0, 1);
    lcd.print("Teplota: ");
    lcd.print(temperature);

    lcd.setCursor(0, 2);
    lcd.print("Tlak: ");
    lcd.print(pressure);

    lcd.setCursor(0, 3);
    lcd.print("Vlhkost: ");
    lcd.print(humidity);

    oldtim_lcd = tim_lcd;
    }
  else{}
  if(tim == oldtim + interval){
    connectWiFi();
    oldtim = tim;
  }
  else{}
  }
/*!
  \brief Writing data to SD card.

  Data from sensors and password are stored in a string suitable for post request (devided by & sign). At the end of each string a delimiter is added.
  @return Returns a message to Serial line.
*/
void SDwrite(){

  File dataFile = SD.open("ws.txt", FILE_WRITE);
  if(dataFile){
    String cmd = "y=";
    cmd += y;
    cmd += "&m=";
    cmd += mo;
    cmd += "&d=";
    cmd += d;
    cmd += "&h=";
    cmd += h;
    cmd += "&a=";
    cmd += mi;
    cmd += "&t=";
    cmd += temperature;
    cmd += "&p=";
    cmd += pressure;
    cmd += "&hu=";
    cmd += humidity;
    cmd += "&pass=";
    cmd += password;
    cmd += sign;

    dataFile.print(cmd);
    dataFile.close();

    Serial.println("Data written successfully!");
    delay(2000);
    return;
    }
  else{
    Serial.println("Couldn't write data!");
    return;
    }
  }
/*!
  \brief RTC get time.

  Setting date to RTC.
  @param data from compiler
*/
bool getTime(const char *str){
  int Hour, Min, Sec;
  if(sscanf(str, "%d:%d:%d", &Hour, &Min, &Sec) != 3) return false;
    tm.Hour = Hour;
    tm.Minute = Min;
    tm.Second = Sec;
    return true;
}
/*!
  \brief RTC get date.

  Setting date to RTC.
  @param data from compiler
*/
bool getDate(const char *str){
  char Month[12];
  int Day, Year;
  uint8_t monthIndex;
  if (sscanf(str, "%s %d %d", Month, &Day, &Year) != 3) return false;
    for (monthIndex = 0; monthIndex < 12; monthIndex++) {
      if (strcmp(Month, monthName[monthIndex]) == 0) break;
      }
  if(monthIndex >= 12) return false;
    tm.Day = Day;
    tm.Month = monthIndex + 1;
    tm.Year = CalendarYrToTm(Year);
    return true;
}
/*!
  \brief Checking WIFI connection.

  ESP8266 is set to STA mode. The preset values are applied to find the correct wifi and connect to it.
  A single connection is initialized. In case of successful connection, the SDread() function is called. In the other case, SDwrite() function is called.
  @return Returns either true or false.
*/
boolean connectWiFi() {
  Serial1.println("AT");
  delay(1000);
  if(Serial1.find("OK")){
    Serial1.println("AT+CWMODE=1");
    delay(2000);
    }
  String con = "AT+CWJAP=\"";
  con += ssid;
  con += "\",\"";
  con += pass;
  con += "\"";
  Serial1.println(con);
  delay(10000);
  if(Serial1.find("OK")){
    String mux = "AT+CIPMUX=0";
    Serial1.println(mux);
    if (Serial1.find("OK")) {
      Serial.println("Connection to WIFI successful!");
      Serial.println("Mode successfully set!");
      lcd.setCursor(19, 0);
      lcd.print(1);
      SDread();
      return true;
      }
    }
  else {
    Serial.println("Connection unsuccessful!");
    lcd.setCursor(19, 0);
    lcd.print(0);
    SDwrite();
    return false;
  }
}
/*!
  \brief Reading data from SD card.

  A string is devided into tokens. Their count is determined by comparing the lengths of strings with and without delimiter. The individual tokens are then passed to sendSD() function as strings.
*/
void SDread() {
  if(SD.exists("ws.txt")){
    Serial.println("Data found on the SD card!");
    File myFile = SD.open("ws.txt");
    if(myFile){
      // read from the file until there's nothing else in it:
      while (myFile.available() > 0) {
        lx = myFile.readString();
        lex += lx;
        }
      l = lex;
      l.replace("x", "");

      int lenx = lex.length();
      int len = l.length();
      count = lenx - len;

      char request[lenx];
      lx.toCharArray(request, lenx);

      char *req[len];
      i = 0;

      req[i] = strtok(request, "x");

      while(req[i] != NULL){
        req[++i] = strtok(NULL, "x");
        }
      for(a = 0; a < count; a++){
        String irequest = req[a];
        sendSD(String(irequest));
        delay(2500);
        }
      }
    myFile.close();
    SD.remove("ws.txt");
    delay(1000);

    sendData(String(y), String(mo), String(d), String(h), String(mi), String(temperature), String(humidity), String(pressure), String(password));
    return;
    }
  else{
    Serial.println("No data on SD card!");
    sendData(String(y), String(mo), String(d), String(h), String(mi), String(temperature), String(humidity), String(pressure), String(password));
    return;
    }
}
/*!
  \brief Sending data stored on SD card

  A TPC connecion is established with the server and values are sent via a POST request to the web page PHP script that adds them to the databse.
  @param token from the SD card
*/
void sendSD(String request){
  String cipstart = "AT+CIPSTART=\"TCP\",\"";         // Set up TCP connection
  cipstart += host;
  cipstart += "\",80";

  Serial1.println(cipstart);
  delay(2000);

  if(Serial1.find("OK")){
    Serial.println("Connection to server successful!");
    String cmd = request;
    String post = "POST /import.php HTTP/1.1";
    String post1 = "Host: ";
    post1 += host1;
    String post2 = "Accept: */*";
    String post3 = "Content-Length: ";
    post3 += cmd.length();
    String post4 = "Content-Type: application/x-www-form-urlencoded; charset=UTF-8:";

    int len = post.length() + post1.length() + post2.length() + post3.length() + post4.length() + cmd.length() + 15;

    String cipsend = "AT+CIPSEND=";
    cipsend += len;

    Serial1.println(cipsend);
    delay(500);

    if(Serial1.find(">")){
      Serial1.println(post);
      Serial1.println(post1);
      Serial1.println(post2);
      Serial1.println(post3);
      Serial1.println(post4);
      Serial1.println();
      Serial1.println(cmd);
      Serial1.println();
      Serial1.println();
      }
    else{
      Serial.println("There is a problem with CIPSEND command!");
      }
    if(Serial1.find("SEND OK")){
      Serial.println("Data send successfully!");
      }
    else{
      Serial.println("Something went wrong!");
      }
    delay(2000);
  }
  return;
}
/*!
  \brief Sending data directly from BME280

  A TPC connecion is established with the server and data are send via a POST request to the script that adds them to the databse.
  @param values from the BME280 and RTC1307
*/
void sendData(String eyear, String emonth, String eday, String ehour, String eminute, String etemp, String ehum, String epres, String epassword) {
  String cipstart = "AT+CIPSTART=\"TCP\",\"";         // Set up TCP connection
  cipstart += host;
  cipstart += "\",80";

  Serial1.println(cipstart);
  delay(2000);

  if (Serial1.find("OK")) {
    Serial.println("Connection to server successful!");

    String cmd = "y=";
    cmd += eyear;
    cmd += "&m=";
    cmd += emonth;
    cmd += "&d=";
    cmd += eday;
    cmd += "&h=";
    cmd += ehour;
    cmd += "&a=";
    cmd += eminute;
    cmd += "&t=";
    cmd += etemp;
    cmd += "&p=";
    cmd += epres;
    cmd += "&hu=";
    cmd += ehum;
    cmd += "&pass=";
    cmd += epassword;

    String post = "POST /import.php HTTP/1.1";
    String post1 = "Host: ";
    post1 += host1;
    String post2 = "Accept: */*";
    String post3 = "Content-Length: ";
    post3 += cmd.length();
    String post4 = "Content-Type: application/x-www-form-urlencoded; charset=UTF-8:";

    int len = post.length() + post1.length() + post2.length() + post3.length() + post4.length() + cmd.length() + 15;

    String cipsend = "AT+CIPSEND=";
    cipsend += len;

    Serial1.println(cipsend);
    delay(500);

    if(Serial1.find(">")){
      Serial1.println(post);
      Serial1.println(post1);
      Serial1.println(post2);
      Serial1.println(post3);
      Serial1.println(post4);
      Serial1.println();
      Serial1.println(cmd);
      Serial1.println();
      Serial1.println();
      }
    else{
      Serial.println("There is a problem with CIPSEND command!");
      }
    if(Serial1.find("SEND OK")){
      Serial.println("Data send successfully!");
      }
    else{
      Serial.println("Something went wrong!");
      }
    delay(2000);
  }
  return;
}
