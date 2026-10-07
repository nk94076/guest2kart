<?php
declare(strict_types=1);

require __DIR__ . '/includes/bootstrap.php';
require __DIR__ . '/includes/mailer.php';

header('Content-Type: application/json');

function respond(int $code, array $body): void
{
    http_response_code($code);
    echo json_encode($body);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    respond(405, ['ok' => false, 'error' => 'Method not allowed']);
}

$in = $_POST;
if (!empty($in['company_website_hp'])) { // honeypot (bots)
    respond(200, ['ok' => true]);
}

$lead = [
    'name'    => clip($in['name'] ?? '', 100),
    'email'   => strtolower(clip($in['email'] ?? '', 150)),
    'phone'   => clip($in['phone'] ?? '', 30),
    'website' => clip($in['website'] ?? '', 200),
    'service' => clip($in['service'] ?? '', 50) ?: 'Guest Post',
    'budget'  => clip($in['budget'] ?? '', 50),
    'message' => clip($in['message'] ?? '', 2000),
];

if ($lead['name'] === '' || !filter_var($lead['email'], FILTER_VALIDATE_EMAIL)) {
    respond(400, ['ok' => false, 'error' => 'Please enter a valid name and email.']);
}

$ip = $_SERVER['REMOTE_ADDR'] ?? '';

// Basic rate limit: max 5 submissions per IP per hour
$recent = db()->prepare("SELECT COUNT(*) FROM leads WHERE ip = ? AND created_at > datetime('now', '-1 hour')");
$recent->execute([$ip]);
if ((int) $recent->fetchColumn() >= 5) {
    respond(429, ['ok' => false, 'error' => 'Too many requests. Please try again later.']);
}

$stmt = db()->prepare("INSERT INTO leads (name, email, phone, website, service, budget, message, ip, created_at)
    VALUES (:name, :email, :phone, :website, :service, :budget, :message, :ip, datetime('now'))");
$stmt->execute($lead + ['ip' => $ip]);
$id = (int) db()->lastInsertId();

try {
    if (send_lead_emails($config, $lead)) {
        db()->prepare('UPDATE leads SET email_sent = 1 WHERE id = ?')->execute([$id]);
    }
} catch (Throwable $err) {
    error_log('Guest2Kart email error: ' . $err->getMessage());
}

respond(200, ['ok' => true, 'message' => 'Thank you! We will contact you soon.']);
