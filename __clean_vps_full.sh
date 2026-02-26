#!/bin/bash
# =============================================================
# LIMPIEZA TOTAL DEL VPS - LUCHA CONTRA MALWARE
# Ejecutar como: bash /tmp/clean_vps_full.sh
# =============================================================

RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m'

log() { echo -e "${GREEN}[OK]${NC} $1"; }
warn() { echo -e "${YELLOW}[!!]${NC} $1"; }
err()  { echo -e "${RED}[ERR]${NC} $1"; }

DIR="/home/letimport/public_html/ServicioTecnico"
USER="letimport"

echo "=============================================="
echo "  LIMPIEZA TOTAL VPS - $(date '+%Y-%m-%d %H:%M')"
echo "=============================================="

# ============================================================
# PASO 1: ELIMINAR CRON JOBS MALICIOSOS
# ============================================================
echo ""
echo ">>> PASO 1: Eliminar cron jobs maliciosos..."

# Mostrar crons actuales
echo "Crons root actuales:"
crontab -l 2>/dev/null || echo "  (ninguno)"

echo "Crons letimport actuales:"
crontab -l -u letimport 2>/dev/null || echo "  (ninguno)"

# Eliminar crons que contengan patrones maliciosos
for cronuser in root letimport; do
    CRON=$(crontab -l -u "$cronuser" 2>/dev/null)
    if echo "$CRON" | grep -qiE "curl|wget|base64|eval|python|perl|bash.*http|/tmp/|/dev/shm"; then
        warn "Cron malicioso detectado en usuario $cronuser — eliminando..."
        crontab -l -u "$cronuser" 2>/dev/null | grep -vE "curl|wget|base64|eval|python|perl|bash.*http|/tmp/|/dev/shm" | crontab -u "$cronuser" -
        log "Cron limpiado para $cronuser"
    else
        log "Cron de $cronuser: limpio"
    fi
done

# ============================================================
# PASO 2: LIMPIAR ARCHIVOS EN /tmp Y /dev/shm
# ============================================================
echo ""
echo ">>> PASO 2: Limpiar directorios temporales..."
find /tmp -name "*.php" -delete -print 2>/dev/null
find /tmp -name "*.sh" -newer /tmp -mtime -7 -delete -print 2>/dev/null
find /dev/shm -type f -delete -print 2>/dev/null
log "Directorios temporales limpiados"

# ============================================================
# PASO 3: DETECTAR Y ELIMINAR TODO EL MALWARE PHP
# ============================================================
echo ""
echo ">>> PASO 3: Escaneando malware en todo /home/letimport..."

# Patrones de malware conocidos
PATTERNS='secretyt\|goto tUl6b\|goto axNgD\|linuxploit\|yon3zu\|No_Identity\|wWifV\|eval(base64_decode\|str_rot13.*goto\|preg_replace.*\/e\|assert.*base64\|FilesMan\|c99shell\|r57shell\|phpspy\|webshell'

INFECTED_COUNT=$(grep -rl "$PATTERNS" /home/letimport --include='*.php' 2>/dev/null | wc -l)
warn "Archivos PHP infectados encontrados: $INFECTED_COUNT"

if [ "$INFECTED_COUNT" -gt "0" ]; then
    # Guardar lista de infectados
    grep -rl "$PATTERNS" /home/letimport --include='*.php' 2>/dev/null > /tmp/infected_list.txt
    
    echo "Archivos infectados:"
    cat /tmp/infected_list.txt | head -20
    
    # Eliminar archivos que son PURO malware (no son archivos del proyecto)
    PURE_MALWARE='wp-log1n\.php$\|wp-cron\.php$\|wp-blog-header\.php$\|plugins\.php$\|item\.php$\|click\.php$\|defaults\.php$\|xmlrpc\.php$'
    
    grep -rl "$PATTERNS" /home/letimport --include='*.php' 2>/dev/null | grep -E "$PURE_MALWARE" | while read f; do
        rm -f "$f"
        warn "Eliminado: $f"
    done
    
    # Para archivos del proyecto (vendor, etc.) que fueron infectados — limpiar inyeccion
    # Los archivos del vendor infectados se restauraran con composer install
    grep -rl "$PATTERNS" /home/letimport/public_html/ServicioTecnico/vendor --include='*.php' 2>/dev/null | head -5
    if grep -rl "$PATTERNS" /home/letimport/public_html/ServicioTecnico/vendor --include='*.php' 2>/dev/null | grep -q .; then
        warn "Vendor infectado detectado — eliminando vendor/ para reinstalar limpio"
        rm -rf /home/letimport/public_html/ServicioTecnico/vendor/
        log "vendor/ eliminado para reinstalacion limpia"
    fi
fi

# ============================================================
# PASO 4: LIMPIAR CARPETAS HEX SOSPECHOSAS
# ============================================================
echo ""
echo ">>> PASO 4: Eliminar carpetas maliciosas..."
find /home/letimport/public_html -maxdepth 4 -type d -regextype posix-extended -regex '.*/[0-9a-f]{5,8}$' -exec rm -rf {} + 2>/dev/null || true
find /home/letimport/public_html -name "*.php.bak" -delete 2>/dev/null
find /home/letimport/public_html -name "*.php~" -delete 2>/dev/null
log "Carpetas y archivos maliciosos eliminados"

# ============================================================
# PASO 5: RESTAURAR SERVICIO TECNICO DESDE GITHUB (LIMPIO)
# ============================================================
echo ""
echo ">>> PASO 5: Restaurar codigo limpio de GitHub..."
git config --global --add safe.directory "$DIR" 2>/dev/null || true
cd "$DIR"
git remote remove origin 2>/dev/null || true
git remote add origin https://github.com/cibertronia/servicio-tecnico.git
git fetch origin main 2>&1
git reset --hard origin/main 2>&1
log "Codigo restaurado desde GitHub"
git log --oneline -2

# ============================================================
# PASO 6: INSTALAR DEPENDENCIAS CON COMPOSER
# ============================================================
echo ""
echo ">>> PASO 6: Instalando dependencias PHP (composer)..."
cd "$DIR"
if [ ! -f vendor/autoload.php ]; then
    COMPOSER_BIN=$(which composer 2>/dev/null || echo "/usr/local/bin/composer")
    if [ -f "$COMPOSER_BIN" ]; then
        $COMPOSER_BIN install --no-dev --no-interaction --optimize-autoloader 2>&1 | tail -10
        log "Composer install completado"
    else
        warn "Composer no encontrado — buscando alternativa..."
        php -d allow_url_fopen=On -r "copy('https://getcomposer.org/installer', '/tmp/composer-setup.php');" 2>/dev/null
        php /tmp/composer-setup.php --install-dir=/usr/local/bin --filename=composer 2>/dev/null
        /usr/local/bin/composer install --no-dev --no-interaction 2>&1 | tail -10
    fi
else
    log "vendor/autoload.php ya existe"
fi

# ============================================================
# PASO 7: CREAR CARPETA TEMP Y FIJAR PERMISOS
# ============================================================
echo ""
echo ">>> PASO 7: Corrigiendo permisos..."
chown -R "$USER:$USER" "$DIR"
find "$DIR" -type f -name "*.php" -exec chmod 644 {} \;
find "$DIR" -type d -exec chmod 755 {} \;
chmod 755 "$DIR"
mkdir -p "$DIR/temp"
chmod 777 "$DIR/temp"
chown "$USER:$USER" "$DIR/temp"
log "Permisos corregidos"

# Asegurar que el vendor es de letimport
if [ -d "$DIR/vendor" ]; then
    chown -R "$USER:$USER" "$DIR/vendor"
fi

# ============================================================
# VERIFICACION FINAL
# ============================================================
echo ""
echo "=============================================="
echo "VERIFICACION FINAL"
echo "=============================================="

REMAINING=$(grep -rl "$PATTERNS" /home/letimport/public_html/ServicioTecnico --include='*.php' 2>/dev/null | grep -v "/vendor/" | wc -l)
echo "Archivos maliciosos restantes (sin vendor): $REMAINING"

echo "Propietario index.php: $(stat -c '%U:%G %a' $DIR/index.php 2>/dev/null)"
echo "Escribible temp/: $([ -w $DIR/temp ] && echo 'SI' || echo 'NO')"
echo "vendor/autoload.php: $([ -f $DIR/vendor/autoload.php ] && echo 'EXISTE' || echo 'FALTA')"
echo "_permissions.php: $([ -f $DIR/_permissions.php ] && echo 'EXISTE' || echo 'FALTA')"

# Test PHP
PHPTEST=$(php -r "error_reporting(0); chdir('$DIR'); require_once 'init.php'; echo 'OK';" 2>&1)
echo "Test PHP: $PHPTEST"

if [ "$REMAINING" = "0" ] && [ -f "$DIR/vendor/autoload.php" ]; then
    echo ""
    echo "=============================================="
    log "SERVIDOR LIMPIO Y OPERATIVO"
    echo "=============================================="
else
    echo ""
    warn "Hay elementos pendientes de revisar"
fi
