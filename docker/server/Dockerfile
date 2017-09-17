FROM php:7.1-apache

# Install PHP extensions
RUN curl -sL https://deb.nodesource.com/setup_6.x | bash - \
    && apt-get update && apt-get install -y \
      libicu-dev \
      libpq-dev \
      libmcrypt-dev \
      mysql-client \
      libmysqlclient-dev \
      ruby-full \
      nodejs \
      git \
    && rm -r /var/lib/apt/lists/* \
    && docker-php-ext-configure pdo_mysql --with-pdo-mysql=mysqlnd \
    && docker-php-ext-install \
      intl \
      mbstring \
      mcrypt \
      mysqli \
      pcntl \
      pdo_mysql \
      pdo_pgsql \
      pgsql \
      zip \
      opcache \
      bcmath

# Install mongo
RUN pecl install mongodb && docker-php-ext-enable mongodb

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer
RUN mkdir /var/www/.composer/ && chmod 775 /var/www/.composer/ && chown www-data:www-data /var/www/.composer/

# Install Xdebug
RUN curl -fsSL 'https://xdebug.org/files/xdebug-2.5.1.tgz' -o xdebug.tar.gz \
    && mkdir -p xdebug \
    && tar -xf xdebug.tar.gz -C xdebug --strip-components=1 \
    && rm xdebug.tar.gz \
    && ( \
    cd xdebug \
    && phpize \
    && ./configure --enable-xdebug \
    && make -j$(nproc) \
    && make install \
    ) \
    && rm -r xdebug \
    && docker-php-ext-enable xdebug

COPY server.pem /etc/apache2/conf/
COPY server.key /etc/apache2/conf/

# Put apache config
COPY apache-vhost.conf /etc/apache2/sites-available/custom-vhost.conf
COPY default-ssl.conf /etc/apache2/sites-available/default-ssl.conf

RUN a2enmod ssl && a2ensite default-ssl.conf
RUN a2dissite 000-default.conf && a2ensite custom-vhost.conf && a2enmod rewrite

RUN echo "date.timezone=Europe/Warsaw" >> /usr/local/etc/php/php.ini
RUN echo "xdebug.remote_enable=1" >> /usr/local/etc/php/php.ini
RUN echo "upload_max_filesize=250M" >> /usr/local/etc/php/php.ini
RUN echo "post_max_size=250M" >> /usr/local/etc/php/php.ini
RUN echo "memory_limit=350M" >> /usr/local/etc/php/php.ini

RUN usermod -a -G www-data proxy
# Change uid and gid of apache to docker user uid/gid
RUN usermod -u 1000 www-data && groupmod -g 1000 www-data

WORKDIR /var/www
