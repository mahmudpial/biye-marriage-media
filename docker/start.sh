#!/bin/sh
set -e

# Dynamically set Nginx listening port based on Render's PORT variable (default: 10000)
PORT="${PORT:-10000}"
sed -i -E "s/listen [0-9]+/listen ${PORT}/g" /etc/nginx/http.d/default.conf
sed -i -E "s/listen \[::\]:[0-9]+/listen [::]:${PORT}/g" /etc/nginx/http.d/default.conf

# Strip accidental wrapping quotes from environment variables (common when pasting in Render)
strip_quotes() {
    echo "$1" | sed -e 's/^"//' -e 's/"$//' -e "s/^'//" -e "s/'$//"
}

if [ -n "$APP_KEY" ]; then
    APP_KEY=$(strip_quotes "$APP_KEY")
fi
if [ -n "$DB_PASSWORD" ]; then
    DB_PASSWORD=$(strip_quotes "$DB_PASSWORD")
fi
if [ -n "$DATABASE_URL" ]; then
    DATABASE_URL=$(strip_quotes "$DATABASE_URL")
fi

# Ensure PHP-FPM passes environment variables to PHP worker processes
if [ -f /usr/local/etc/php-fpm.d/www.conf ]; then
    sed -i "s/^;*clear_env\s*=.*/clear_env = no/" /usr/local/etc/php-fpm.d/www.conf
fi
if [ -f /usr/local/etc/php-fpm.d/docker.conf ]; then
    grep -q "^clear_env" /usr/local/etc/php-fpm.d/docker.conf || echo "clear_env = no" >> /usr/local/etc/php-fpm.d/docker.conf
fi

# 1. Ensure .env file exists in the container
if [ ! -f /var/www/html/.env ]; then
    if [ -f /var/www/html/.env.example ]; then
        echo "Notice: Creating .env from .env.example..."
        cp /var/www/html/.env.example /var/www/html/.env
    else
        echo "Notice: Creating default .env..."
        cat << 'EOF' > /var/www/html/.env
APP_NAME="Biye Marriage Media"
APP_ENV=production
APP_KEY=
APP_DEBUG=false
APP_URL=http://localhost

LOG_CHANNEL=stderr
LOG_LEVEL=debug

DB_CONNECTION=sqlite

SESSION_DRIVER=file
SESSION_LIFETIME=120
SESSION_ENCRYPT=false

CACHE_STORE=file
QUEUE_CONNECTION=sync
EOF
    fi
fi

# 2. Enforce production-safe defaults
if [ -z "$APP_ENV" ]; then
    sed -i "s|^APP_ENV=.*|APP_ENV=production|" /var/www/html/.env
fi

if [ -z "$APP_DEBUG" ]; then
    sed -i "s|^APP_DEBUG=.*|APP_DEBUG=false|" /var/www/html/.env
fi

if [ -z "$LOG_CHANNEL" ]; then
    sed -i "s|^LOG_CHANNEL=.*|LOG_CHANNEL=stderr|" /var/www/html/.env
fi

# Force file session & cache drivers, sync queues, and stderr logging in container environment
export SESSION_DRIVER=file
export CACHE_STORE=file
export CACHE_DRIVER=file
export QUEUE_CONNECTION=sync
export LOG_CHANNEL=stderr

sed -i "s|^SESSION_DRIVER=.*|SESSION_DRIVER=file|" /var/www/html/.env
sed -i "s|^CACHE_STORE=.*|CACHE_STORE=file|" /var/www/html/.env
sed -i "s|^CACHE_DRIVER=.*|CACHE_DRIVER=file|" /var/www/html/.env 2>/dev/null || echo "CACHE_DRIVER=file" >> /var/www/html/.env
sed -i "s|^LOG_CHANNEL=.*|LOG_CHANNEL=stderr|" /var/www/html/.env
sed -i "s|^QUEUE_CONNECTION=.*|QUEUE_CONNECTION=sync|" /var/www/html/.env

# Prevent Laravel URL parser from breaking on special characters like '#' and '@' in DATABASE_URL
unset DATABASE_URL
unset DB_URL

# 3. Handle Database Configuration (PostgreSQL / Supabase / SQLite)
if [ -z "$DB_CONNECTION" ]; then
    case "$DB_HOST" in
        *postgres*|*supabase*)
            export DB_CONNECTION=pgsql
            ;;
        *)
            export DB_CONNECTION=sqlite
            ;;
    esac
fi

if grep -q "^DB_CONNECTION=" /var/www/html/.env 2>/dev/null; then
    sed -i "s|^DB_CONNECTION=.*|DB_CONNECTION=${DB_CONNECTION}|" /var/www/html/.env
else
    echo "DB_CONNECTION=${DB_CONNECTION}" >> /var/www/html/.env
fi

# Write explicit database parameters if present
if [ -n "$DB_HOST" ]; then
    DB_HOST=$(strip_quotes "$DB_HOST")
    grep -q "^DB_HOST=" /var/www/html/.env && sed -i "s|^DB_HOST=.*|DB_HOST=${DB_HOST}|" /var/www/html/.env || echo "DB_HOST=${DB_HOST}" >> /var/www/html/.env
fi
if [ -n "$DB_PORT" ]; then
    DB_PORT=$(strip_quotes "$DB_PORT")
    grep -q "^DB_PORT=" /var/www/html/.env && sed -i "s|^DB_PORT=.*|DB_PORT=${DB_PORT}|" /var/www/html/.env || echo "DB_PORT=${DB_PORT}" >> /var/www/html/.env
fi
if [ -n "$DB_DATABASE" ]; then
    DB_DATABASE=$(strip_quotes "$DB_DATABASE")
    grep -q "^DB_DATABASE=" /var/www/html/.env && sed -i "s|^DB_DATABASE=.*|DB_DATABASE=${DB_DATABASE}|" /var/www/html/.env || echo "DB_DATABASE=${DB_DATABASE}" >> /var/www/html/.env
fi
if [ -n "$DB_USERNAME" ]; then
    DB_USERNAME=$(strip_quotes "$DB_USERNAME")
    grep -q "^DB_USERNAME=" /var/www/html/.env && sed -i "s|^DB_USERNAME=.*|DB_USERNAME=${DB_USERNAME}|" /var/www/html/.env || echo "DB_USERNAME=${DB_USERNAME}" >> /var/www/html/.env
fi
if [ -n "$DB_PASSWORD" ]; then
    grep -q "^DB_PASSWORD=" /var/www/html/.env && sed -i "s|^DB_PASSWORD=.*|DB_PASSWORD=\"${DB_PASSWORD}\"|" /var/www/html/.env || echo "DB_PASSWORD=\"${DB_PASSWORD}\"" >> /var/www/html/.env
fi

# 4. Ensure a valid, non-empty APP_KEY is set
if [ -n "$APP_KEY" ]; then
    echo "Notice: Using clean APP_KEY from environment."
    if grep -q "^APP_KEY=" /var/www/html/.env 2>/dev/null; then
        sed -i "s|^APP_KEY=.*|APP_KEY=${APP_KEY}|" /var/www/html/.env
    else
        echo "APP_KEY=${APP_KEY}" >> /var/www/html/.env
    fi
else
    EXISTING_KEY=$(grep "^APP_KEY=" /var/www/html/.env 2>/dev/null | cut -d '=' -f2-)
    EXISTING_KEY=$(strip_quotes "$EXISTING_KEY")
    if [ -z "$EXISTING_KEY" ] || [ "$EXISTING_KEY" = "" ]; then
        echo "Notice: Generating application key..."
        GENERATED_KEY=$(php artisan key:generate --show --no-interaction)
        export APP_KEY="$GENERATED_KEY"
        if grep -q "^APP_KEY=" /var/www/html/.env 2>/dev/null; then
            sed -i "s|^APP_KEY=.*|APP_KEY=${GENERATED_KEY}|" /var/www/html/.env
        else
            echo "APP_KEY=${GENERATED_KEY}" >> /var/www/html/.env
        fi
    else
        export APP_KEY="$EXISTING_KEY"
    fi
fi

# 5. Ensure all runtime directories exist
mkdir -p /var/www/html/storage/framework/sessions \
         /var/www/html/storage/framework/views \
         /var/www/html/storage/framework/cache \
         /var/www/html/storage/logs \
         /var/www/html/bootstrap/cache \
         /var/www/html/database

# 6. SQLite fallback file
if [ "$DB_CONNECTION" = "sqlite" ]; then
    if [ ! -f /var/www/html/database/database.sqlite ]; then
        touch /var/www/html/database/database.sqlite
    fi
fi

# 7. Database migrations and optimizations (failsafe with || true)
echo "Running database migrations..."
php artisan migrate --force --no-interaction || echo "Warning: Migration failed, continuing boot..."

echo "Seeding default admin user..."
php artisan db:seed --class=AdminUserSeeder --force --no-interaction || echo "Warning: Admin seeder failed, continuing boot..."

echo "Optimizing Laravel configuration..."
php artisan package:discover --ansi --no-interaction || true
php artisan optimize:clear || true
php artisan config:cache --no-interaction || true
php artisan route:cache --no-interaction || true
php artisan view:cache --no-interaction || true

# 8. Set ownership and permissions AFTER artisan commands have executed
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/database
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/database
if [ -f /var/www/html/database/database.sqlite ]; then
    chmod 664 /var/www/html/database/database.sqlite
fi

echo "Starting Supervisor (Nginx + PHP-FPM)..."
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
