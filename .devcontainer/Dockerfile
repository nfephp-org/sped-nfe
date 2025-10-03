FROM mcr.microsoft.com/devcontainers/php:7.4
ENV YARNKEY=yarn-keyring.gpg
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    libxml2-dev \
    unzip \
 && docker-php-ext-configure gd --with-freetype --with-jpeg \
 && docker-php-ext-install -j$(nproc) gd soap zip \
 && rm -rf /var/lib/apt/lists/*