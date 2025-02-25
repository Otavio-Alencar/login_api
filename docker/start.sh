#!/bin/bash

# Verifica se o Composer está instalado
if ! command -v composer &> /dev/null; then
    echo "Composer não está instalado. Instalando..."
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
    chmod +x /usr/local/bin/composer
fi

# Verifica se o composer.json existe
if [ -f /var/www/html/composer.json ]; then
    echo "Instalando dependências do Composer..."
    composer install --working-dir=/var/www/html --no-interaction

    echo "Instalando o pacote vlucas/phpdotenv..."
    composer require vlucas/phpdotenv --working-dir=/var/www/html --no-interaction

    echo "Otimizando autoload..."
    composer dump-autoload --working-dir=/var/www/html --optimize

    # Verifica se o arquivo .env existe
    if [ ! -f /var/www/html/.env ]; then
        echo "Arquivo .env não encontrado. Criando a partir de .env.example..."
        cp /var/www/html/.env.example /var/www/html/.env
    fi
else
    echo "composer.json não encontrado. Pulando instalação de dependências."
fi

# Inicia o Apache
exec apache2-foreground