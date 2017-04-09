# WS
WS je studentským projektem ověřujícím možnost realizace konceptu vnitřní meteostanice fungující na bázi Arduina, který umožňuje posílat naměřené hodnoty do webové databáze.

# Komponenty, schéma zapojení
![Wiring diagram](/Documentation/WS_diagram.png)
Kompletní Fritzing schéma je k dispozici ve složce Documentation.

## Components:
* Arduino Mega 2560 R3 - mikroprocesor
* ESP8266 - wifi modul
* BME280 - senzor teploty, vlhkosti a tlaku
* RTC1307 - modul reálného času (+ CR2025 baterie)
* Catalex MicroSD modul (+ MicroSD karta)
* 20x4 LCD displej

## Libraries:
* cactus_io_BME280_I2C (BME, RTC)
* DS1307RTC (RTC)
* LiquidCrystal (LCD)
* SD (SD module)
* SPI (BME, SD module)
* TimeLib (RTC)
* Wire (I2C -> BME, RTC)

# Installation
Kód byl napsán a uploadován pomocí Arduino IDE. Na programování PHP skriptů byl použit Atom. Pro zprovoznění stanice je potřeba udělat několik kroků:
1. Založte si hosting, databázi a webovou stránku.
2. Vyplňte Server/variables.php odpovídajícími údaji.
3. Obsah složky Server si nahrajte na vlastní hostingový server.
4. Spusťte mysql_connect.php v prohlížeči pro vytvoření tabulky v databázi.
5. Zapojte komponenty k Arduinu podle schématu výše.
6. Vyplňte údaje o serveru, wifi a časových intervalech v Arduino souboru (místo x).
7. Nahrajte sketch do Arduina a zajistěte přísun energie. Pro případ výpadku proudu je dobré do RTC modulu vložit baterii, která zajistí činnost krystalu. Zachová se tak správný čas.
8. Nastavte oba potenciometry tak, aby Vám vyhovoval jas a kontrast displeje.
9. Užívejte si statistiky z Vašich dat.

# Výroba
Celkový pohled na stanici.
![Overview](/Documentation/overview.png)

Konektory:
![Overview](/Documentation/Connector.png)

Přední strana:
![Front](/Documentation/front.png)

BME:
![BME](/Documentation/BME.png)

# Jak to funguje?
V nastaveném intervalu se spouští cyklus na měření dat. Každých x hodin je napřed testováno připojení k internetu. Když je ESP modul úspěšně připojen, tak se zkontroluje existence WS.txt souboru. Když jsou nalezena data na SD kartě, tak jsou společně s těmi aktuálně zaznamenanými z BME a RTC modulů přímo poslána na server. V případě neúspěšného pokusu o připojení se data zapíší na SD kartu (WS.txt) v modulu. Moduly BME a RTC pracují na I2C rozhraní. Komunikace mezi ESP a Arduinem probíhá na sériové lince. SD modul využívá SPI. LCD displej se obnovuje každých x nastavených minut.
Komunikace mezi klientem a databází je založena na PDO a SQL příkazech.

# Jak WS používat?
Index zobrazuje průměrné, minimální a maximální hodnoty za poslední týden s možností změny časového rozpětí. Aktuální čas, datum a poslední přidané hodnoty jsou také zobrazeny. V pravém dolním rohu je v kalendáři možnost výběru specifického data pro detailní zobrazení hodnot a grafu.
![Index](/Documentation/index.png)

Ve STATISTIKách se zobrazují data za poslední rok s možností změny rozpětí dat.
![Stats](/Documentation/stats.png)

VÝPIS HODNOT zobrazí tabulku s posledními 50 zaznamenanými hodnotami.
![List of values](/Documentation/list.png)
