FROM php:7-cli
LABEL maintainer="edmurcardoso@gmail.com"

RUN apt-get update
RUN apt-get install --no-install-recommends --assume-yes --fix-missing unzip libicu-dev cron git wget
RUN docker-php-ext-install intl

COPY . /usr/src

WORKDIR /usr/src
RUN wget https://getcomposer.org/composer.phar
RUN make install
RUN (crontab -l ; echo "*/5 * * * * /usr/local/bin/php /usr/src/app/bootstrap.php >> /proc/1/fd/1 2>/proc/1/fd/2") | crontab
RUN service cron restart
RUN service cron reload

ENTRYPOINT make environment && cron -f -L 7 >> /proc/1/fd/1 2>/proc/1/fd/2
