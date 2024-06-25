#!/bin/sh

# Replace placeholder with actual port provided by Cloud Run
sed -i "s/LISTEN_PORT/${PORT}/g" /etc/nginx/nginx.conf

# Start PHP-FPM in the background
php-fpm -D

# Wait for PHP-FPM to be ready
while ! nc -z 127.0.0.1 9000; do sleep 0.1; done

# Start Nginx
nginx -g 'daemon off;'
