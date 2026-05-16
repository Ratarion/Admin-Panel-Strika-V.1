FROM php:8.2-apache

RUN find /etc/apt/ -type f -name "*.list*" -exec sed -i 's|http://deb.debian.org|https://deb.debian.org|g' {} \; && \
    find /etc/apt/ -type f -name "*.list*" -exec sed -i 's|http://security.debian.org|https://security.debian.org|g' {} \; && \
    apt-get update && apt-get install -y \
        libpng-dev \
        libonig-dev \
        libxml2-dev \
        libpq-dev \
        libzip-dev \
        zip \
        unzip \
        git \
        curl \
    && rm -rf /var/lib/apt/lists/*

# Устанавливаем расширения PHP (добавили pdo_pgsql и pgsql)
RUN docker-php-ext-install pdo_mysql pdo_pgsql pgsql mbstring exif pcntl bcmath gd zip

# Включаем mod_rewrite
RUN a2enmod rewrite

# Настройка DocumentRoot
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

WORKDIR /var/www/html

# Копируем Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Копируем проект
COPY . .
RUN composer install --no-dev --optimize-autoloader
RUN chown -R www-data:www-data /var/www/html
