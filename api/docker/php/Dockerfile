FROM php:8.1-fpm-buster
ARG TIMEZONE

WORKDIR /var/www/html

#УСТАНАВЛИВАЕМ COMPOSER
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/bin --filename=composer --quiet

RUN apt-get update && apt-get install -y \
    gnupg \
    g++ \
    procps \
    openssl \
    git \
    unzip \
    zlib1g-dev \
    libzip-dev \
    libfreetype6-dev \
    libpng-dev \
    libjpeg-dev \
    libicu-dev  \
    libonig-dev \
    libxslt1-dev \
    acl

RUN docker-php-ext-install xml

RUN docker-php-ext-configure gd --with-jpeg --with-freetype

RUN docker-php-ext-install \
    pdo pdo_mysql zip xsl gd intl opcache exif mbstring

RUN ln -snf /usr/share/zoneinfo/${TIMEZONE} /etc/localtime && echo ${TIMEZONE} > /etc/timezone \
    && printf '[PHP]\ndate.timezone = "%s"\n', ${TIMEZONE} > /usr/local/etc/php/conf.d/tzone.ini \
    && "date"

#УСТАНАВЛИВАЕМ XDEBUG
RUN  pecl install xdebug 3.2.0 \
    && docker-php-ext-enable xdebug

#RUN echo 'zend_extension=xdebug' >> /usr/local/etc/php/php.ini
#RUN echo 'xdebug.mode=develop,debug' >> /usr/local/etc/php/php.ini
#RUN echo 'xdebug.client_host=172.17.0.1' >> /usr/local/etc/php/php.ini
#RUN echo 'xdebug.client_port=9005' >> /usr/local/etc/php/php.ini
#RUN echo 'xdebug.idekey=PHPSTORM' >> /usr/local/etc/php/php.ini
#RUN echo 'xdebug.start_with_request=yes' >> /usr/local/etc/php/php.ini
#RUN echo 'session.save_path = "/tmp"' >> /usr/local/etc/php/php.ini

#УСТАНАВЛИВАЕМ PHP-SPX profiler
#http://localhost/?SPX_KEY=dev&SPX_UI_URI=/
RUN cd /usr/lib && git clone https://github.com/NoiseByNorthwest/php-spx.git
RUN cd /usr/lib/php-spx && phpize && ./configure && make && make install