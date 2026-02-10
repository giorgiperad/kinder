# Base PHP image with FPM (Alpine for smaller size)
FROM php:8.3-fpm-alpine

# Install system deps and common PHP extensions Laravel needs
RUN apk add --no-cache \
    libzip-dev \
    zip \
    unzip \
    git \
    nginx \
    supervisor \
    && docker-php-ext-install pdo_mysql zip pcntl bcmath

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Nginx config (simple for Laravel public folder)
RUN mkdir -p /run/nginx
COPY <<EOF /etc/nginx/http.d/default.conf
server {
    listen 8080;
    server_name localhost;
    root /var/www/public;
    index index.php;

    location / {
        try_files \$uri \$uri/ /index.php?\$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass 127.0.0.1:9000;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME \$document_root\$fastcgi_script_name;
        include fastcgi_params;
    }
}
EOF

# Supervisord to run both nginx and php-fpm
COPY <<EOF /etc/supervisor/conf.d/supervisord.conf
[supervisord]
nodaemon=true

[program:php-fpm]
command=php-fpm
autorestart=true

[program:nginx]
command=nginx -g "daemon off;"
autorestart=true
EOF

WORKDIR /var/www

# Copy app code
COPY . .

# Install Composer dependencies (production)
RUN composer install --optimize-autoloader --no-dev --no-interaction --prefer-dist

# Frontend assets (if you use npm/mix)
RUN npm ci --only=production && npm run prod

# Laravel permissions
RUN chown -R www-data:www-data storage bootstrap/cache

# Expose port for Cloud Run
EXPOSE 8080

# Start supervisord
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
