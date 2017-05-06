# WS
WS je studentským projektem ověřujícím možnost realizace konceptu vnitřní meteostanice fungující na bázi Arduina, který umožňuje posílat naměřené hodnoty do webové databáze.

<a href="https://www.github.com/fslapal/WS">GitHub repozitář</a>

# Komponenty, schéma zapojení
![Schéma zapojení](/Documentation/WS_diagram.png)

Kompletní Fritzing schéma je k dispozici ve složce Documentation.

## Komponenty
* Arduino Mega 2560 R3 - mikroprocesor
* ESP8266 - wifi modul
* BME280 - senzor teploty, vlhkosti a tlaku
* RTC1307 - modul reálného času (+ CR2025 baterie)
* Catalex MicroSD modul (+ MicroSD karta)
* 20x4 LCD displej

## Knihovny
Tyto knihovny spolu s jejich vzorovými skripty byly použity k dokončení projektu. Všechny jsou nahrány ve složce Arduino/Libraries.
* cactus_io_BME280_I2C (BME, RTC)
* DS1307RTC (RTC)
* LiquidCrystal (LCD)
* SD (SD module)
* SPI (BME, SD module)
* TimeLib (RTC)
* Wire (I2C -> BME, RTC)

# Instalace
Kód byl napsán a uploadován pomocí Arduino IDE. Na programování PHP skriptů byl použit Atom. Pro zprovoznění stanice je potřeba udělat několik kroků:
1. Založte si hosting, databázi a webovou stránku.
2. Vyplňte Server/variables.php odpovídajícími údaji.
3. Obsah složky Server si nahrajte na vlastní hostingový server.
4. Spusťte mysql_connect.php v prohlížeči pro vytvoření tabulky v databázi.
5. Zapojte komponenty k Arduinu podle schématu výše.
6. Vyplňte údaje o serveru, wifi a časových intervalech v Arduino souboru (místo x).
7. Nahrajte sketch do Arduina a zajistěte přísun energie. Pro případ výpadku proudu je dobré do RTC modulu vložit baterii, která zajistí činnost krystalu. Zachová se tak správný čas.
8. Nastavte oba potenciometry tak, aby Vám vyhovoval jas a kontrast displeje.
9. Užívejte si statistiky a grafy z Vašich dat.

# Výroba
Po zapojení veškerých komponentů k Arduinu si vyberte vhodnou krabičku jako obal meteostanice. K praktickému použití je třeba udělat otvory pro LCD displej, konektory, BME modul (meření nezkresleno projevem komponent) a potenciometry.

## Možný výsledek
![Celkový pohled](/Documentation/overview.png)

![Konektory](/Documentation/Connector.png)

![Přední strana](/Documentation/front.png)

![BME](/Documentation/BME.png)

# Jak to funguje?
V nastaveném intervalu se spouští cyklus na měření dat. Každých x hodin je napřed testováno připojení k internetu. Když je ESP modul úspěšně připojen, tak se zkontroluje existence WS.txt souboru. Když jsou nalezena data na SD kartě, tak jsou společně s těmi aktuálně zaznamenanými z BME a RTC modulů přímo poslána na server. V případě neúspěšného pokusu o připojení se data zapíší na SD kartu (WS.txt) v modulu. Moduly BME a RTC pracují na I2C rozhraní. Komunikace mezi ESP a Arduinem probíhá na sériové lince. SD modul využívá SPI. LCD displej se obnovuje každých x nastavených minut.
Komunikace mezi klientem a databází je založena na PDO a SQL příkazech.

# Jak WS používat?
Arduino kód je nutné nahrát jenom jednou. Potom stačí již jenom připojení zdroje pokaždé, když chceme, aby meteostanice začala posílat data. Po vložení baterie do RTC modulu bude správný čas zachován i při odpojení napájení. Index zobrazuje průměrné, minimální a maximální hodnoty za poslední týden s možností změny časového rozpětí. Aktuální čas, datum a poslední přidané hodnoty jsou také zobrazeny. V pravém dolním rohu je v kalendáři možnost výběru specifického data pro detailní zobrazení hodnot a grafu.

![Index](/Documentation/index.png)

Ve STATISTIKách se zobrazují extrémní, průměrná data a graf za poslední rok s možností změny rozpětí datumů.

![Statistiky](/Documentation/stats.png)

VÝPIS HODNOT zobrazí tabulku s posledními 20 zaznamenanými hodnotami.

![Výpis hodnot](/Documentation/list.png)

# Možná rozšíření
Jednou z možností, která je nejvíce nasnadě, je zařazení BT modulu (HC-05 nebo HC-06). Ten by přes sériovou linku přijímal data z Arduina (potažmo senzorů) a posílal je přes bluetooth například do mobilní aplikace. Post dotaz by se tak nahradil běžným řetězcem.
