# Guest2Kart

One-page website (PHP + HTML + Tailwind CSS) for selling guest posts & banner ads on Google-approved, 100K+ traffic websites.

## Features
- One-page landing site: Hero, Services, How it Works, Pricing, Why Us, FAQ, Contact form
- Contact form → every lead is saved in the built-in **CMS** (`/admin/`, SQLite database)
- Auto email to the person who filled the form: *"Thank you… we will contact you soon"* (PHPMailer + SMTP)
- Optional copy of every new lead to your own email
- Admin panel: login, search, filter, status (new / contacted / converted / closed), notes, delete, CSV export
- Spam protection: honeypot field + max 5 submissions per IP per hour

## Files
| File | Purpose |
|---|---|
| `index.php` | Landing page |
| `submit.php` | Form handler (save + email) |
| `admin/index.php` | Leads CMS |
| `includes/` | DB + mail helpers |
| `config.sample.php` | Copy to `config.php` and fill in admin password + SMTP |
| `deploy/setup.sh` | One-command VPS setup (nginx + PHP-FPM + SSL) |

## Deploy on VPS (Ubuntu)
Open the VPS **Web console** (or `ssh root@<server-ip>`) and run:
```bash
curl -fsSL https://raw.githubusercontent.com/nk94076/guest2kart/main/deploy/setup.sh | bash
```
Then add SMTP details in `/var/www/guest2kart/config.php`. Re-run the same command any time to update to the latest code.

### Email (Gmail example)
1. Turn on 2-Step Verification in your Google account.
2. Create an **App Password** (Google Account → Security → App passwords).
3. Put your Gmail in `smtp_user` / `mail_from` and the app password in `smtp_pass`.

## Local development
```bash
composer install
cp config.sample.php config.php   # set admin_pass
php -S localhost:8000
```
