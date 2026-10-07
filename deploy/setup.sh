#!/usr/bin/env bash
# One-time setup of Guest2Kart (PHP) on an Ubuntu VPS (run as root).
# Re-run any time to update to the latest code.
set -euo pipefail

DOMAIN="guest2kart.com"
APP_DIR="/var/www/guest2kart"
REPO="https://github.com/nk94076/guest2kart.git"

echo "==> Installing packages"
export DEBIAN_FRONTEND=noninteractive
apt-get update -y
apt-get install -y git unzip nginx php-fpm php-sqlite3 php-mbstring php-curl php-xml composer \
  certbot python3-certbot-nginx

PHP_SOCK=$(ls /run/php/php*-fpm.sock 2>/dev/null | head -1)
if [ -z "$PHP_SOCK" ]; then
  systemctl restart "$(systemctl list-unit-files 'php*-fpm.service' --no-legend | awk '{print $1}' | head -1)"
  PHP_SOCK=$(ls /run/php/php*-fpm.sock | head -1)
fi

echo "==> Fetching code"
if [ -d "$APP_DIR/.git" ]; then
  git -C "$APP_DIR" pull --ff-only
else
  git clone "$REPO" "$APP_DIR"
fi
cd "$APP_DIR"
COMPOSER_ALLOW_SUPERUSER=1 composer install --no-dev --no-interaction --optimize-autoloader

if [ ! -f config.php ]; then
  cp config.sample.php config.php
  PASS=$(openssl rand -base64 12 | tr -d '/+=')
  sed -i "s/'change-this-password'/'$PASS'/" config.php
  echo "==> Created config.php (admin password: $PASS) - add SMTP details in $APP_DIR/config.php"
fi
mkdir -p data
chown -R www-data:www-data data
chmod 640 config.php && chown root:www-data config.php

echo "==> Configuring nginx"
cat > /etc/nginx/sites-available/guest2kart <<EOF
server {
    listen 80;
    server_name $DOMAIN www.$DOMAIN;
    root $APP_DIR;
    index index.php;
    client_max_body_size 1m;

    location ~ ^/(data|includes|vendor|deploy)(/|\$) { deny all; return 404; }
    location ~ /(\.|config\.php|config\.sample\.php|composer\.) { deny all; return 404; }

    location / { try_files \$uri \$uri/ /index.php?\$query_string; }

    location ~ \.php\$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:$PHP_SOCK;
    }
}
EOF
ln -sf /etc/nginx/sites-available/guest2kart /etc/nginx/sites-enabled/guest2kart
rm -f /etc/nginx/sites-enabled/default
nginx -t && systemctl reload nginx

echo "==> SSL certificate"
certbot --nginx -d "$DOMAIN" -d "www.$DOMAIN" --non-interactive --agree-tos \
  --register-unsafely-without-email --redirect || echo "!! SSL failed - check DNS, then re-run this script"

echo
echo "Done! Website: https://$DOMAIN   Admin: https://$DOMAIN/admin/ (user: admin)"
grep "'admin_pass'" config.php
