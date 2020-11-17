FROM php:7.4-apache

COPY 000-default.conf /etc/apache2/sites-available/000-default.conf
RUN a2enmod rewrite

RUN chown -R www-data:www-data /var/www
RUN chmod -R 755 /var/www/storage

RUN apt-get update && apt-get -y install cron rsyslog
COPY schedule-cron /etc/cron.d/schedule-cron
RUN chmod 0644 /etc/cron.d/schedule-cron
RUN crontab /etc/cron.d/schedule-cron

RUN pecl install redis && docker-php-ext-enable redis
RUN sed -i '/imklog/s/^/#/' /etc/rsyslog.conf

CMD rsyslogd && cron && apache2-foreground
