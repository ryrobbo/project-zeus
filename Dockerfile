FROM php:7.4-cli

RUN buildDeps="libpq-dev libzip-dev libicu-dev git curl" && \
    apt-get update && \
    apt-get install -y $buildDeps --no-install-recommends

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN docker-php-ext-install zip

RUN pecl install ds \
    && touch /usr/local/etc/php/conf.d/20-ds.ini \
    && echo "extension=ds.so" >> /usr/local/etc/php/conf.d/20-ds.ini

WORKDIR /var/www/zeus

COPY . .
