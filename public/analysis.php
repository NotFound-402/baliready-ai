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
$assessmentController = new AssessmentController($pdo);
$summary = $assessmentController->dashboardSummary((int) $user['id']);
$sessionId = isset($summary['lastSession']['id']) ? (int) $summary['lastSession']['id'] : 0;
$analysis = $sessionId ? (new AIController($pdo))->getAnalysisForSession($sessionId) : null;

include __DIR__ . '/../views/analysis/index.php';
