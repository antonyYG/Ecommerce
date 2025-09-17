# Imagen base oficial de PHP con extensiones necesarias para Laravel
FROM php:8.2-cli

# Instalar dependencias del sistema
RUN apt-get update && apt-get install -y \
    git unzip libpq-dev libonig-dev libxml2-dev libzip-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath zip

# Instalar Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Instalar Node para compilar assets
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs

# Crear carpeta de la app
WORKDIR /app

# Copiar archivos del proyecto
COPY . .

# Instalar dependencias PHP y Node
RUN composer install --optimize-autoloader --no-dev \
    && npm install \
    && npm run build \
    && php artisan config:clear \
    && php artisan cache:clear

# Exponer el puerto
EXPOSE 10000

# Comando de inicio
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=10000"]
