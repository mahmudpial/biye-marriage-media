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

# 3. Handle Database Configuration (PostgreSQL / Supabase / SQLite)
# If DATABASE_URL is provided, safely parse it into individual connection variables
if [ -n "$DATABASE_URL" ] && [ -z "$DB_HOST" ]; then
    echo "Notice: Extracting connection parameters from DATABASE_URL..."
    eval $(php -r '
        $url = parse_url(getenv("DATABASE_URL"));
        if ($url) {
            if (isset($url["host"])) echo "export DB_HOST=" . escapeshellarg($url["host"]) . "\n";
            if (isset($url["port"])) echo "export DB_PORT=" . escapeshellarg($url["port"]) . "\n";
            if (isset($url["user"])) echo "export DB_USERNAME=" . escapeshellarg(urldecode($url["user"])) . "\n";
            if (isset($url["pass"])) echo "export DB_PASSWORD=" . escapeshellarg(urldecode($url["pass"])) . "\n";
            if (isset($url["path"])) echo "export DB_DATABASE=" . escapeshellarg(ltrim($url["path"], "/")) . "\n";
            echo "export DB_CONNECTION=pgsql\n";
        }
    ')
fi

# Prevent Laravel URL parser from breaking on special characters like '#' and '@' in DATABASE_URL
unset DATABASE_URL
unset DB_URL

# Determine connection: if pgsql is set but DB_HOST is missing or localhost, fallback to sqlite
if [ "$DB_CONNECTION" = "pgsql" ]; then
    if [ -z "$DB_HOST" ] || [ "$DB_HOST" = "127.0.0.1" ] || [ "$DB_HOST" = "localhost" ]; then
        echo "Notice: PostgreSQL host is not set. Falling back to SQLite..."
        export DB_CONNECTION=sqlite
    fi
fi

if [ -z "$DB_CONNECTION" ]; then
    export DB_CONNECTION=sqlite
fi

# Safely write database configuration into .env using PHP (handles all special characters cleanly)
php -r '
    $envFile = "/var/www/html/.env";
    $content = file_exists($envFile) ? file_get_contents($envFile) : "";
    $vars = [
        "DB_CONNECTION" => getenv("DB_CONNECTION"),
        "DB_HOST" => getenv("DB_HOST"),
        "DB_PORT" => getenv("DB_PORT"),
        "DB_DATABASE" => getenv("DB_DATABASE"),
        "DB_USERNAME" => getenv("DB_USERNAME"),
        "DB_PASSWORD" => getenv("DB_PASSWORD"),
        "DB_SSLMODE" => getenv("DB_SSLMODE") ?: "require",
    ];
    foreach ($vars as $key => $val) {
        if ($val !== false && $val !== null && $val !== "") {
            $pattern = "/^" . preg_quote($key, "/") . "=.*/m";
            $line = $key . "=\"" . addcslashes($val, "\"\\\$") . "\"";
            if (preg_match($pattern, $content)) {
                $content = preg_replace($pattern, $line, $content);
            } else {
                $content .= "\n" . $line;
            }
        }
    }
    file_put_contents($envFile, $content);
'

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
         /var/www/html/storage/app/public/profiles \
         /var/www/html/storage/app/public/stories \
         /var/www/html/bootstrap/cache \
         /var/www/html/database

# 6. Database Verification & SQLite fallback
if [ "$DB_CONNECTION" = "pgsql" ]; then
    echo "Verifying PostgreSQL connection to ${DB_HOST}..."
    if ! php -r '
        require "/var/www/html/vendor/autoload.php";
        $app = require_once "/var/www/html/bootstrap/app.php";
        $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
        $kernel->bootstrap();
        try {
            Illuminate\Support\Facades\DB::connection()->getPdo();
            echo "PostgreSQL connection verified successfully.\n";
            exit(0);
        } catch (\Throwable $e) {
            echo "PostgreSQL connection error: " . $e->getMessage() . "\n";
            exit(1);
        }
    '; then
        echo "Warning: PostgreSQL database unreachable. Falling back to SQLite to guarantee application availability..."
        export DB_CONNECTION=sqlite
        php -r '
            $file = "/var/www/html/.env";
            $c = preg_replace("/^DB_CONNECTION=.*/m", "DB_CONNECTION=sqlite", file_get_contents($file));
            file_put_contents($file, $c);
        '
    fi
fi

if [ "$DB_CONNECTION" = "sqlite" ]; then
    mkdir -p /var/www/html/database
    if [ ! -f /var/www/html/database/database.sqlite ]; then
        touch /var/www/html/database/database.sqlite
    fi
    chmod 664 /var/www/html/database/database.sqlite
fi

# 7. Database migrations and optimizations
echo "Running database migrations on ${DB_CONNECTION}..."
php artisan migrate --force --no-interaction || echo "Warning: Migration failed, continuing boot..."

echo "Seeding default admin user..."
php artisan db:seed --class=AdminUserSeeder --force --no-interaction || echo "Warning: Admin seeder failed, continuing boot..."

echo "Seeding candidate profiles..."
php artisan db:seed --class=CandidateProfileSeeder --force --no-interaction || echo "Warning: Candidate profile seeder failed, continuing boot..."

echo "Seeding membership packages..."
php artisan db:seed --class=MembershipPackageSeeder --force --no-interaction || echo "Warning: Membership package seeder failed, continuing boot..."

echo "Seeding success stories..."
php artisan db:seed --class=SuccessStorySeeder --force --no-interaction || echo "Warning: Success story seeder failed, continuing boot..."

echo "Seeding consultation inquiries..."
php artisan db:seed --class=ConsultationInquirySeeder --force --no-interaction || echo "Warning: Consultation inquiry seeder failed, continuing boot..."

echo "Ensuring storage symlink exists..."
php artisan storage:link --force --no-interaction || true

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
