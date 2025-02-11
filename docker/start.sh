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

    echo "Otimizando autoload..."
    composer dump-autoload --working-dir=/var/www/html --optimize
else
    echo "composer.json não encontrado. Pulando instalação de dependências."
fi

# Inicia o Apache
exec apache2-foreground