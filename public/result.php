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
$sessionId = isset($_GET['session_id']) ? (int) $_GET['session_id'] : 0;

if ($sessionId === 0) {
    $latest = $controller->getLatestCompletedSession((int) $user['id']);
    $sessionId = $latest ? (int) $latest['id'] : 0;
}

$scoreRows = $sessionId ? $controller->getSessionScores($sessionId) : [];
$analysis = $sessionId ? (new AIController($pdo))->getAnalysisForSession($sessionId) : null;

include __DIR__ . '/../views/assessment/result.php';
