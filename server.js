require('dotenv').config();
const express = require('express');
const fs = require('fs');
const path = require('path');
const crypto = require('crypto');
const nodemailer = require('nodemailer');

const app = express();
const PORT = process.env.PORT || 3000;
const DATA_FILE = path.join(__dirname, 'data', 'leads.json');

app.use(express.json({ limit: '100kb' }));
app.use(express.urlencoded({ extended: true, limit: '100kb' }));

// ---------- Storage (simple JSON file CMS) ----------
function readLeads() {
  try {
    return JSON.parse(fs.readFileSync(DATA_FILE, 'utf8'));
  } catch {
    return [];
  }
}

function writeLeads(leads) {
  fs.mkdirSync(path.dirname(DATA_FILE), { recursive: true });
  const tmp = DATA_FILE + '.tmp';
  fs.writeFileSync(tmp, JSON.stringify(leads, null, 2));
  fs.renameSync(tmp, DATA_FILE);
}

// ---------- Email ----------
const mailer = process.env.SMTP_HOST
  ? nodemailer.createTransport({
      host: process.env.SMTP_HOST,
      port: Number(process.env.SMTP_PORT || 465),
      secure: String(process.env.SMTP_SECURE || 'true') === 'true',
      auth: { user: process.env.SMTP_USER, pass: process.env.SMTP_PASS },
    })
  : null;

function escapeHtml(s) {
  return String(s ?? '').replace(/[&<>"']/g, (c) => ({
    '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;',
  }[c]));
}

async function sendEmails(lead) {
  if (!mailer) {
    console.warn('SMTP not configured - skipping emails for', lead.email);
    return false;
  }
  const from = process.env.MAIL_FROM || process.env.SMTP_USER;

  await mailer.sendMail({
    from,
    to: lead.email,
    subject: 'Thank you for contacting Guest2Kart - We will contact you soon',
    html: `
      <div style="font-family:Arial,sans-serif;max-width:560px;margin:auto;color:#1f2937">
        <h2 style="color:#4f46e5">Hi ${escapeHtml(lead.name)},</h2>
        <p>Thank you for reaching out to <b>Guest2Kart</b>!</p>
        <p>We have received your request for <b>${escapeHtml(lead.service)}</b>.
           Our team will review it and <b>we will contact you soon</b>.</p>
        <p>Regards,<br/>Team Guest2Kart</p>
      </div>`,
  });

  if (process.env.ADMIN_NOTIFY_EMAIL) {
    await mailer.sendMail({
      from,
      to: process.env.ADMIN_NOTIFY_EMAIL,
      replyTo: lead.email,
      subject: `New lead: ${lead.name} (${lead.service})`,
      html: Object.entries(lead)
        .map(([k, v]) => `<p><b>${escapeHtml(k)}:</b> ${escapeHtml(v)}</p>`)
        .join(''),
    });
  }
  return true;
}

// ---------- Public API ----------
const EMAIL_RE = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

app.post('/api/leads', async (req, res) => {
  const b = req.body || {};
  if (b.company_website_hp) return res.json({ ok: true }); // honeypot (bots)

  const clip = (v, n = 500) => String(v || '').trim().slice(0, n);
  const lead = {
    id: crypto.randomUUID(),
    name: clip(b.name, 100),
    email: clip(b.email, 150).toLowerCase(),
    phone: clip(b.phone, 30),
    website: clip(b.website, 200),
    service: clip(b.service, 50) || 'Guest Post',
    budget: clip(b.budget, 50),
    message: clip(b.message, 2000),
    status: 'new',
    createdAt: new Date().toISOString(),
  };

  if (!lead.name || !EMAIL_RE.test(lead.email)) {
    return res.status(400).json({ ok: false, error: 'Please enter a valid name and email.' });
  }

  const leads = readLeads();
  leads.unshift(lead);
  writeLeads(leads);

  let emailSent = false;
  try {
    emailSent = await sendEmails(lead);
  } catch (err) {
    console.error('Email error:', err.message);
  }
  lead.emailSent = emailSent;
  writeLeads(leads);

  res.json({ ok: true, message: 'Thank you! We will contact you soon.' });
});

// ---------- Admin (CMS) with Basic Auth ----------
function adminAuth(req, res, next) {
  const user = process.env.ADMIN_USER || 'admin';
  const pass = process.env.ADMIN_PASS;
  if (!pass) return res.status(500).send('Set ADMIN_PASS in .env to use the admin panel.');
  const [type, token] = (req.headers.authorization || '').split(' ');
  if (type === 'Basic' && token) {
    const [u, ...p] = Buffer.from(token, 'base64').toString().split(':');
    if (u === user && p.join(':') === pass) return next();
  }
  res.set('WWW-Authenticate', 'Basic realm="Guest2Kart Admin"');
  res.status(401).send('Authentication required');
}

app.get('/admin', adminAuth, (req, res) => res.sendFile(path.join(__dirname, 'admin', 'index.html')));
app.get('/api/admin/leads', adminAuth, (req, res) => res.json(readLeads()));

app.patch('/api/admin/leads/:id', adminAuth, (req, res) => {
  const leads = readLeads();
  const lead = leads.find((l) => l.id === req.params.id);
  if (!lead) return res.status(404).json({ ok: false });
  if (['new', 'contacted', 'converted', 'closed'].includes(req.body.status)) lead.status = req.body.status;
  if (typeof req.body.note === 'string') lead.note = req.body.note.slice(0, 2000);
  writeLeads(leads);
  res.json({ ok: true, lead });
});

app.delete('/api/admin/leads/:id', adminAuth, (req, res) => {
  writeLeads(readLeads().filter((l) => l.id !== req.params.id));
  res.json({ ok: true });
});

app.get('/api/admin/leads.csv', adminAuth, (req, res) => {
  const cols = ['createdAt', 'name', 'email', 'phone', 'website', 'service', 'budget', 'message', 'status', 'note'];
  const q = (v) => `"${String(v ?? '').replace(/"/g, '""')}"`;
  const csv = [cols.join(','), ...readLeads().map((l) => cols.map((c) => q(l[c])).join(','))].join('\n');
  res.set('Content-Type', 'text/csv').attachment('guest2kart-leads.csv').send(csv);
});

app.use(express.static(path.join(__dirname, 'public')));

app.listen(PORT, () => console.log(`Guest2Kart running at http://localhost:${PORT}`));
