#!/bin/bash

cat <<EOF > default.conf
server {
    listen 80;
    server_name localhost;

    root /var/www/public;
    index index.php index.html index.htm;

    location / {
        try_files \$uri \$uri/ /index.php?\$query_string;
    }

    location ~ \.php\$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass 127.0.0.1:9000; # Port PHP-FPM
        fastcgi_param SCRIPT_FILENAME \$document_root\$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.ht {
        deny all;
    }
}
EOF

cat <<EOF > Dockerfile
FROM php:8.4-fpm

RUN apt-get update && apt-get install -y \
    nginx \
    libcurl4-openssl-dev \
    && docker-php-ext-install curl mysqli pdo pdo_mysql

COPY default.conf /etc/nginx/sites-available/default

RUN mkdir -p /var/www/app && \
    mkdir -p /var/www/public && \
    mkdir -p /var/www/data && \
    mkdir -p /var/www/tmp && \
    chmod 777 /var/www/tmp && \
    chown -R www-data:www-data /var/www/public

EXPOSE 80

CMD ["sh", "-c", "service nginx start && php-fpm"]
EOF

# Build Docker
docker build -t r-wfw .

# Run Docker
docker run -d -p 8090:80 \
    -v "$(pwd)/public:/var/www/public" \
    -v "$(pwd)/app:/var/www/app" \
    -v "$(pwd)/tmp:/var/www/tmp" \
    -v "$(pwd)/data:/var/www/data" \
    r-wfw

