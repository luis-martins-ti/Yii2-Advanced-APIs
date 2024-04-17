# Use a imagem oficial do PHP 7.1
FROM php:7.1
 
# Instale extensões PHP necessárias
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd mysqli pdo_mysql zip

# Instale o Composer 1.10
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer --version=1.10.22

# Instale o cliente MySQL
RUN apt-get install -y default-mysql-client

# Copie os arquivos do seu projeto para o diretório de trabalho no contêiner
COPY . /var/www/html

# Defina o diretório de trabalho
WORKDIR /var/www/html

# Exponha a porta 80 para o servidor da web
EXPOSE 80

# Inicie o servidor da web PHP embutido ao iniciar o contêiner
CMD ["php", "-S", "0.0.0.0:80"]
