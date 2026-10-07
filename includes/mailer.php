<?php
declare(strict_types=1);

use PHPMailer\PHPMailer\PHPMailer;

require_once __DIR__ . '/../vendor/autoload.php';

function send_mail(array $config, string $to, string $subject, string $html, ?string $replyTo = null): void
{
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = $config['smtp_host'];
    $mail->Port = (int) $config['smtp_port'];
    $mail->SMTPAuth = true;
    $mail->Username = $config['smtp_user'];
    $mail->Password = $config['smtp_pass'];
    $mail->SMTPSecure = $config['smtp_secure'] === 'tls' ? PHPMailer::ENCRYPTION_STARTTLS : PHPMailer::ENCRYPTION_SMTPS;
    $mail->CharSet = 'UTF-8';
    $mail->setFrom($config['mail_from'], $config['mail_from_name']);
    $mail->addAddress($to);
    if ($replyTo) {
        $mail->addReplyTo($replyTo);
    }
    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->Body = $html;
    $mail->AltBody = trim(strip_tags(str_replace(['<br/>', '</p>'], "\n", $html)));
    $mail->send();
}

function send_lead_emails(array $config, array $lead): bool
{
    if (empty($config['smtp_host']) || empty($config['smtp_pass']) || $config['smtp_pass'] === 'your-app-password') {
        error_log('Guest2Kart: SMTP not configured, skipping email to ' . $lead['email']);
        return false;
    }

    $html = '<div style="font-family:Arial,sans-serif;max-width:560px;margin:auto;color:#1f2937">'
        . '<h2 style="color:#4f46e5">Hi ' . e($lead['name']) . ',</h2>'
        . '<p>Thank you for reaching out to <b>Guest2Kart</b>!</p>'
        . '<p>We have received your request for <b>' . e($lead['service']) . '</b>. '
        . 'Our team will review it and <b>we will contact you soon</b>.</p>'
        . '<p>Regards,<br/>Team Guest2Kart<br/><a href="https://guest2kart.com">guest2kart.com</a></p></div>';
    send_mail($config, $lead['email'], 'Thank you for contacting Guest2Kart - We will contact you soon', $html);

    if (!empty($config['admin_notify_email'])) {
        $rows = '';
        foreach (['name', 'email', 'phone', 'website', 'service', 'budget', 'message'] as $k) {
            $rows .= '<p><b>' . ucfirst($k) . ':</b> ' . nl2br(e($lead[$k])) . '</p>';
        }
        send_mail($config, $config['admin_notify_email'], 'New lead: ' . $lead['name'] . ' (' . $lead['service'] . ')', $rows, $lead['email']);
    }
    return true;
}
