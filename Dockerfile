FROM php:8.1

# Environment
ENV APP_HOME=/app

# Set app user and directory
WORKDIR $APP_HOME

# Install dependencies
RUN apt-get update && \
    apt-get upgrade -y && \
    apt-get install -y git libzip-dev zip && \
    pecl install ast && docker-php-ext-enable ast && \
    docker-php-ext-install zip

# Installing composer
COPY --from=composer/composer:latest-bin /composer /usr/bin/composer

# Copy composer dependencies
COPY composer.json composer.lock $APP_HOME/

# Install all composer dependencies
RUN composer install --optimize-autoloader

# Copy source files
COPY . $APP_HOME