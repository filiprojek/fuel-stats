FROM php:8.2-fpm-alpine

WORKDIR /var/www/html

RUN apk add --no-cache nginx curl \
  && docker-php-ext-install mysqli

COPY . /var/www/html

RUN chown -R www-data:www-data /var/www/html \
  && chmod -R 755 /var/www/html

COPY .docker/nginx.conf /etc/nginx/nginx.conf

EXPOSE 80

CMD php-fpm & nginx -g "daemon off;"

