FROM composer:latest as build-app
WORKDIR /app
COPY composer.* ./
COPY ./local_packages ./local_packages
RUN composer install --ignore-platform-reqs --no-dev

FROM node:20 as build-frontend
WORKDIR /app
COPY package*.json ./
RUN npm ci
COPY  postcss.config.cjs tailwind.config.js vite.config.js ./
COPY ./assets/ ./assets/
COPY ./local_packages ./local_packages
RUN npm run build:production

FROM serversideup/php:8.3-fpm-nginx-alpine
USER root
# Install needed php extensions https://docs.typo3.org/m/typo3/tutorial-getting-started/main/en-us/Installation/SystemRequirements/Index.html
RUN install-php-extensions intl gd zip zlib exif
# Add locales and image processing tools
RUN apk add --no-cache musl-locales graphicsmagick ghostscript
COPY --chown=www-data ./config /var/www/html/config
COPY --chown=www-data ./local_packages /var/www/html/local_packages
COPY --chmod=755 ./docker/web/entrypoint.d/ /etc/entrypoint.d/
COPY ./docker/web/zzz-typo3-php.ini /usr/local/etc/php/conf.d/
COPY ./docker/web/typo3.conf /etc/nginx/server-opts.d/
COPY --from=build-frontend --chown=www-data /app/local_packages/success/Resources/Public/Vite /var/www/html/local_packages/success/Resources/Public/Vite
COPY --from=build-app --chown=www-data /app/vendor /var/www/html/vendor
COPY --from=build-app --chown=www-data /app/bin /var/www/html/bin
COPY --from=build-app --chown=www-data /app/public /var/www/html/public
COPY --chown=www-data ./data/files/public/fileadmin /var/www/html/public/fileadmin
USER www-data
ENV MUSL_LOCPATH=/usr/share/i18n/locales/musl
ENV CHARSET=en_US.UTF-8
ENV LANG=en_US.UTF-8
ENV LC_COLLATE=en_US.UTF-8
