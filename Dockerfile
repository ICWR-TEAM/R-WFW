FROM php:8.1-fpm

RUN apt-get update && apt-get install -y \
    nginx \
    libcurl4-openssl-dev && \
    docker-php-ext-install curl mysqli pdo pdo_mysql

COPY default.conf /etc/nginx/sites-available/default

RUN mkdir -p /var/www/app && \
    mkdir -p /var/www/public && \
    chown -R www-data:www-data /var/www/public

EXPOSE 80

CMD ["sh", "-c", "service nginx start && php-fpm"]

# Docker Build
# docker build -t r-wfw .

# Run Docker
# docker run -d -p 8090:80 -v "$(pwd)/public:/var/www/public" -v "$(pwd)/app:/var/www/app" r-wfw
