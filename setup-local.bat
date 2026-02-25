@echo off
REM Local setup script for Laragon
set "DB_NAME=servicio-tecnico"
set "SQL_FILE=C:\laragon\www\letimport_servicioTecnico.sql"
echo Importando base "%DB_NAME%" desde "%SQL_FILE%"
mysql -u root "%DB_NAME%" < "%SQL_FILE%"
if %ERRORLEVEL% EQU 0 (
  echo Import exitoso.
) else (
  echo Error durante import.
)
pause
