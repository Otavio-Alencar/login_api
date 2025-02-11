FROM php:8.2-apache

# Instala dependências do sistema
RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    && docker-php-ext-install pdo_mysql mysqli

# Habilita o módulo rewrite do Apache
RUN a2enmod rewrite

# Instala o Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Define o diretório de trabalho
WORKDIR /var/www/html

# Copia os arquivos do projeto para o contêiner
COPY . /var/www/html

# Copia o script de inicialização
COPY start.sh /usr/local/bin/start.sh

# Torna o script executável
RUN chmod +x /usr/local/bin/start.sh

# Ajusta as permissões dos arquivos (se necessário)
RUN chown -R www-data:www-data /var/www/html

# Expõe a porta 80
EXPOSE 80

# Usa o script de inicialização como comando padrão
CMD ["start.sh"]