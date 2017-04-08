# WS
WS is a proof-of-concept student project. It was aimed at creating an indoor weather station based on Arduino that sends measured values to a web database.

# Components, wiring
![Wiring diagram](/Documentation/WS_diagram.png)
The complete scheme in Fritzing is available in the Documentation file.

## Components:
* Arduino Mega 2560 R3 - microprocessor
* ESP8266 - wifi module
* BME280 - temperature, humidity and pressure senosr
* RTC1307 - real time clock module (+ CR2025 battery)
* Catalex MicroSD card reader (+ MicroSD card)
* 20x4 LCD display

## Libraries:
* cactus_io_BME280_I2C (BME, RTC)
* DS1307RTC (RTC)
* LiquidCrystal (LCD)
* SD (SD module)
* SPI (BME, SD module)
* TimeLib (RTC)
* Wire (I2C -> BME, RTC)

# Installation
Code for the station was written and uploaded with help of Arduino IDE.  Atom was used for the PHP server side programming. To start this station, there are needed a few steps to complete:
1. Establish hosting, database and web page.
2. Fill in the Server/variables.php with your right credentials.
3. Upload the content of Server folder on your hosting server.
4. Run mysql_connect.php to create table in the database.
5. Wire up the Arduino according to the wiring diagram included in this file.
6. Fill in all the constants in the Arduino file with server, wifi and other wished credentials.
7. Upload the sketch to Arduino and afterwards ensure the power supply is plugged in. It is good to provide the RTC with battery. In case of blackout, the right time will be sustained.
8. Adjust both potentiometers to fit your desired brightness and contrast levels.
9. Rejoice the beautiful statistics and graphs made from your data.

# How does it work?
By setting the interval in the Arduino file a cycle for recording data begins. Every x hours the internet connection is checked. If ESP is connected, the presence of WS.txt file is checked. Data from BME and RTC together with possible data from the SD card is transferred directly to the server. In case of a lost connection, data is stored on an SD card inserted into Catalex module. Both BME and RTC work via I2C interface. A communication between Arduino and ESP runs on the serial line. SD card module is connected via SPI. The LCD display renews data every x minutes.
A communication between client and database is based on PDO and SQL commands.

# How to use WS?
The index page shows average and max data for last week with a possibility to change the time horizon. There is also displayed the current date and time and last added row to the database. In the right bottom corner you can choose a specific date to see the detail values and graph.
![Index](/Documentation/index.png)
The STATISTIKY page shows the longterm statistics of all values together with graph. You can change the desired date range.
![Stats](/Documentation/stats.png)
The VÝPIS HODNOT page creates a table of last 50 recorded values.
![List of values](/Documentation/list.png)
