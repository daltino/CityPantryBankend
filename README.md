# CityPantryBankend
City Pantry backend to search its database of vendors for menu items available given day, time, location and a headcount.

### Setup
1. Clone this repo to your local machine
```
git clone https://github.com/daltino/CityPantryBankend.git
```

### To run a search on the CityPantry vendors list
```
cd CityPantryBackend
php -q index.php "src/Data/vendors-data" <deliver-day> <deliver-time> <location> <covers>
```
Example command:
```
php -q app/index.php "vendors-data" "05/10/18" "15:00" "E32NY" 50
```

### To Run Tests using PHPUnit
```
cd CityPantryBackend
phpunit --colors src/Test/Unit/MenuItemTest.php
```
