FROM php:8.2-cli

# Instalar dependencias del sistema y extensiones de PHP
RUN apt-get update && apt-get install -y \
    libssl-dev \
    libonig-dev \
    libxml2-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring tokenizer xml \

# Instalar Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY . .

# Instalar dependencias de PHP
RUN composer install --no-dev --optimize-autoloader

# Railway asigna el puerto en la variable $PORT
CMD php -S 0.0.0.0:$PORT -t public
