
<?php

$envFile = dirname(__DIR__, 2) . '/.env';
$env = [];

if (file_exists($envFile)) {
    $env = parse_ini_file($envFile, true, INI_SCANNER_TYPED) ?: [];
    foreach ($env as $key => $value) {
        if (is_array($value)) {
            foreach ($value as $nestedKey => $nestedValue) {
                $_ENV[strtoupper($key . '_' . $nestedKey)] = $nestedValue;
            }
        } else {
            $_ENV[strtoupper($key)] = $value;
        }
    }
}

$host = getenv('DB_HOST') ?: ($_ENV['DB_HOST'] ?? 'localhost');
$dbname = getenv('DB_NAME') ?: ($_ENV['DB_NAME'] ?? 'baliready_ai');
$username = getenv('DB_USER') ?: ($_ENV['DB_USER'] ?? 'root');
$password = getenv('DB_PASS') ?: ($_ENV['DB_PASS'] ?? '');

$pdo = null;

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $username,
        $password,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]
    );
} catch (PDOException $exception) {
    error_log('Database connection failed: ' . $exception->getMessage());
    $pdo = null;
}
