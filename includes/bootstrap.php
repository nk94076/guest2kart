<?php
declare(strict_types=1);

$configFile = __DIR__ . '/../config.php';
if (!file_exists($configFile)) {
    $configFile = __DIR__ . '/../config.sample.php';
}
$config = require $configFile;

function db(): PDO
{
    static $pdo = null;
    if ($pdo === null) {
        $dir = $GLOBALS['config']['data_dir'] ?? (__DIR__ . '/../data');
        if (!is_dir($dir)) {
            mkdir($dir, 0775, true);
        }
        $pdo = new PDO('sqlite:' . $dir . '/leads.sqlite');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        $pdo->exec('CREATE TABLE IF NOT EXISTS leads (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name TEXT NOT NULL,
            email TEXT NOT NULL,
            phone TEXT,
            website TEXT,
            service TEXT,
            budget TEXT,
            message TEXT,
            status TEXT NOT NULL DEFAULT "new",
            note TEXT,
            email_sent INTEGER NOT NULL DEFAULT 0,
            ip TEXT,
            created_at TEXT NOT NULL
        )');
    }
    return $pdo;
}

function e(?string $s): string
{
    return htmlspecialchars((string) $s, ENT_QUOTES, 'UTF-8');
}

function clip($v, int $n): string
{
    return mb_substr(trim((string) $v), 0, $n);
}
