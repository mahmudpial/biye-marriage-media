#!/bin/sh
set -e

# Configure Apache port based on Render's dynamic PORT variable (default 80 or 10000)
PORT="${PORT:-80}"
sed -i -E "s/Listen [0-9]+/Listen ${PORT}/" /etc/apache2/ports.conf
sed -i -E "s/<VirtualHost \*:[0-9]+>/<VirtualHost \*:${PORT}>/" /etc/apache2/sites-available/000-default.conf

# Strip accidental wrapping quotes from environment variables (common when copy-pasting into Render)
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

# 2. Enforce production-safe defaults for containerized Render deployment
if [ -z "$APP_ENV" ]; then
    sed -i "s|^APP_ENV=.*|APP_ENV=production|" /var/www/html/.env
fi

if [ -z "$APP_DEBUG" ]; then
    sed -i "s|^APP_DEBUG=.*|APP_DEBUG=false|" /var/www/html/.env
fi

if [ -z "$LOG_CHANNEL" ]; then
    sed -i "s|^LOG_CHANNEL=.*|LOG_CHANNEL=stderr|" /var/www/html/.env
fi

# Switch session & cache drivers to file to avoid database connectivity/locking bottlenecks
sed -i "s|^SESSION_DRIVER=.*|SESSION_DRIVER=file|" /var/www/html/.env
sed -i "s|^CACHE_STORE=.*|CACHE_STORE=file|" /var/www/html/.env

# 3. Handle Database Configuration (PostgreSQL / Supabase / SQLite)
# If DB_HOST or DATABASE_URL points to PostgreSQL/Supabase and DB_CONNECTION is not set, default to pgsql
if [ -z "$DB_CONNECTION" ]; then
    case "$DATABASE_URL$DB_HOST" in
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

# Write explicit database connection parameters into .env
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

# If DATABASE_URL has unencoded special characters like '@' or '#', avoid passing it as DB_URL
# to prevent "database configuration URL is malformed" crashes
if [ -n "$DATABASE_URL" ]; then
    sed -i "s|^DB_URL=.*|# DB_URL=|" /var/www/html/.env 2>/dev/null || true
fi

# 4. Ensure a valid, non-empty APP_KEY is set in both .env and the current shell environment
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
        sed -i "s|^APP_KEY=.*|APP_KEY=${EXISTING_KEY}|" /var/www/html/.env
    fi
fi

# 5. Ensure all runtime directories exist
mkdir -p /var/www/html/storage/framework/sessions
mkdir -p /var/www/html/storage/framework/views
mkdir -p /var/www/html/storage/framework/cache
mkdir -p /var/www/html/storage/logs
mkdir -p /var/www/html/bootstrap/cache
mkdir -p /var/www/html/database

# 6. Setup SQLite database file if sqlite driver is used
if [ "$DB_CONNECTION" = "sqlite" ]; then
    if [ ! -f /var/www/html/database/database.sqlite ]; then
        touch /var/www/html/database/database.sqlite
    fi
fi

# 7. Run database migrations (failsafe with || true so container never crashes if remote DB is unreachable)
echo "Running database migrations..."
php artisan migrate --force --no-interaction || echo "Warning: Database migration failed, continuing boot..."

# 8. Optimize package discovery, configuration, routes, and views
echo "Optimizing Laravel configuration..."
php artisan package:discover --ansi --no-interaction || true
php artisan config:cache --no-interaction || true
php artisan route:cache --no-interaction || true
php artisan view:cache --no-interaction || true

# 9. Set final ownership and permissions for www-data AFTER all artisan commands run
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/database
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/database
if [ -f /var/www/html/database/database.sqlite ]; then
    chmod 664 /var/www/html/database/database.sqlite
fi

echo "Starting Apache server on port ${PORT}..."
exec apache2-foreground
