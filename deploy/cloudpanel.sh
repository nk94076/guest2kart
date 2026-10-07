#!/usr/bin/env bash
# Deploy / update Guest2Kart on a CloudPanel VPS (run as root).
# First create the site in CloudPanel: Sites -> Add Site -> Create a PHP Site.
# Usage: bash cloudpanel.sh <site-user> [domain]
set -euo pipefail

SITE_USER="${1:?Usage: bash cloudpanel.sh <site-user> [domain]}"
DOMAIN="${2:-guest2kart.com}"
HOME_DIR="/home/$SITE_USER"
ROOT="$HOME_DIR/htdocs/$DOMAIN"
DATA_DIR="$HOME_DIR/guest2kart-data"
REPO="https://github.com/nk94076/guest2kart.git"

[ -d "$HOME_DIR/htdocs" ] || { echo "!! $HOME_DIR/htdocs not found - create the PHP site in CloudPanel first"; exit 1; }

if [ -d "$ROOT/.git" ]; then
  echo "==> Updating code"
  git -c safe.directory="$ROOT" -C "$ROOT" pull --ff-only
else
  echo "==> Installing code"
  if [ -d "$ROOT" ] && [ -n "$(ls -A "$ROOT")" ]; then
    mv "$ROOT" "$ROOT.bak-$(date +%s)"
    echo "   (old files moved to $ROOT.bak-*)"
  fi
  rm -rf "$ROOT"
  git clone "$REPO" "$ROOT"
fi

cd "$ROOT"
if ! command -v composer >/dev/null; then
  curl -fsSL https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
fi
COMPOSER_ALLOW_SUPERUSER=1 composer install --no-dev --no-interaction --optimize-autoloader

mkdir -p "$DATA_DIR"
if [ ! -f config.php ]; then
  cp config.sample.php config.php
  PASS=$(openssl rand -base64 12 | tr -d '/+=')
  sed -i "s/'change-this-password'/'$PASS'/" config.php
  sed -i "s#'data_dir' => __DIR__ . '/data'#'data_dir' => '$DATA_DIR'#" config.php
  echo "==> Created config.php - admin password: $PASS"
fi
chown -R "$SITE_USER:$SITE_USER" "$ROOT" "$DATA_DIR"
chmod 600 config.php

echo
echo "Done! https://$DOMAIN   Admin: https://$DOMAIN/admin/  (user: admin)"
grep "'admin_pass'" config.php
