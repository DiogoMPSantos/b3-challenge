FROM php:fpm-alpine
RUN docker-php-ext-install opcache

# Installing PHP extensions
RUN docker-php-ext-install pdo_mysql    ;

COPY php/opcache.ini /usr/local/etc/php/conf.d/opcache.ini
COPY ./b3-challenge/ /var/www/html/

# These line for /setup.sh
COPY php/setup.sh /bin/scripts/setup.sh
RUN chmod +x /bin/scripts/setup.sh

RUN echo "* * * * * cd /var/www/html/ && php artisan schedule:run" >> /var/spool/cron/crontabs/root