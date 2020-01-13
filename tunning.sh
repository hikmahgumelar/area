#!/bin/sh

sed -i  's/memory_limit = 128M/memory_limit = 1024M/g' /usr/local/etc/php/php.ini-development
sed -i  's/memory_limit = 128M/memory_limit = 1024M/g' /usr/local/etc/php/php.ini-production
