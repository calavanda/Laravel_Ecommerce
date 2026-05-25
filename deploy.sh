#!/usr/bin/env bash
# =====================================================================
# deploy.sh – Script de despliegue para EliteShop
# Ejecutar en: PC de desarrollo (tu Windows/Mac con el código fuente)
#
# Uso:
#   chmod +x deploy.sh
#   ./deploy.sh <tu-dockerhub-usuario>
#
# Ejemplo:
#   ./deploy.sh johndoe
# =====================================================================

set -e

DOCKER_USER="${1:-tu-dockerhub-usuario}"
IMAGE_NAME="$DOCKER_USER/ecommerce-laravel"
TAG="${2:-latest}"

echo ""
echo "╔════════════════════════════════════════╗"
echo "║   EliteShop – Deploy Script v1.0       ║"
echo "╚════════════════════════════════════════╝"
echo ""
echo "→ Imagen destino: $IMAGE_NAME:$TAG"
echo ""

# 1. Build de la imagen
echo "[1/4] Construyendo imagen Docker..."
docker build -t "$IMAGE_NAME:$TAG" .

# 2. Push a Docker Hub
echo "[2/4] Subiendo imagen a Docker Hub..."
docker push "$IMAGE_NAME:$TAG"

# 3. Instrucciones para PC2 y PC3
echo ""
echo "[3/4] ✅ Imagen publicada exitosamente."
echo ""
echo "══════════════════════════════════════════════"
echo " Ahora en PC2 y PC3, ejecuta:"
echo "══════════════════════════════════════════════"
echo ""
echo "  git clone https://github.com/calavanda/Laravel_Ecommerce && cd Laravel_Ecommerce"
echo "  cp .env.production .env"
echo "  # Edita .env: ajusta DB_HOST y REDIS_HOST a la IP de PC4"
echo "  docker compose -f docker-compose.app.yml pull"
echo "  docker compose -f docker-compose.app.yml up -d"
echo ""
echo "══════════════════════════════════════════════"
echo " Para PC4 (Base de Datos):"
echo "══════════════════════════════════════════════"
echo ""
echo "  git clone https://github.com/calavanda/Laravel_Ecommerce && cd Laravel_Ecommerce"
echo "  cp .env.production .env"
echo "  docker compose -f docker-compose.db.yml up -d"
echo ""
echo "══════════════════════════════════════════════"
echo " Para PC1 (Load Balancer):"
echo "══════════════════════════════════════════════"
echo ""
echo "  git clone https://github.com/calavanda/Laravel_Ecommerce && cd Laravel_Ecommerce"
echo "  # Crea tu Cloudflare Tunnel y pon el token en .env"
echo "  CLOUDFLARE_TUNNEL_TOKEN=xxxx docker compose -f docker-compose.lb.yml up -d"
echo ""
echo "[4/4] ¡Deploy listo! 🚀"
