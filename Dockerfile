# Use a lightweight PHP + Alpine base
FROM php:8.3-fpm-alpine

# Install required system packages and PHP extensions
RUN apk add --no-cache \
    libzip-dev \
    zip \
    unzip \
    git \
    nginx \
    supervisor \
    && docker-php-ext-install \
        pdo_mysql \
        zip \
        pcntl \
        bcmath

# Install Composer from official image
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Create nginx config file (single RUN to avoid parse issues)
RUN mkdir -p /run/nginx && \
    echo 'server {\n\
        listen 8080;\n\
        server_name localhost;\n\
        root /var/www/public;\n\
        index index.php;\n\
\n\
        location / {\n\
            try_files $uri $uri/ /index.php?$query_string;\n\
        }\n\
\n\
        location ~ \.php$ {\n\
            fastcgi_pass 127.0.0.1:9000;\n\
            fastcgi_index index.php;\n\
            fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;\n\
            include fastcgi_params;\n\
        }\n\
    }' > /etc/nginx/http.d/default.conf

# Supervisord config to manage php-fpm + nginx
RUN echo '[supervisord]\n\
nodaemon=true\n\
\n\
[program:php-fpm]\n\
command=php-fpm\n\
autorestart=true\n\
\n\
[program:nginx]\n\
command=nginx -g "daemon off;"\n\
autorestart=true' > /etc/supervisor/conf.d/supervisord.conf

# Set working directory
WORKDIR /var/www

# Copy your Laravel application code
COPY . .

# Install Composer dependencies (production optimized)
RUN composer install \
    --optimize-autoloader \
    --no-dev \
    --no-interaction \
    --prefer-dist

# Install & build frontend assets (Laravel Mix / Vite if used)
# Use || true so build doesn't fail if no npm needed
RUN npm ci --only=production && npm run prod || true

# Set correct permissions for Laravel
RUN chown -R www-data:www-data storage bootstrap/cache

# Cloud Run expects port from $PORT env (defaults to 8080)
EXPOSE 8080

# Start services with supervisord
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
