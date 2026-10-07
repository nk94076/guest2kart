<?php
// Copy this file to config.php and fill in your details.
return [
    // Admin panel (CMS) login - /admin
    'admin_user' => 'admin',
    'admin_pass' => 'change-this-password',

    // SMTP settings (example: Gmail with App Password)
    'smtp_host'   => 'smtp.gmail.com',
    'smtp_port'   => 465,
    'smtp_secure' => 'ssl',            // 'ssl' for 465, 'tls' for 587
    'smtp_user'   => 'your-email@gmail.com',
    'smtp_pass'   => 'your-app-password',
    'mail_from'   => 'your-email@gmail.com',
    'mail_from_name' => 'Guest2Kart',

    // Optional: you also get a copy of every new lead here ('' to disable)
    'admin_notify_email' => 'your-email@gmail.com',
];
