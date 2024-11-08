#!/bin/bash

# Wczytanie zmiennych
source .env

# Kolory do logów
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m'

# Funkcje logowania
log() { echo -e "${BLUE}[$(date '+%Y-%m-%d %H:%M:%S')] $1${NC}"; }
error() { echo -e "${RED}[ERROR] $1${NC}"; exit 1; }
success() { echo -e "${GREEN}[SUCCESS] $1${NC}"; }
warning() { echo -e "${YELLOW}[WARNING] $1${NC}"; }

# Sprawdzenie i tworzenie katalogów
create_remote_dirs() {
    log "Tworzenie struktury katalogów na serwerze..."

    local ftp_commands=$(mktemp)
    cat > "$ftp_commands" << EOF
open $PLESK_HOST
user $FTP_USER $PLESK_FTP_PASSWORD
binary
cd $REMOTE_PATH
mkdir data
mkdir css
mkdir js
quit
EOF

    ftp -n < "$ftp_commands"
    rm -f "$ftp_commands"
    success "Struktura katalogów utworzona"
}

# Upload pliku z zachowaniem struktury katalogów
upload_file() {
    local file="$1"
    local rel_path="${file#$LOCAL_PATH/}"
    local remote_file="$REMOTE_PATH/$rel_path"
    local dir_path=$(dirname "$remote_file")

    log "Przesyłanie: $rel_path"

    # Konstruowanie URL
    local ftp_url="ftp://$FTP_USER:$PLESK_FTP_PASSWORD@$PLESK_HOST$remote_file"

    # Upload pliku
    if curl --connect-timeout 10 \
            --max-time 30 \
            --retry 3 \
            --retry-delay 5 \
            --retry-max-time 60 \
            --upload-file "$file" \
            --ftp-create-dirs \
            --insecure \
            --ftp-pasv \
            --progress-bar \
            "$ftp_url"; then

        # Ustawienie uprawnień
        local chmod_value="644"
        [[ -x "$file" ]] && chmod_value="755"

        ftp -n << EOF > /dev/null 2>&1
open $PLESK_HOST
user $FTP_USER $PLESK_FTP_PASSWORD
site chmod $chmod_value $remote_file
quit
EOF

        success "✓ $rel_path"
    else
        error "✗ Błąd podczas przesyłania: $rel_path"
    fi
}

# Synchronizacja całego katalogu
sync_directory() {
    log "Rozpoczynam synchronizację katalogu..."

    # Lista wszystkich plików
    local files=($(find "$LOCAL_PATH" -type f))
    local total=${#files[@]}
    local current=0

    log "Znaleziono $total plików do przesłania"

    # Tworzenie struktury katalogów
    create_remote_dirs

    # Przesyłanie plików
    for file in "${files[@]}"; do
        ((current++))
        echo -ne "\rPostęp: [$current/$total] $(($current * 100 / $total))%"
        upload_file "$file"
    done

    echo # Nowa linia po pasku postępu
}

# Weryfikacja konfiguracji
verify_config() {
    log "Weryfikacja konfiguracji..."

    # Sprawdzenie wymaganych zmiennych
    local required_vars=("PLESK_HOST" "FTP_USER" "PLESK_FTP_PASSWORD" "REMOTE_PATH" "LOCAL_PATH")
    local missing=()

    for var in "${required_vars[@]}"; do
        if [ -z "${!var}" ]; then
            missing+=("$var")
        fi
    done

    if [ ${#missing[@]} -ne 0 ]; then
        error "Brakujące zmienne: ${missing[*]}"
    fi

    # Sprawdzenie lokalnego katalogu
    if [ ! -d "$LOCAL_PATH" ]; then
        error "Katalog lokalny nie istnieje: $LOCAL_PATH"
    fi

    success "Konfiguracja poprawna"
}

# Tworzenie backupu
create_backup() {
    log "Tworzenie backupu na serwerze..."

    local timestamp=$(date +%Y%m%d_%H%M%S)
    local backup_dir="$REMOTE_PATH/backup_$timestamp"

    local ftp_commands=$(mktemp)
    cat > "$ftp_commands" << EOF
open $PLESK_HOST
user $FTP_USER $PLESK_FTP_PASSWORD
binary
rename $REMOTE_PATH $backup_dir
quit
EOF

    ftp -n < "$ftp_commands"
    rm -f "$ftp_commands"

    success "Backup utworzony: $backup_dir"
}

# Główna funkcja
main() {
    log "Rozpoczynam proces publikacji..."

    # Weryfikacja konfiguracji
    verify_config

    # Lista plików
    log "Pliki do przesłania:"
    find "$LOCAL_PATH" -type f -exec ls -lh {} \;

    # Backup
    if [ "$BACKUP_ENABLED" = "true" ]; then
        create_backup
    fi

    # Synchronizacja
    sync_directory

    success "Proces publikacji zakończony pomyślnie"
}

# Obsługa CTRL+C
trap 'echo -e "\n[WARNING] Przerwano działanie skryptu."; exit 1' INT

# Uruchomienie skryptu
main