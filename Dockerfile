FROM php:8.3-fpm-alpine

# ----------------------------------------------------
# System dependencies & PHP extensions
# ----------------------------------------------------
RUN apk add --no-cache \
    nginx \
    supervisor \
    git \
    zip \
    unzip \
    libzip-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    oniguruma-dev \
    $PHPIZE_DEPS \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install \
        pdo_mysql \
        zip \
        pcntl \
        bcmath \
        gd \
    && apk del $PHPIZE_DEPS

# ----------------------------------------------------
# Composer
# ----------------------------------------------------
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# ----------------------------------------------------
# Nginx config
# ----------------------------------------------------
RUN mkdir -p /run/nginx && \
    echo 'server {\n\
        listen 8080;\n\
        server_name localhost;\n\
        root /var/www/public;\n\
        index index.php index.html;\n\
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

# ----------------------------------------------------
# Supervisor config
# ----------------------------------------------------
RUN echo '[supervisord]\n\
nodaemon=true\n\
\n\
[program:php-fpm]\n\
command=php-fpm --nodaemonize\n\
autorestart=true\n\
stdout_logfile=/dev/stdout\n\
stdout_logfile_maxbytes=0\n\
stderr_logfile=/dev/stderr\n\
stderr_logfile_maxbytes=0\n\
\n\
[program:nginx]\n\
command=nginx -g "daemon off;"\n\
autorestart=true\n\
stdout_logfile=/dev/stdout\n\
stdout_logfile_maxbytes=0\n\
stderr_logfile=/dev/stderr\n\
stderr_logfile_maxbytes=0' > /etc/supervisord.conf

# ----------------------------------------------------
# App setup
# ----------------------------------------------------
WORKDIR /var/www
COPY . .

# ----------------------------------------------------
# Composer install (Laravel-safe)
# ----------------------------------------------------
RUN composer install \
    --no-dev \
    --optimize-autoloader \
    --no-interaction \
    --prefer-dist

# ----------------------------------------------------
# Frontend build (optional, won't fail build)
# ----------------------------------------------------
RUN if [ -f package.json ]; then npm ci --only=production && npm run prod || true; fi

# ----------------------------------------------------
# Permissions (Laravel)
# ----------------------------------------------------
RUN chown -R www-data:www-data storage bootstrap/cache

EXPOSE 8080

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisord.conf"]
