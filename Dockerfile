# ==========================================
# Etapa 1: Aplicación Laravel con PHP-FPM
# ==========================================
FROM php:8.2-fpm-alpine

# Instalar dependencias del sistema
RUN apk add --no-cache \
    nginx \
    supervisor \
    curl \
    libpng-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    bash \
    shadow

# Instalar dependencias para extensiones PHP
RUN apk add --no-cache \
    libzip-dev \
    freetype-dev \
    libjpeg-turbo-dev \
    libpng-dev \
    icu-dev \
    $PHPIZE_DEPS

# Extensiones PHP nativas (sin depender de descargas externas)
RUN docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install -j$(nproc) \
        pdo_mysql \
        bcmath \
        opcache \
        zip \
        gd \
        exif \
        intl && \
    pecl install redis && \
    docker-php-ext-enable redis && \
    apk del $PHPIZE_DEPS && \
    rm -rf /tmp/pear

# Instalar Composer
COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copiar código fuente
COPY . /var/www/html

# Asegurar que los assets compilados y las imágenes se mantengan
# (Se asume que ya se compilaron en el host antes de construir la imagen)

# Instalar dependencias PHP (sin devtools, optimizado)
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN composer install --no-dev --optimize-autoloader --no-interaction --quiet

# Storage link en build time (se regenera en start)
RUN mkdir -p /var/www/html/storage/app/public \
             /var/www/html/storage/framework/sessions \
             /var/www/html/storage/framework/views \
             /var/www/html/storage/framework/cache \
             /var/www/html/storage/logs \
             /var/www/html/bootstrap/cache

# OPcache optimizado para producción
RUN { \
    echo 'opcache.memory_consumption=128'; \
    echo 'opcache.interned_strings_buffer=16'; \
    echo 'opcache.max_accelerated_files=10000'; \
    echo 'opcache.revalidate_freq=0'; \
    echo 'opcache.fast_shutdown=1'; \
    echo 'opcache.enable_cli=1'; \
    echo 'opcache.validate_timestamps=0'; \
} > /usr/local/etc/php/conf.d/opcache.ini

# PHP-FPM: pool config
RUN { \
    echo '[www]'; \
    echo 'user = www-data'; \
    echo 'group = www-data'; \
    echo 'listen = 127.0.0.1:9000'; \
    echo 'pm = dynamic'; \
    echo 'pm.max_children = 50'; \
    echo 'pm.start_servers = 5'; \
    echo 'pm.min_spare_servers = 5'; \
    echo 'pm.max_spare_servers = 10'; \
} > /usr/local/etc/php-fpm.d/www.conf

# Copiar configs
COPY docker/nginx.app.conf /etc/nginx/nginx.conf
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY docker/start.sh /usr/local/bin/start.sh
RUN chmod +x /usr/local/bin/start.sh

# Permisos finales y arreglos para subida de archivos (Nginx usa www-data)
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache /var/lib/nginx && \
    chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache && \
    echo 'upload_max_filesize = 20M' >> /usr/local/etc/php/conf.d/uploads.ini && \
    echo 'post_max_size = 20M' >> /usr/local/etc/php/conf.d/uploads.ini

EXPOSE 80

CMD ["/usr/local/bin/start.sh"]
