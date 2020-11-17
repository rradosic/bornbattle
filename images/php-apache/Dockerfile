FROM php:7.4-apache

COPY images/php-apache/000-default.conf /etc/apache2/sites-available/000-default.conf
RUN a2enmod rewrite

COPY BattleSimulationAPI /var/www
RUN chown -R www-data:www-data /var/www
RUN chmod -R 775 /var/www/storage

CMD apache2-foreground
