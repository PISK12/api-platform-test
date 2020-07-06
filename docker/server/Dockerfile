FROM php:7.4-apache

ENV APACHE_DOCUMENT_ROOT /app/public

RUN apt-get update -y \
    && apt-get upgrade -y

# add git
RUN apt-get install -y git

# add PostgreSQL
RUN apt-get install -y libpq-dev \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo pdo_pgsql pgsql

# add PHP intl extension
RUN apt-get install -y zlib1g-dev libicu-dev g++ \
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl

# add zip
RUN apt-get install -y libzip-dev zip \
    && docker-php-ext-configure zip \
    && docker-php-ext-install zip

# add composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# add OPCache
RUN docker-php-ext-install opcache

# clean
RUN apt-get clean -y && apt-get autoclean -y && apt-get autoremove -y \
    && rm -rf /var/lib/apt/lists/*

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf
RUN a2enmod rewrite

# add php config
ENV PHP_OPCACHE_VALIDATE_TIMESTAMPS="1"
COPY conf.d/opcache.ini /usr/local/etc/php/conf.d/opcache.ini
COPY conf.d/realpath.ini /usr/local/etc/php/conf.d/realpath.ini

RUN mkdir -m777 /app
WORKDIR /app
