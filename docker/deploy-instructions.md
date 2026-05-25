# EliteShop – Guía de Despliegue Distribuido

## Infraestructura

| Máquina | OS | Rol | IP Privada (ajustar) | Comando de setup |
|---------|-----|-----|----------------------|-----------------|
| PC 1 | Ubuntu Server 22.04 | Load Balancer + Cloudflare | 192.168.1.101 | `sudo bash setup-ubuntu.sh lb` |
| PC 2 | Ubuntu Server 22.04 | App Laravel (principal) | 192.168.1.102 | `sudo bash setup-ubuntu.sh app` |
| PC 3 | Ubuntu Server 22.04 | App Laravel (failover) | 192.168.1.103 | `sudo bash setup-ubuntu.sh app` |
| PC 4 | Ubuntu Server 22.04 | MySQL + Redis | 192.168.1.104 | `sudo bash setup-ubuntu.sh db` |
| Dev 1/2 | Windows | Desarrollo | – | `php artisan serve` + `npm run dev` |

---

## Paso 0 – Antes de empezar (en tu PC de desarrollo Windows)

### 0.1 Instalar Docker Desktop en Windows

Descarga desde https://www.docker.com/products/docker-desktop y activa la integración WSL2.

### 0.2 Crear cuenta en Docker Hub

Regístrate en https://hub.docker.com. Tu usuario será `DOCKER_USER` en los comandos siguientes.

### 0.3 Build y Push de la imagen

```powershell
# En tu terminal de Windows (PowerShell), desde la raíz del proyecto:
docker login
docker build -t calavanda/ecommerce-laravel:latest .
docker push calavanda/ecommerce-laravel:latest
```

> Cada vez que cambies código, repite este paso para actualizar la imagen.

---

## Paso 1 – Configurar PC4 (Base de Datos) primero

> PC4 debe estar lista antes de que PC2 y PC3 arranquen.

```bash
# En PC4 (Ubuntu Server) – conectar por SSH:
ssh usuario@192.168.1.104

# Descargar el script de configuración:
curl -sSL https://raw.githubusercontent.com/calavanda/Laravel_Ecommerce/main/setup-ubuntu.sh -o setup-ubuntu.sh

# Dar permisos y ejecutar como root:
sudo bash setup-ubuntu.sh db https://github.com/calavanda/Laravel_Ecommerce.git
```

**El script hace automáticamente:**
- ✅ Actualiza Ubuntu
- ✅ Instala Docker Engine
- ✅ Clona el repositorio en `/opt/eliteshop`
- ✅ Configura UFW: solo permite MySQL (3306) y Redis (6379) desde la LAN
- ✅ Crea servicio systemd (se auto-inicia en cada reboot)
- ✅ Levanta `docker-compose.db.yml`

**Verifica que funciona:**
```bash
docker exec production-mysql mysqladmin ping -u root -padmin
# Debe responder: mysqld is alive

docker exec production-redis redis-cli ping
# Debe responder: PONG
```

---

## Paso 2 – Configurar PC2 y PC3 (App Servers)

```bash
# En PC2 y PC3 (por separado):
ssh usuario@192.168.1.102   # (o .103 para PC3)

curl -sSL https://raw.githubusercontent.com/calavanda/Laravel_Ecommerce/main/setup-ubuntu.sh -o setup-ubuntu.sh
sudo bash setup-ubuntu.sh app https://github.com/calavanda/Laravel_Ecommerce.git
```

**Después del setup, editar el .env:**
```bash
sudo nano /opt/eliteshop/.env
```

Asegúrate de que estas líneas apunten a PC4:
```env
DB_HOST=192.168.1.104
REDIS_HOST=192.168.1.104
SESSION_DRIVER=redis
CACHE_STORE=redis
QUEUE_CONNECTION=redis
DOCKER_IMAGE=calavanda/ecommerce-laravel:latest
```

**Reiniciar los contenedores con la config correcta:**
```bash
cd /opt/eliteshop
docker compose -f docker-compose.app.yml up -d --pull always
```

**Verificar:**
```bash
curl http://localhost:8080/health-check
# Debe responder: OK
```

---

## Paso 3 – Configurar PC1 (Load Balancer + Cloudflare)

### 3.1 Crear el Cloudflare Tunnel

1. Entra a https://dash.cloudflare.com → **Zero Trust** → **Networks** → **Tunnels**
2. Crea un nuevo tunnel → llámalo `eliteshop-tunnel`
3. Selecciona el entorno **Docker**
4. Cloudflare te dará un comando como:
   ```
   docker run cloudflare/cloudflared:latest tunnel --no-autoupdate run --token eyJhGci...
   ```
5. **Copia solo el token** (la parte después de `--token`)

### 3.2 Ajustar la IP de los App Servers en Nginx

Editar `docker/nginx.lb.conf` en el repositorio (en tu PC de desarrollo):

```nginx
upstream laravel_backend {
    server 192.168.1.102:8080 ...;   # ← IP real de PC2
    server 192.168.1.103:8080 ...;   # ← IP real de PC3
}
```

Luego hacer commit y push.

### 3.3 Levantar PC1

```bash
ssh usuario@192.168.1.101

curl -sSL https://raw.githubusercontent.com/calavanda/Laravel_Ecommerce/main/setup-ubuntu.sh -o setup-ubuntu.sh
sudo bash setup-ubuntu.sh lb https://github.com/calavanda/Laravel_Ecommerce.git

# Editar el .env de PC1 y poner el token de Cloudflare:
sudo nano /opt/eliteshop/.env
# → CLOUDFLARE_TUNNEL_TOKEN=eyJhGci...

# Reiniciar con el token:
cd /opt/eliteshop
docker compose -f docker-compose.lb.yml up -d
```

### 3.4 Configurar Cloudflare (en el dashboard)

En **Tunnels** → tu tunnel → **Public Hostname**, añade:

| Subdominio | Servicio | URL |
|-----------|---------|-----|
| `@` (raíz) | HTTP | `nginx-load-balancer:80` |
| `www` | HTTP | `nginx-load-balancer:80` |

---

## Flujo de actualización (cuando cambias código)

```
Tu PC (Windows) → Build imagen → Push Docker Hub
                                        ↓
PC2: docker compose -f docker-compose.app.yml up -d --pull always
PC3: docker compose -f docker-compose.app.yml up -d --pull always
```

> Las migraciones se corren automáticamente en el arranque (script `start.sh`).

---

## Troubleshooting rápido

```bash
# Ver logs de cualquier contenedor:
docker logs <nombre-contenedor> -f --tail 50

# Reiniciar un contenedor específico:
docker restart <nombre-contenedor>

# Ver el estado de todos los contenedores:
docker ps

# Entrar al shell de la app:
docker exec -it laravel-app sh

# Ver logs de Nginx LB:
docker exec nginx-load-balancer tail -f /var/log/nginx/access.log
```

---

## Checklist final

- [ ] PC4 levantada y MySQL/Redis responden
- [ ] PC2 responde en `http://192.168.1.102:8080/health-check`
- [ ] PC3 responde en `http://192.168.1.103:8080/health-check`
- [ ] PC1 responde en `http://192.168.1.101/health-check`
- [ ] Cloudflare Tunnel activo y verde en el dashboard
- [ ] Dominio resuelve correctamente a la app
- [ ] Login de administrador funciona (`22610282@utgz.edu.mx`)
