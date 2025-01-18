# Gunakan base image PHP 8.3 dengan Apache
FROM php:8.3-apache

# Install dependencies yang diperlukan untuk Laravel dan PostgreSQL
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libpq-dev \
    && docker-php-ext-install pdo_mysql zip gd pdo_pgsql \
    && docker-php-ext-configure gd --with-freetype --with-jpeg

# Install Composer
COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Salin hanya composer.json dan composer.lock terlebih dahulu untuk memanfaatkan cache Docker
COPY composer.json composer.lock ./

# Install dependensi Laravel
RUN composer install --no-scripts --no-interaction --prefer-dist --optimize-autoloader

# Salin seluruh project Laravel ke dalam container
COPY . .

# Berikan izin untuk folder storage dan bootstrap/cache
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage \
    && chmod -R 775 /var/www/html/bootstrap/cache

# Salin konfigurasi Apache custom
COPY docker/apache/000-default.conf /etc/apache2/sites-available/000-default.conf

# Aktifkan mod_rewrite Apache untuk mendukung Laravel routing
RUN a2enmod rewrite

# Adjust Apache configuration
RUN sed -i 's/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf

# Konfigurasi php.ini untuk memory limit 
RUN echo 'memory_limit = 512M' >> /usr/local/etc/php/conf.d/docker-php-memlimit.ini \
    && echo 'upload_max_filesize = 100M' >> /usr/local/etc/php/conf.d/docker-php-upload.ini \
    && echo 'post_max_size = 100M' >> /usr/local/etc/php/conf.d/docker-php-upload.ini

# Jalankan perintah Laravel Artisan untuk cache konfigurasi
RUN php artisan config:cache \
    && php artisan route:cache

# Expose port 9090
EXPOSE 9090

# Jalankan Apache
CMD ["apache2-foreground"]