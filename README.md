# WS
WS is a proof-of-concept student project. It was aimed at creating an indoor weather station based on Arduino that sends measured values to a web database.

<a href="https://www.github.com/fslapal/WS">GitHub repositary</a>

# Components, wiring
![Wiring diagram](/Documentation/WS_diagram.png)

The complete scheme in the Fritzing is available in the Documentation file.

## Components:
* Arduino Mega 2560 R3 - microprocessor
* ESP8266 - wifi module
* BME280 - temperature, humidity and pressure sensor
* RTC1307 - real time clock module (+ CR2025 battery)
* Catalex MicroSD card module (+ MicroSD card)
* 20x4 LCD display

## Libraries:
These libraries together with their example scripts were used to complete the project. All of them are uploaded in the folder Arduino/Libraries.
* cactus_io_BME280_I2C (BME, RTC)
* DS1307RTC (RTC)
* LiquidCrystal (LCD)
* SD (SD module)
* SPI (BME, SD module)
* TimeLib (RTC)
* Wire (I2C -> BME, RTC)

# Installation
Code for the station was written and uploaded with the help of Arduino IDE. Atom was used for the PHP server side programming. To start this station, there are needed a few steps to complete:
1. Establish hosting, database and web page.
2. Fill in the Server/variables.php with your right credentials.
3. Upload the content of Server folder on your hosting server.
4. Run mysql_connect.php to create table in the database.
5. Wire up the Arduino according to the wiring diagram included in this file.
6. Fill in all the constants in the Arduino file with server, wifi and other wished credentials (instead of the x sign).
7. Upload the sketch to Arduino and afterwards ensure the power supply is plugged in. It is good to provide the RTC with battery. In case of blackout, the right time will be sustained.
8. Adjust both potentiometers to fit your desired brightness and contrast levels.
9. Rejoice the beautiful statistics and graphs made from your data.

# Manufacturing
After wiring all the Arduino components, choose a convenient box to make the case from. Then a few holes should be done. One for the lcd display, one for the BME to be outside of the box, two for Arduino connectors and two for potentiometers.
## Possible result
![Overview with wires](/Documentation/overview.png)

![Connectors](/Documentation/connector.png)

![Front](/Documentation/front.png)

![BME](/Documentation/BME.png)

# How does it work?
By setting the interval in the Arduino file a cycle for recording data begins. Every x hours the internet connection is checked. If the ESP is connected, the presence of WS.txt file is checked. Data from the BME and the RTC together with another possible data from the SD card is transferred directly to the server. In case of a lost connection, data is stored on the SD card inserted into the Catalex module. Both the BME and the RTC work via I2C interface. A communication between Arduino and the ESP runs on the serial line. The SD card module is connected via SPI. The LCD display renews data every x minutes.
A communication between client and database is based on PDO and SQL commands.

# How to use WS?
It is necessary to upload the Arduino script only once. Afterwards, only power supply must be provided for the weather station to function. If a battery is installed in the RTC module, you can disingage the power as you wish and the right time will be sustained. The index page shows the average, max and min data for the last week with a possibility to change the time horizon. There is also displayed the current date and time and last added row to the database. In the right bottom corner you can choose a specific date to see the detail values and a graph.
![Index](/Documentation/index.png)

The STATISTIKY page shows the longterm statistics of all values together with a graph. You can change the desired date range.
![Stats](/Documentation/stats.png)

The VÝPIS HODNOT page creates a table of the last 20 recorded values.
![List of values](/Documentation/list.png)

# Possible extension
One of the most obvious choice is deploying a BT module. The measured data could by transferred to a mobile phone via bluestooth and displayed in an app. The post request would be changed just to simple strings with the values that would be sent via the serial line to the HC-05 or HC-06 modules.
