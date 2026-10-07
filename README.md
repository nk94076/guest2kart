# Guest2Kart

One-page website for selling guest posts & banner ads on Google-approved, 100K+ traffic websites.

## Features
- One-page landing site (Hero, Services, How it Works, Pricing, Why Us, FAQ, Contact form)
- Contact form → every lead is saved in the built-in **CMS** (`/admin`)
- Auto email to the person who filled the form: *"Thank you… we will contact you soon"*
- Optional copy of every new lead to your own email
- Admin panel: search, filter, change status (new / contacted / converted / closed), notes, delete, CSV export

## Setup
```bash
npm install
cp .env.example .env   # fill in ADMIN_PASS and SMTP details
npm start
```
- Website: http://localhost:3000
- Admin (CMS): http://localhost:3000/admin (login with ADMIN_USER / ADMIN_PASS)

### Email (Gmail example)
1. Turn on 2-Step Verification in your Google account.
2. Create an **App Password** (Google Account → Security → App passwords).
3. Put your Gmail in `SMTP_USER` and the app password in `SMTP_PASS`.

Leads are stored in `data/leads.json`. Host on any Node.js server (VPS, Render, Railway, Hostinger Node hosting, etc.) with a persistent disk.
