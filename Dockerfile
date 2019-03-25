FROM php:7-cli-alpine
LABEL maintainer="edmurcardoso@gmail.com"

RUN apk update
RUN apk add --update --no-cache make icu-dev unzip git wget
RUN docker-php-ext-install intl

COPY . /usr/src

RUN mkdir /var/log/cron
RUN touch /var/log/cron/cron.log
COPY app.cron /crontab
RUN /usr/bin/crontab -u root /crontab

WORKDIR /usr/src
RUN wget https://getcomposer.org/composer.phar
RUN make install

ENTRYPOINT make env && crond -f -l 8 & tail -f /var/log/cron/cron.log
