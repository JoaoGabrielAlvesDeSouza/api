# Use uma imagem base oficial do PHP com Apache
FROM php:8.2-apache

# Instale as dependências necessárias
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

# Instale o Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Configure o diretório de trabalho
WORKDIR /var/www/html

# Copie os arquivos da aplicação
COPY . .

# Instale as dependências do PHP
RUN composer install

# Copie o arquivo de configuração do Apache
COPY ./docker/apache/vhost.conf /etc/apache2/sites-available/000-default.conf

# Ative o módulo do Apache e limpe o cache do apt
RUN a2enmod rewrite && apt-get clean && rm -rf /var/lib/apt/lists/*

# Configure as permissões
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Exponha a porta 80 para o Apache
EXPOSE 80