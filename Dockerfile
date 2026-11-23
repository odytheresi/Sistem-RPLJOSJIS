FROM php:8.4-cli

# Paket sistem + ekstensi PHP yang dibutuhkan Laravel dan MySQL
RUN apt-get update && apt-get install -y --no-install-recommends \
        git unzip zip libzip-dev libonig-dev \
    && docker-php-ext-install pdo_mysql mbstring zip bcmath \
    && rm -rf /var/lib/apt/lists/*

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

EXPOSE 8000
