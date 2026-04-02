FROM wordpress:6.9.4-php8.2-apache

# PHP拡張 & 必要パッケージの追加（任意）
RUN apt-get update && apt-get install -y \
    less \
    default-mysql-client \
    && rm -rf /var/lib/apt/lists/*

# WP-CLI のインストール
RUN curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar \
    && chmod +x wp-cli.phar \
    && mv wp-cli.phar /usr/local/bin/wp

# php.ini のカスタム設定
COPY ./docker/php/custom.ini /usr/local/etc/php/conf.d/custom.ini
