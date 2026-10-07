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

    require_once __DIR__ . '/content.php';
    $tpl = content()['email'];
    $vars = ['{name}' => $lead['name'], '{service}' => $lead['service'], '{email}' => $lead['email']];
    $subject = strtr($tpl['subject'], $vars);
    $html = '<div style="font-family:Arial,sans-serif;max-width:560px;margin:auto;color:#1f2937;line-height:1.6">'
        . nl2br(e(strtr($tpl['body'], $vars))) . '</div>';
    send_mail($config, $lead['email'], $subject, $html);

    if (!empty($config['admin_notify_email'])) {
        $rows = '';
        foreach (['name', 'email', 'phone', 'website', 'service', 'budget', 'message'] as $k) {
            $rows .= '<p><b>' . ucfirst($k) . ':</b> ' . nl2br(e($lead[$k])) . '</p>';
        }
        send_mail($config, $config['admin_notify_email'], 'New lead: ' . $lead['name'] . ' (' . $lead['service'] . ')', $rows, $lead['email']);
    }
    return true;
}
