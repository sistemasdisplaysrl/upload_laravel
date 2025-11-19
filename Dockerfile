# PHP-FPM 8.3 con extensiones necesarias para Laravel
FROM php:8.3-fpm-alpine

# Dependencias del sistema y extensiones
RUN apk add --no-cache \
    bash \
    git \
    unzip \
    libzip-dev \
    oniguruma-dev \
    icu-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    libwebp-dev \
    freetype-dev \
    $PHPIZE_DEPS \
 && docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
 && docker-php-ext-install -j"$(nproc)" \
    pdo_mysql \
    zip \
    intl \
    gd \
    bcmath \
 && apk del --no-cache $PHPIZE_DEPS

# Copiar Composer desde imagen oficial
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Configuración PHP
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini" \
 && echo "memory_limit=512M" > /usr/local/etc/php/conf.d/zz-custom.ini \
 && echo "upload_max_filesize=64M" >> /usr/local/etc/php/conf.d/zz-custom.ini \
 && echo "post_max_size=64M" >> /usr/local/etc/php/conf.d/zz-custom.ini \
 && echo "opcache.enable=1" >> /usr/local/etc/php/conf.d/zz-custom.ini \
 && echo "opcache.validate_timestamps=1" >> /usr/local/etc/php/conf.d/zz-custom.ini \
 && echo "opcache.revalidate_freq=0" >> /usr/local/etc/php/conf.d/zz-custom.ini

WORKDIR /var/www/html

CMD ["php-fpm"]
