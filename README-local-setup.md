Guía rápida para levantar el proyecto localmente con Laragon
- Requisitos: Laragon instalado, base de datos servicio-tecnico creada
- Pasos:
  1) Asegura que Laragon está corriendo con MySQL y Apache.
  2) Copia el proyecto al directorio C:\laragon\www\servicio-tecnico (si no está ya).
  3) Importa la base desde C:\laragon\www\letimport_servicioTecnico.sql usando setup-local.bat.
  4) Verifica que el archivo .env tenga DB_NAME=servicio-tecnico y DB_HOST=localhost.
  5) Abre http://localhost/servicio-tecnico en tu navegador.
