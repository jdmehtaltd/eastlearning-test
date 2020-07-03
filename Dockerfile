FROM php:7.4-cli
RUN apt-get update && apt-get install -y wget lynx zip
COPY . /app
WORKDIR /app
RUN php composer.phar install
CMD [ "php", "-S", "0.0.0.0:8000" ]




