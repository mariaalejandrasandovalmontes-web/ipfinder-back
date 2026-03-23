FROM php:8.2-cli

RUN docker-php-ext-install pdo pdo_mysql

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY . .

RUN composer install --no-dev --optimize-autoloader

# Railway asigna el puerto en la variable $PORT
CMD php -S 0.0.0.0:$PORT -t public
