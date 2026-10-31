<?php

require_once __DIR__ . '/../app/bootstrap.php';
if (!($pdo instanceof PDO)) {
    http_response_code(500);
    echo 'Database connection error.';
    exit;
}
require_login();
ensure_demo_data($pdo);

$user = current_user();
$controller = new AssessmentController($pdo);
$summary = $controller->dashboardSummary((int) $user['id']);
$scoreRows = $summary['scores'] ?? [];
$averageScore = 0;

if (!empty($scoreRows)) {
    $sum = 0;
    foreach ($scoreRows as $score) {
        $sum += (float) ($score['final_score'] ?? 0);
    }
    $averageScore = round($sum / count($scoreRows), 1);
}

include __DIR__ . '/../views/dashboard/index.php';
