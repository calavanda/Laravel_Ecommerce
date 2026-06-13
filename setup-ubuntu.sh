#!/usr/bin/env bash
# =====================================================================
# setup-ubuntu.sh
# Script de configuración automática para Ubuntu Server 22.04 / 24.04
#
# Uso (ejecutar como root o con sudo):
#   curl -sSL https://raw.githubusercontent.com/TU_REPO/main/setup-ubuntu.sh | sudo bash -s -- <rol>
#
# Roles disponibles:
#   lb    → PC1  – Load Balancer + Cloudflare Tunnel
#   app   → PC2/PC3 – Servidor de Aplicación Laravel
#   db    → PC4  – Base de Datos MySQL + Redis
#
# Ejemplo:
#   sudo bash setup-ubuntu.sh db
# =====================================================================

set -e

ROL="${1:-app}"
REPO_DIR="/opt/eliteshop"
REPO_URL="${2:-https://github.com/calavanda/Laravel_Ecommerce.git}"

# ─── Colores ─────────────────────────────────────────────────────────
RED='\033[0;31m'; GREEN='\033[0;32m'; YELLOW='\033[1;33m'
BLUE='\033[0;34m'; BOLD='\033[1m'; RESET='\033[0m'

log()  { echo -e "${GREEN}[✔]${RESET} $1"; }
info() { echo -e "${BLUE}[→]${RESET} $1"; }
warn() { echo -e "${YELLOW}[!]${RESET} $1"; }
err()  { echo -e "${RED}[✘]${RESET} $1"; exit 1; }

echo ""
echo -e "${BOLD}╔══════════════════════════════════════════╗${RESET}"
echo -e "${BOLD}║   EliteShop – Setup Ubuntu Server        ║${RESET}"
echo -e "${BOLD}║   Rol: $(printf '%-35s' "$ROL")║${RESET}"
echo -e "${BOLD}╚══════════════════════════════════════════╝${RESET}"
echo ""

# ─── 1. Actualizar el sistema ─────────────────────────────────────────
info "Actualizando paquetes del sistema..."
apt-get update -qq && apt-get upgrade -y -qq
log "Sistema actualizado."

# ─── 2. Instalar dependencias básicas ────────────────────────────────
info "Instalando dependencias: curl, git, ufw..."
apt-get install -y -qq curl git ufw ca-certificates gnupg lsb-release
log "Dependencias instaladas."

# ─── 3. Instalar Docker Engine ────────────────────────────────────────
if ! command -v docker &>/dev/null; then
    info "Instalando Docker Engine..."
    install -m 0755 -d /etc/apt/keyrings
    curl -fsSL https://download.docker.com/linux/ubuntu/gpg | gpg --dearmor -o /etc/apt/keyrings/docker.gpg
    chmod a+r /etc/apt/keyrings/docker.gpg
    echo "deb [arch=$(dpkg --print-architecture) signed-by=/etc/apt/keyrings/docker.gpg] \
        https://download.docker.com/linux/ubuntu $(lsb_release -cs) stable" \
        | tee /etc/apt/sources.list.d/docker.list > /dev/null
    apt-get update -qq
    apt-get install -y -qq docker-ce docker-ce-cli containerd.io docker-compose-plugin
    systemctl enable --now docker
    log "Docker instalado: $(docker --version)"
else
    log "Docker ya instalado: $(docker --version)"
fi

# ─── 4. Clonar el repositorio ─────────────────────────────────────────
if [ ! -d "$REPO_DIR" ]; then
    info "Clonando repositorio en $REPO_DIR..."
    git clone "$REPO_URL" "$REPO_DIR"
else
    info "Actualizando repositorio existente..."
    git -C "$REPO_DIR" pull
fi
log "Código fuente listo en $REPO_DIR."

# ─── 5. Copiar .env de producción ────────────────────────────────────
if [ ! -f "$REPO_DIR/.env" ]; then
    cp "$REPO_DIR/.env.production" "$REPO_DIR/.env"
    warn "⚠  Archivo .env copiado. Edítalo antes de continuar:"
    warn "   nano $REPO_DIR/.env"
    warn "   → Ajusta DB_HOST, REDIS_HOST a la IP de PC4"
fi

# ─── 6. Configurar firewall (UFW) ─────────────────────────────────────
info "Configurando firewall UFW..."
ufw default deny incoming
ufw default allow outgoing
ufw allow ssh        # Puerto 22 – administración remota

case "$ROL" in
  lb)
    ufw allow 80/tcp   # HTTP (Cloudflare llega aquí)
    ufw allow 443/tcp  # HTTPS
    ;;
  app)
    ufw allow from 192.168.0.0/16 to any port 8080  # Solo LAN puede acceder
    ;;
  db)
    ufw allow from 192.168.0.0/16 to any port 3306  # MySQL – solo LAN
    ufw allow from 192.168.0.0/16 to any port 6379  # Redis – solo LAN
    ;;
esac

ufw --force enable
log "Firewall configurado para rol: $ROL"

# ─── 7. Crear servicio systemd para auto-arranque ─────────────────────
COMPOSE_FILE=""
case "$ROL" in
  lb)  COMPOSE_FILE="docker-compose.lb.yml" ;;
  app) COMPOSE_FILE="docker-compose.app.yml" ;;
  db)  COMPOSE_FILE="docker-compose.db.yml" ;;
  *)   err "Rol desconocido: $ROL. Usa: lb | app | db" ;;
esac

info "Creando servicio systemd: eliteshop-$ROL.service..."
cat > "/etc/systemd/system/eliteshop-$ROL.service" <<EOF
[Unit]
Description=EliteShop – $ROL
After=docker.service network-online.target
Requires=docker.service
Wants=network-online.target

[Service]
Type=oneshot
RemainAfterExit=yes
WorkingDirectory=$REPO_DIR
ExecStart=/usr/bin/docker compose -f $COMPOSE_FILE up -d --pull always --env-file /opt/eliteshop/.env
ExecStop=/usr/bin/docker compose -f $COMPOSE_FILE down
TimeoutStartSec=300

[Install]
WantedBy=multi-user.target
EOF

systemctl daemon-reload
systemctl enable "eliteshop-$ROL.service"
log "Servicio systemd creado. Arrancará automáticamente en cada reinicio."

# ─── 8. Lanzar los contenedores ───────────────────────────────────────
echo ""
info "Levantando contenedores ($COMPOSE_FILE)..."
cd "$REPO_DIR"
docker compose -f "$COMPOSE_FILE" up -d

echo ""
echo -e "${GREEN}${BOLD}══════════════════════════════════════════${RESET}"
echo -e "${GREEN}${BOLD}  ✅ Setup completado para rol: $ROL       ${RESET}"
echo -e "${GREEN}${BOLD}══════════════════════════════════════════${RESET}"
echo ""

case "$ROL" in
  lb)
    echo -e "  Verifica: ${BOLD}curl http://localhost/health-check${RESET}"
    echo -e "  Logs:     ${BOLD}docker logs nginx-load-balancer -f${RESET}"
    ;;
  app)
    echo -e "  Verifica: ${BOLD}curl http://localhost:8080/health-check${RESET}"
    echo -e "  Logs:     ${BOLD}docker logs laravel-app -f${RESET}"
    warn "  Si es la primera vez, espera ~30s para que la DB esté lista."
    ;;
  db)
    echo -e "  Verifica MySQL: ${BOLD}docker exec production-mysql mysqladmin ping -u root -padmin${RESET}"
    echo -e "  Verifica Redis: ${BOLD}docker exec production-redis redis-cli ping${RESET}"
    ;;
esac
echo ""
