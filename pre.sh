#!/bin/sh

# copy .env from S3 Bucket
echo $ENV_PATH
aws s3 cp $ENV_PATH /app/.env

php artisan migrate:refresh --seed --force

sed -i 's/server_name/server_name _/' /etc/nginx/conf.d/app.conf
