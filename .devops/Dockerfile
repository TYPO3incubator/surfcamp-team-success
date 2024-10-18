FROM composer:latest as build-app
WORKDIR /app
COPY composer.* ./
COPY ./local_packages ./local_packages
COPY ./patches ./patches
RUN composer install --ignore-platform-reqs

FROM node:20 as build-frontend
WORKDIR /app
COPY package*.json ./
RUN npm ci
COPY  postcss.config.cjs tailwind.config.js vite.config.js ./
COPY ./assets/ ./assets/
COPY ./local_packages ./local_packages
RUN npm run build:production

FROM serversideup/php:8.3-fpm-nginx-alpine
COPY ./config /var/www/html/config
COPY ./local_packages /var/www/html/local_packages
COPY --from=build-frontend /app/local_packages/success/Resources/Public/Vite /var/www/html/local_packages/success/Resources/Public/Vite
COPY --from=build-app /app/vendor /var/www/html/vendor
COPY --from=build-app /app/bin /var/www/html/bin
COPY --from=build-app /app/public /var/www/html/public
