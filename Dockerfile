FROM php:7.4-cli
ENV COMPOSER_VENDOR_DIR /vendor
RUN apt-get update && apt-get install -y wget lynx zip vim
COPY . /app
WORKDIR /app
RUN wget https://raw.githubusercontent.com/composer/getcomposer.org/76a7060ccb93902cd7576b67264ad91c8a2700e2/web/installer -O - -q | php -- --quiet
RUN php composer.phar install
# TODO: at some point figure out how to get composer.lock into git
CMD [ "php", "-S", "0.0.0.0:8000" ]


