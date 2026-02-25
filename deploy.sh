#!/bin/bash
# =============================================================
# deploy.sh — Script de despliegue para VPS Contabo / cPanel
# Uso: bash deploy.sh
# Ejecutar desde: /home/letimport/public_html/ServicioTecnico
# =============================================================

DIR="/home/letimport/public_html/ServicioTecnico"
USER="letimport"
GROUP="letimport"

echo "========================================"
echo "  DEPLOY - Sistema Servicio Tecnico"
echo "  $(date '+%Y-%m-%d %H:%M:%S')"
echo "========================================"

# 1. Obtener código limpio de GitHub
echo "[1/4] Actualizando desde GitHub..."
git config --global --add safe.directory "$DIR" 2>/dev/null || true
cd "$DIR"
git fetch origin main 2>&1
git reset --hard origin/main 2>&1
echo "      Codigo actualizado."

# 2. Corregir propietario de archivos
echo "[2/4] Corrigiendo propietario de archivos..."
chown -R "$USER:$GROUP" "$DIR"
echo "      Propietario: $USER:$GROUP"

# 3. Corregir permisos
echo "[3/4] Aplicando permisos correctos..."
find "$DIR" -type f -name "*.php" -exec chmod 644 {} \;
find "$DIR" -type d -exec chmod 755 {} \;
# Carpetas que necesitan escritura
chmod 775 "$DIR"
chmod -R 775 "$DIR/temp" 2>/dev/null || true
mkdir -p "$DIR/temp" && chmod 775 "$DIR/temp"
echo "      Permisos aplicados."

# 4. Verificacion final
echo "[4/4] Verificacion..."
MALOS=$(grep -rl 'secretyt\|goto tUl6b\|linuxploit\|yon3zu' "$DIR" --include='*.php' 2>/dev/null | wc -l)
echo "      Archivos maliciosos: $MALOS"
echo "      Propietario index.php: $(stat -c '%U:%G' $DIR/index.php)"
echo "      Escribible temp/: $([ -w $DIR/temp ] && echo 'SI' || echo 'NO')"
echo ""
echo "========================================"
echo "  DEPLOY COMPLETADO OK"
echo "========================================"
