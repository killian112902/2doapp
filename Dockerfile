# Multi-stage build for Laravel with PHP-FPM + Nginx

ARG PHP_VERSION=8.2

# 1) Composer dependencies
FROM composer:2 AS vendor
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --prefer-dist --no-interaction --no-progress --optimize-autoloader
COPY . .
RUN composer install --no-dev --prefer-dist --no-interaction --no-progress --optimize-autoloader

# 2) Frontend build
FROM node:20-alpine AS assets
WORKDIR /app
COPY package.json package-lock.json ./
RUN npm ci --no-audit --no-fund
COPY . .
RUN npm run build

# 3) Runtime image
FROM php:${PHP_VERSION}-fpm-alpine AS runtime

RUN apk add --no-cache \
	nginx \
	supervisor \
	icu-dev \
	oniguruma-dev \
	libzip-dev \
	zlib-dev \
	libpng-dev \
	libjpeg-turbo-dev \
	freetype-dev \
	git \
	bash && \
	docker-php-ext-configure gd --with-freetype --with-jpeg && \
	docker-php-ext-install pdo pdo_mysql opcache bcmath zip gd intl

WORKDIR /var/www/html

# Copy application code and built assets
COPY --from=vendor /app /var/www/html
COPY --from=assets /app/public/build /var/www/html/public/build

# Nginx + supervisord configs
COPY docker/nginx.conf /etc/nginx/http.d/default.conf
COPY docker/supervisord.conf /etc/supervisord.conf

RUN chown -R www-data:www-data storage bootstrap/cache && \
	mkdir -p /run/nginx

ENV APP_ENV=production \
	APP_DEBUG=false \
	LOG_CHANNEL=stderr \
	PHP_ERRORS_STDERR=1

EXPOSE 8080

CMD ["supervisord", "-c", "/etc/supervisord.conf"]
