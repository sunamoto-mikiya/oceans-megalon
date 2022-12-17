FROM php:8.1.9-apache

SHELL ["/bin/bash", "-o", "pipefail", "-c"]

# node
# RUN curl -SL https://deb.nodesource.com/setup_12.x | bash \
#     && apt-get update \
#     && apt-get install -y --no-install-recommends nodejs \
#     && npm install -g npm@latest \
#     && npm install -g yarn

# # node
# RUN apt-get update
# RUN apt-get install -y nodejs npm
# RUN npm install n -g && n 16.17.0

# install modules
RUN apt-get update \
    # apt-get install
    && apt-get install -y --no-install-recommends \
    unzip git \
    libzip-dev libicu-dev libpq-dev \
    libfreetype6-dev libjpeg62-turbo-dev libpng-dev \
    socat \
    nodejs npm \
    # others
    && a2enmod rewrite \
    # clear cache
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# configure modules
RUN docker-php-ext-configure gd --with-freetype --with-jpeg

# docker-php-ext-install
RUN docker-php-ext-install \
    gd intl zip \
    intl opcache pdo pdo_mysql

# npm install
RUN npm install n -g && n 16.17.0

# composer
ENV COMPOSER_ALLOW_SUPERUSER 1
ENV COMPOSER_HOME /composer
ENV PATH $PATH:/composer/vendor/bin

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# set timezone
ENV TZ Asia/Tokyo
RUN echo "${TZ}" > /etc/timezone \
   && dpkg-reconfigure -f noninteractive tzdata

# change document root
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

WORKDIR /var/www/html

# copy php ini
COPY ./docker/deploy/production/php.ini /usr/local/etc/php/php.ini

# copy Laravel Project
COPY ./ /var/www/html

# Laravel Configuration
RUN chown www-data:www-data -R .
RUN composer install --optimize-autoloader --no-dev
RUN cp .env.production .env \
    && php artisan key:generate

# npn run build
RUN npm install \
    && npm run build
