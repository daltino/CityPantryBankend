FROM php:7.0-apache

# create dir for CityPantry Backend web files
RUN mkdir /var/www/html/CityPantryBackend
WORKDIR /var/www/html/CityPantryBackend

# Copy PHP files to /var/www/html inside the container
COPY . .

# Run index.php to test container
# ENTRYPOINT ["php", "-q", "app/index.php", "vendors-data", "05/10/18", "15:00", "E32NY", "50"]