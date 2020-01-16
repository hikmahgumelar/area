# build vendor
FROM composer as vendor

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

# production stage
FROM hikmahgumelar/iqoswebsrv:latest

COPY --from=vendor --chown=xfs:xfs /app/vendor /app/vendor
COPY --chown=xfs:xfs . .

RUN chmod -R 777 /app/storage
RUN composer dump-autoload
CMD ["/run.sh"]
