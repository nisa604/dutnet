FROM php:8.1-fpm-alpine

RUN apk add --no-cache nginx wget

# Install necessary alpine packages
RUN apk update && apk add --no-cache \
    zip \
    unzip \
    dos2unix \
    supervisor \
    libpng-dev \
    libzip-dev \
    freetype-dev \
    $PHPIZE_DEPS \
    libjpeg-turbo-dev \
    mysql-client

# Compile native PHP packages
RUN docker-php-ext-install \
    gd \
    pcntl \
    bcmath \
    mysqli \
    pdo_mysql

# Configure packages
RUN docker-php-ext-configure gd --with-freetype --with-jpeg

# Install additional packages from PECL
RUN pecl install zip && docker-php-ext-enable zip

RUN mkdir -p /run/nginx

COPY docker/nginx.conf /etc/nginx/nginx.conf

RUN mkdir -p /app
COPY . /app
COPY .env.example /app/.env

RUN wget http://getcomposer.org/composer.phar && chmod a+x composer.phar && mv composer.phar /usr/local/bin/composer
RUN cd /app && /usr/local/bin/composer install --no-dev

RUN chown -R www-data:www-data /app

CMD ["sh", "/app/docker/startup.sh"]
