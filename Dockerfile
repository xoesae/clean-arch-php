FROM php:8.3-fpm

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install zip pdo pdo_mysql gd

RUN groupadd -g 1000 appuser && \
    useradd -u 1000 -ms /bin/bash -g appuser appuser

WORKDIR /var/www

COPY composer.json ./
RUN chown -R appuser:appuser /var/www

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN composer install --no-scripts --no-autoloader

COPY . .

RUN composer dump-autoload --optimize

EXPOSE 9000

USER appuser

CMD ["php-fpm"]