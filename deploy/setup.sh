#!/usr/bin/env bash
# One-time setup of Guest2Kart on an Ubuntu VPS (run as root).
# Usage: bash setup.sh            (re-run any time to update to the latest code)
set -euo pipefail

DOMAIN="guest2kart.com"
APP_DIR="/var/www/guest2kart"
REPO="https://github.com/nk94076/guest2kart.git"
PORT=3100

echo "==> Installing packages"
apt-get update -y
apt-get install -y curl git nginx certbot python3-certbot-nginx
if ! command -v node >/dev/null || [ "$(node -v | cut -d. -f1 | tr -d v)" -lt 18 ]; then
  curl -fsSL https://deb.nodesource.com/setup_20.x | bash -
  apt-get install -y nodejs
fi
command -v pm2 >/dev/null || npm install -g pm2

echo "==> Fetching code"
if [ -d "$APP_DIR/.git" ]; then
  git -C "$APP_DIR" pull --ff-only
else
  git clone "$REPO" "$APP_DIR"
fi
cd "$APP_DIR"
npm install --omit=dev

if [ ! -f .env ]; then
  cp .env.example .env
  sed -i "s/^PORT=.*/PORT=$PORT/" .env
  PASS=$(openssl rand -base64 12 | tr -d '/+=')
  sed -i "s/^ADMIN_PASS=.*/ADMIN_PASS=$PASS/" .env
  echo "==> Created .env  (admin password: $PASS  - edit SMTP settings in $APP_DIR/.env)"
fi

echo "==> Starting app with pm2"
pm2 startOrReload server.js --name guest2kart --update-env 2>/dev/null || pm2 start server.js --name guest2kart
pm2 save
pm2 startup systemd -u root --hp /root >/dev/null || true

echo "==> Configuring nginx"
cat > /etc/nginx/sites-available/guest2kart <<EOF
server {
    listen 80;
    server_name $DOMAIN www.$DOMAIN;
    client_max_body_size 1m;
    location / {
        proxy_pass http://127.0.0.1:$PORT;
        proxy_http_version 1.1;
        proxy_set_header Host \$host;
        proxy_set_header X-Real-IP \$remote_addr;
        proxy_set_header X-Forwarded-For \$proxy_add_x_forwarded_for;
        proxy_set_header X-Forwarded-Proto \$scheme;
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
echo "Done! Website: https://$DOMAIN   Admin: https://$DOMAIN/admin (user: admin)"
grep ^ADMIN_PASS .env
