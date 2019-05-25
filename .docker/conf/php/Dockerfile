FROM php:7.2-fpm

MAINTAINER Maxim Loboda <maxim.loboda@gmail.com>

# Packages & php-extensions
RUN apt-get update && apt-get install -y \
        apt-utils \
        git \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
        libicu-dev \
        libpq-dev \
        libxpm-dev \
        libvpx-dev \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install -j$(nproc) intl \
    && docker-php-ext-install -j$(nproc) zip \
    && docker-php-ext-install -j$(nproc) pgsql \
    && docker-php-ext-install -j$(nproc) mysqli \
    && docker-php-ext-install -j$(nproc) pdo_pgsql \
    && docker-php-ext-install -j$(nproc) pdo_mysql \
    && docker-php-ext-install -j$(nproc) exif \
    && docker-php-ext-configure gd \
        --with-freetype-dir=/usr/include/ \
        --with-jpeg-dir=/usr/include/ \
        --with-xpm-dir=/usr/lib/x86_64-linux-gnu/ \
        --with-vpx-dir=/usr/lib/x86_64-linux-gnu/

# Mailhog
RUN apt-get update && \
    apt-get install --no-install-recommends --assume-yes --quiet ca-certificates curl git && \
    rm -rf /var/lib/apt/lists/*
RUN curl -Lsf 'https://storage.googleapis.com/golang/go1.8.3.linux-amd64.tar.gz' | tar -C '/usr/local' -xvzf -
ENV PATH /usr/local/go/bin:$PATH
RUN go get github.com/mailhog/mhsendmail
RUN cp /root/go/bin/mhsendmail /usr/bin/mhsendmail

# Composer
RUN php -r "readfile('http://getcomposer.org/installer');" | php -- --install-dir=/usr/bin/ --filename=composer

# File rights
RUN usermod -u 1000 www-data
RUN mkdir -pv /var/www/html/bootstrap/cache \
    && chown -R www-data:www-data /var/www/html/bootstrap/cache \
    && mkdir -pv /var/www/html/storage \
    && chown -R www-data:www-data /var/www/html/storage \
    && mkdir -pv /var/www/.composer \
    && chown -R www-data:www-data /var/www/.composer