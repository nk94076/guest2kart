# Guest2Kart

One-page website (PHP + HTML + Tailwind CSS) for selling guest posts & banner ads on Google-approved, 100K+ traffic websites.

## Features
- One-page landing site: Hero, Services, How it Works, Pricing, Why Us, FAQ, Contact form
- Contact form → every lead is saved in the built-in **CMS** (`/admin/`, SQLite database)
- Auto email to the person who filled the form: *"Thank you… we will contact you soon"* (PHPMailer + SMTP)
- Optional copy of every new lead to your own email
- **Website Content editor** (`/admin/content.php`, like WordPress): logo, favicon, colours, every heading/text, services, steps, pricing plans, FAQ, testimonial, form options, footer/WhatsApp, SEO, auto-email text; show/hide each section
- Admin panel: login, search, filter, status (new / contacted / converted / closed), notes, delete, CSV export
- Spam protection: honeypot field + max 5 submissions per IP per hour

## Files
| File | Purpose |
|---|---|
| `index.php` | Landing page |
| `submit.php` | Form handler (save + email) |
| `admin/index.php` | Leads CMS |
| `admin/content.php` | Website content editor |
| `includes/content.php` | Default website content |
| `includes/` | DB + mail helpers |
| `config.sample.php` | Copy to `config.php` and fill in admin password + SMTP |
| `deploy/cloudpanel.sh` | One-command deploy/update on CloudPanel VPS |

## Deploy on CloudPanel VPS
1. CloudPanel (`https://<server-ip>:8443`) → **Sites → Add Site → Create a PHP Site** → domain `guest2kart.com`, PHP 8.x, note the **Site User**.
2. In the site → **SSL/TLS → Actions → New Let's Encrypt Certificate**.
3. In the VPS console (as root):
```bash
curl -fsSL https://raw.githubusercontent.com/nk94076/guest2kart/main/deploy/cloudpanel.sh | bash -s -- <site-user>
```
4. Add SMTP details in `/home/<site-user>/htdocs/guest2kart.com/config.php`.

Re-run step 3 any time to update. Leads DB lives in `/home/<site-user>/guest2kart-data/` (outside the web root).

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
