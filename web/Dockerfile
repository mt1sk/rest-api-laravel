FROM php:7.3-apache

RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini" \
    && sed -i 's/DocumentRoot\ \/var\/www\/html/DocumentRoot\ \/var\/www\/html\/public/g' /etc/apache2/sites-available/000-default.conf \
#    && cp "$PHP_INI_DIR/custom.d/custom.ini" "$PHP_INI_DIR/conf.d/" \
    && apt-get update \
    && apt-get install -y nano \
    && docker-php-ext-install pdo_mysql \
    && a2enmod rewrite \
    && rm -rf /var/lib/apt/lists/*

#COPY $PHP_INI_DIR/custom.d/custom.ini $PHP_INI_DIR/conf.d/
