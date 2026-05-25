#!/bin/sh
set -e

echo "========================================"
echo "  EliteShop – Container Startup Script  "
echo "========================================"

# 1. Generar APP_KEY si no existe
if [ -z "$APP_KEY" ]; then
    echo "[boot] Generando APP_KEY..."
    APP_KEY=$(php artisan key:generate --show)
    export APP_KEY
fi

# 2. Esperar a que la base de datos esté lista
echo "[boot] Esperando conexión con MySQL en $DB_HOST:$DB_PORT ..."
timeout=60
while ! php -r "new PDO('mysql:host=$DB_HOST;port=$DB_PORT;dbname=$DB_DATABASE', '$DB_USERNAME', '$DB_PASSWORD');" 2>/dev/null; do
    sleep 2
    timeout=$((timeout - 2))
    if [ "$timeout" -le 0 ]; then
        echo "[error] No se pudo conectar a la base de datos. Abortando."
        exit 1
    fi
    echo "[boot] Esperando DB... ($timeout s restantes)"
done
echo "[boot] ✅ Base de datos disponible."

# 3. Correr migraciones (solo si hay cambios pendientes)
echo "[boot] Ejecutando migraciones..."
php artisan migrate --force --no-interaction

# 4. Vaciar y re-cachear config/rutas para producción
echo "[boot] Optimizando caché de configuración..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 5. Storage link
php artisan storage:link --quiet 2>/dev/null || true

# 6. Ajustar permisos de storage (por si acaso)
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

echo "[boot] ✅ Aplicación lista. Iniciando servicios..."

# 7. Iniciar Supervisor (gestiona Nginx + PHP-FPM + Queue Worker)
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
