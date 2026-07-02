#!/usr/bin/env bash
# =====================================================================
# deploy.sh – Script de despliegue para EliteShop
# Ejecutar en: PC de desarrollo (tu Windows con Docker Desktop)
#
# Uso:
#   bash deploy.sh <tu-dockerhub-usuario>
#
# Ejemplo:
#   bash deploy.sh calavanda
#
# Genera imagen multi-arquitectura que funciona en:
#   ✅ Intel/AMD  (linux/amd64)  → PCs normales / VMs x86
#   ✅ Apple M1/M2/M3 (linux/arm64) → Macs con Ubuntu Server ARM
# =====================================================================

set -e

DOCKER_USER="${1:-tu-dockerhub-usuario}"
IMAGE_NAME="$DOCKER_USER/ecommerce-laravel"
TAG="${2:-latest}"
BUILDER_NAME="eliteshop-multiarch"

echo ""
echo "╔══════════════════════════════════════════════╗"
echo "║   EliteShop – Deploy Script v2.0             ║"
echo "║   Multi-arquitectura: amd64 + arm64/v8       ║"
echo "╚══════════════════════════════════════════════╝"
echo ""
echo "→ Imagen destino : $IMAGE_NAME:$TAG"
echo "→ Plataformas    : linux/amd64, linux/arm64"
echo ""

# ─── 1. Verificar Docker Buildx ──────────────────────────────────────
if ! docker buildx version &>/dev/null; then
    echo "[error] Docker Buildx no está disponible."
    echo "        Instala Docker Desktop >= 19.03 o actualiza Docker."
    exit 1
fi
echo "[1/5] ✅ Buildx: $(docker buildx version | head -1)"

# ─── 2. Crear builder multi-plataforma ───────────────────────────────
echo "[2/5] Configurando builder '$BUILDER_NAME'..."
if docker buildx inspect "$BUILDER_NAME" &>/dev/null; then
    echo "      Reutilizando builder existente."
else
    docker buildx create --name "$BUILDER_NAME" --driver docker-container --bootstrap
    echo "      Builder creado."
fi
docker buildx use "$BUILDER_NAME"

# ─── 3. Instalar emuladores QEMU (compila ARM64 en x86) ──────────────
echo "[3/5] Activando emuladores QEMU para ARM64..."
docker run --privileged --rm tonistiigi/binfmt --install all 2>/dev/null || true
echo "      Emuladores QEMU listos."

# ─── 4. Build multi-plataforma + push ────────────────────────────────
echo "[4/5] Construyendo para linux/amd64 Y linux/arm64..."
echo "      ⏳ Puede tardar 5-15 min (ARM64 se emula vía QEMU)"
echo ""
docker buildx build \
    --platform linux/amd64,linux/arm64 \
    --tag "$IMAGE_NAME:$TAG" \
    --push \
    .

# ─── 5. Verificar manifest ───────────────────────────────────────────
echo ""
echo "[5/5] Verificando plataformas en Docker Hub..."
docker buildx imagetools inspect "$IMAGE_NAME:$TAG" | grep -E "Name|Platform" || true

echo ""
echo "╔══════════════════════════════════════════════╗"
echo "║  ✅ Imagen multi-arquitectura publicada!     ║"
echo "║  AMD64 (Intel/AMD/VMs x86)           ✅     ║"
echo "║  ARM64 (Mac M1/M2/M3 con Ubuntu)     ✅     ║"
echo "╚══════════════════════════════════════════════╝"
echo ""
echo "══════════════════════════════════════════════════"
echo " En PC2 y PC3 (app servers - cualquier arq.):"
echo "══════════════════════════════════════════════════"
echo ""
echo "  git clone https://github.com/calavanda/Laravel_Ecommerce && cd Laravel_Ecommerce"
echo "  cp .env.production .env"
echo "  nano .env   # Ajusta DB_HOST y REDIS_HOST a la IP de PC4"
echo "  docker compose -f docker-compose.app.yml pull"
echo "  docker compose -f docker-compose.app.yml up -d"
echo ""
echo "══════════════════════════════════════════════════"
echo " En PC4 (base de datos):"
echo "══════════════════════════════════════════════════"
echo ""
echo "  git clone https://github.com/calavanda/Laravel_Ecommerce && cd Laravel_Ecommerce"
echo "  cp .env.production .env"
echo "  docker compose -f docker-compose.db.yml up -d"
echo ""
echo "══════════════════════════════════════════════════"
echo " En PC1 (load balancer):"
echo "══════════════════════════════════════════════════"
echo ""
echo "  git clone https://github.com/calavanda/Laravel_Ecommerce && cd Laravel_Ecommerce"
echo "  docker compose -f docker-compose.lb.yml up -d"
echo ""
echo "[✔] ¡Deploy listo! 🚀  Docker detectará la arquitectura automáticamente."
