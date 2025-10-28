# Базовый PHP с Apache
FROM php:8.2-apache

# Устанавливаем зависимости для PostgreSQL
RUN apt-get update && apt-get install -y \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql pgsql \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Копируем все файлы в веб-корень Apache
COPY . /var/www/html/

# Открываем порт 80
EXPOSE 80
