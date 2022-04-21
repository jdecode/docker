FROM php:8.1.0-apache

# Update
RUN apt-get update

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

#Install zip+icu dev libs, wget, git
RUN apt-get install libzip-dev zip libicu-dev libpng-dev wget git -y

#Install PHP extensions zip and intl (intl requires to be configured)
RUN docker-php-ext-install zip && docker-php-ext-configure intl && docker-php-ext-install intl exif gd

#PostgreSQL
RUN apt-get update

RUN apt-get install libpq-dev -y

RUN docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql && docker-php-ext-install pdo_pgsql pgsql

RUN apt-get install libcurl4-openssl-dev -y

RUN docker-php-ext-install curl

RUN sed -i 's/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

RUN a2enmod rewrite

WORKDIR /var/www/html

RUN usermod -u 1000 www-data && groupmod -g 1000 www-data

# xdebug 3.x (NOT 2.x)
RUN pecl install xdebug
RUN docker-php-ext-enable xdebug
RUN echo "xdebug.mode = debug,coverage" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.start_with_request = yes" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.discover_client_host = on" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.client_host = host.docker.internal" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini 

## Install Node.js 16.x(if needed) & newman
RUN curl -fsSL https://deb.nodesource.com/setup_16.x | bash -
RUN apt-get update
RUN apt-get install -y nodejs
RUN npm install -g npm@latest
RUN npm install -g newman
RUN newman --version

# Set Apache webroot to "public" folder (for Laravel)
RUN sed -ri -e 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!/var/www/html/public!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf


