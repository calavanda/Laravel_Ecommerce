# Laravel - Proyecto de Práctica

Este es un proyecto basado en Laravel 12. A continuación se detallan los pasos necesarios para configurar, arrancar y verificar el correcto funcionamiento del proyecto en tu entorno local.

---

## 🛠️ Requisitos Previos

Asegúrate de tener instalado en tu sistema:
- **PHP** (versión 8.2 o superior)
- **Composer**
- **Node.js y NPM**
- **SQLite** (configurado por defecto) o **MySQL**
- *Opcional*: **Docker** (si prefieres usar Laravel Sail)

---

## 🚀 Guía de Inicio Rápido (Entorno Local)

Sigue estos pasos en tu terminal (PowerShell o Git Bash) dentro de la carpeta del proyecto:

### 1. Clonar/Abrir el proyecto e instalar dependencias

Instala las dependencias de PHP con Composer:
```bash
composer install
```

Instala las dependencias de JavaScript y CSS con NPM:
```bash
npm install
```

### 2. Configurar el archivo de entorno

Copia el archivo de ejemplo para crear tu archivo `.env`:
```bash
copy .env.example .env
```
*(Nota: En sistemas basados en Unix/Linux, usa `cp .env.example .env`)*

Por defecto, la base de datos está configurada para usar **SQLite** (creando un archivo local en `database/database.sqlite`), lo cual no requiere instalar o configurar un servidor de base de datos MySQL local.

Si deseas utilizar MySQL, edita el archivo `.env` y ajusta las siguientes variables con tus credenciales locales:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nombre_de_tu_base_de_datos
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_contraseña
```

### 3. Generar la clave de la aplicación

Genera la clave única de seguridad para la aplicación:
```bash
php artisan key:generate
```

### 4. Ejecutar las migraciones de la base de datos

Ejecuta las migraciones necesarias para crear las tablas en la base de datos:
```bash
php artisan migrate
```

### 5. Compilar los assets frontend

Compila los assets (JS, CSS/Tailwind CSS v4) con Vite para el entorno de producción, o inicia el servidor de desarrollo:
- **Para producción:**
  ```bash
  npm run build
  ```
- **Para desarrollo (con recarga en tiempo real):**
  ```bash
  npm run dev
  ```

### 6. Iniciar el servidor local

Arranca el servidor de desarrollo de Laravel:
```bash
php artisan serve
```

Una vez ejecutado, abre tu navegador e ingresa a: **[http://127.0.0.1:8000](http://127.0.0.1:8000)**

---

## 🐳 Alternativa con Docker (Laravel Sail)

Si prefieres usar Docker y Laravel Sail, puedes inicializar el proyecto levantando los contenedores:

1. Levantar el entorno de desarrollo:
   ```bash
   ./vendor/bin/sail up -d
   ```
2. Ejecutar las migraciones dentro del contenedor:
   ```bash
   ./vendor/bin/sail artisan migrate
   ```
3. Compilar y correr Vite:
   ```bash
   ./vendor/bin/sail npm run dev
   ```

---

## 🧪 Pruebas Automatizadas

Para validar que todo funcione correctamente y que la instalación sea exitosa, puedes ejecutar la suite de pruebas del proyecto:

```bash
php artisan test
```

