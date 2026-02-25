# 🔧 Servicio Técnico

Sistema administrativo para gestión de servicio técnico — desarrollado con PHP nativo y MariaDB.

## 🚀 Instalación Local (Laragon)

### Requisitos previos
- [Laragon](https://laragon.org/) con PHP 8.x y MariaDB
- Composer

### Pasos para instalar

1. **Clonar el repositorio** en la carpeta `www` de Laragon:
   ```bash
   git clone https://github.com/cibertronia/servicio-tecnico.git C:\laragon\www\servicio-tecnico
   ```

2. **Instalar dependencias de Composer:**
   ```bash
   cd C:\laragon\www\servicio-tecnico
   composer install
   ```

3. **Configurar el archivo `.env`:**
   ```bash
   cp .env.example .env
   ```
   Editar `.env` con tus datos locales:
   - `DB_NAME=servicio-tecnico`
   - `DB_USER=root`
   - `DB_PASSWORD=` *(vacío en Laragon por defecto)*
   - `ENVIRONMENT=dev`
   - `LOCAL_DEV=true`

4. **Crear la base de datos en phpMyAdmin:**
   - Abre `http://localhost/phpmyadmin`
   - Crea una base de datos llamada `servicio-tecnico`
   - Importa el archivo `letimport_servicioTecnico.sql`

5. **Acceder a la aplicación:**
   - Abre `http://servicio-tecnico.test` (si Laragon tiene el virtual host) o `http://localhost/servicio-tecnico`

## 📁 Estructura del Proyecto

```
servicio-tecnico/
├── .env                  # Variables de entorno (NO se sube al repo)
├── .env.example          # Plantilla de variables de entorno
├── config.php            # Configuración principal
├── index.php             # Punto de entrada
├── init.php              # Inicialización
├── includes/             # Componentes PHP reutilizables
├── templates/            # Plantillas HTML/PHP
├── assets/               # CSS, JS, imágenes
├── lib/                  # Librerías propias
├── vendor/               # Dependencias Composer (no se sube)
└── temp/                 # Archivos temporales (no se sube)
```

## ⚙️ Variables de Entorno

Ver `.env.example` para la lista completa de variables necesarias.

## 📄 Licencia

Proyecto privado — Todos los derechos reservados.
