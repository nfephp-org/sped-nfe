FROM php:8.3-cli

ARG USER_ID=1000
ARG GROUP_ID=1000

ENV COMPOSER_ALLOW_SUPERUSER=1
ENV COMPOSER_HOME=/tmp/composer

RUN apt-get update && apt-get install -y --no-install-recommends \
    git \
    unzip \
    zip \
    libxml2-dev \
    libzip-dev \
    libcurl4-openssl-dev \
    && docker-php-ext-install -j"$(nproc)" \
    dom \
    simplexml \
    soap \
    zip \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer

RUN groupadd -g "${GROUP_ID}" devuser \
    && useradd -m -u "${USER_ID}" -g devuser -s /bin/bash devuser

WORKDIR /var/www/sped-nfe

USER devuser

CMD ["bash"]
