# build vendor
FROM composer as vendor

<<<<<<< HEAD
## define enviroment variables for datadog-agent
#ENV DD_AGENT_HOST=datadog-agent \
#    DD_TRACE_AGENT_PORT=8126 \
#    DD_TRACE_ANALYTICS_ENABLED=true

WORKDIR /app
COPY composer.json .
COPY database database
COPY app/Helpers app/Helpers
COPY tests tests

RUN composer install \
    --ignore-platform-reqs \
    --no-interaction \
    --no-plugins \
    --no-scripts \
    --prefer-dist
=======
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
>>>>>>> create tunning file

# production stage
FROM hikmahgumelar/iqoswebsrv:latest

COPY --from=vendor --chown=xfs:xfs /app/vendor /app/vendor
COPY --chown=xfs:xfs . .

RUN chmod -R 777 /app/storage
RUN composer dump-autoload
CMD ["/run.sh"]
