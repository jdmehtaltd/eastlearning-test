FROM php:7.4-cli
RUN apt-get update && apt-get install -y wget lynx
COPY . /usr/src/myapp
WORKDIR /usr/src/myapp
CMD [ "php", "-S", "0.0.0.0:8000" ]



