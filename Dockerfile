FROM php:7.2-fpm

RUN apt-get update -y && apt-get install -y openssl zip unzip git
COPY tunning.sh /var/www/html
RUN docker-php-ext-install pdo pdo_mysql && chmod +x ./tunning.sh
RUN ./tunning.sh
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
COPY . /var/www/html
RUN apt-get install -y nginx  supervisor &&  rm -rf /var/lib/apt/lists/*
RUN composer install &&chmod -R 777 storage/ && rm /etc/nginx/sites-enabled/default 
COPY nginx.conf /etc/nginx/conf.d/
RUN composer dump-autoload
RUN chmod +x ./entrypoint

ENTRYPOINT ["./entrypoint"]

EXPOSE 80
