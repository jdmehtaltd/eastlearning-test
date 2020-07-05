FROM php:7.4-cli
ENV COMPOSER_VENDOR_DIR /vendor
RUN apt-get update && apt-get install -y wget lynx zip vim
RUN apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd
RUN pecl install xdebug-2.9.6 && docker-php-ext-enable xdebug
COPY . /app
WORKDIR /app
RUN wget https://raw.githubusercontent.com/composer/getcomposer.org/76a7060ccb93902cd7576b67264ad91c8a2700e2/web/installer -O - -q | php -- --quiet
RUN php composer.phar install
# TODO: at some point figure out how to get composer.lock into git
CMD [ "php", "-S", "0.0.0.0:8000" ]


