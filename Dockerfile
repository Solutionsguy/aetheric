FROM php:8.4-fpm

# [Standard dependencies block remains here]
RUN apt-get update && apt-get install -y \
    git curl libpq-dev libpng-dev libonig-dev libxml2-dev libzip-dev zip unzip nginx mariadb-client \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip xml

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# --- THE CRITICAL STEPS ---

# 1. Copy the modules folder FIRST (This is the most important part)
COPY modules/ /var/www/modules/

# 2. Copy composer.json ONLY
COPY composer.json ./

# 3. Install dependencies 
# This builds a fresh, Linux-compatible 'address book' (autoload)
RUN composer install --no-interaction --no-scripts --prefer-dist --ignore-platform-reqs --no-autoloader

# 4. Copy the rest of the application
COPY . .

# 5. Generate Autoload now that everything is copied
RUN composer dump-autoload --optimize

# 6. Prepare Entrypoint
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

# 7. Permissions
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache \
    && chmod -R 775 /var/www/storage /var/www/bootstrap/cache

ENTRYPOINT ["entrypoint.sh"]
EXPOSE 9000
CMD ["php-fpm"]