# Guía de Acción para el Clúster

Hola! Para que no haya confusión, aquí te dejo los pasos divididos entre lo que haces en **TU COMPUTADORA ACTUAL (Windows)** y lo que debes hacer en las **5 MACS (Ubuntu Server)**.

---

## 💻 PARTE 1: En tu computadora actual (Windows)
Ahorita estás en la computadora donde programaste todo. Como las 5 Macs van a descargar el código desde internet, primero debes subir tus cambios a GitHub.

Abre la terminal aquí mismo en Windows y ejecuta:
1. `git add .`
2. `git commit -m "Listo para el clúster"`
3. `git push`

**¡Listo! Ya no tienes que hacer nada más en esta computadora de Windows.**

---

## 🖥️ PARTE 2: En las 5 Macs (Ubuntu Server)
Ahora sí, ve físicamente a las 5 computadoras Mac, enciéndelas y asegúrate de que estén conectadas al mismo WiFi o red. 

Sigue estos pasos en orden:

### PASO 1: Descubrir la IP de la Base de Datos
- Ve a la **PC 4** (El Archivero).
- Escribe `ip a` y anota su número de IP (ejemplo: 192.168.1.100). Las otras PCs la van a necesitar.

### PASO 2: Instalar la Base de Datos (Solo en PC 4)
- En la misma **PC 4**, ejecuta tu comando:
  `curl -sSL https://raw.githubusercontent.com/calavanda/Laravel_Ecommerce/main/setup-ubuntu.sh | sudo bash -s -- db`

### PASO 3: Instalar las Aplicaciones (En PC 2, PC 3 y PC 5)
Ve a cada una de estas tres computadoras y haz lo siguiente:
1. Ejecuta el comando:
   `curl -sSL https://raw.githubusercontent.com/calavanda/Laravel_Ecommerce/main/setup-ubuntu.sh | sudo bash -s -- app`
2. Edita el archivo de configuración:
   `sudo nano /opt/eliteshop/.env`
3. Dentro del archivo, pon la IP de la PC 4 donde dice `DB_HOST=` y `REDIS_HOST=`.
4. Asegúrate de que las tres computadoras tengan el mismo código en `APP_KEY=`.
5. Guarda y reinicia con:
   `sudo systemctl restart eliteshop-app.service`

### PASO 4: Crear las tablas (Solo en PC 2)
- Ve a la **PC 2**.
- Ejecuta este comando para crear las tablas en la base de datos:
  `sudo docker exec -it laravel-app php artisan migrate --force`

### PASO 5: Instalar el Balanceador (Solo en PC 1)
- Ve a la **PC 1** (El Portero).
- Ejecuta el comando:
  `curl -sSL https://raw.githubusercontent.com/calavanda/Laravel_Ecommerce/main/setup-ubuntu.sh | sudo bash -s -- lb`

### PASO 6: Obtener el Link para compartir (Solo en PC 1)
- En la misma **PC 1**, escribe:
  `sudo docker logs ngrok-tunnel | grep url`
- Copia el enlace `https://...` que te salga. ¡Ese es el link que le puedes pasar a todos!
