FROM php:8.4-fpm

RUN apt-get update && apt-get install -y     nginx     libcurl4-openssl-dev     && docker-php-ext-install curl mysqli pdo pdo_mysql

COPY default.conf /etc/nginx/sites-available/default

RUN mkdir -p /var/www/app &&     mkdir -p /var/www/public &&     mkdir -p /var/www/data &&     mkdir -p /var/www/tmp &&     chmod 777 /var/www/tmp &&     chown -R www-data:www-data /var/www/public

EXPOSE 80

CMD ["sh", "-c", "service nginx start && php-fpm"]
