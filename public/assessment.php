<?php

require_once __DIR__ . '/../app/bootstrap.php';
if (!($pdo instanceof PDO)) {
    http_response_code(500);
    echo 'Database connection error.';
    exit;
}
require_login();
ensure_demo_data($pdo);

$controller = new AssessmentController($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_assessment'])) {
    $result = $controller->submit($_POST, (int) current_user()['id']);

    if ($result['success']) {
        redirect('result.php?session_id=' . (int) $result['session_id']);
    }

    $errorMessage = $result['message'];
}

$data = $controller->index();
include __DIR__ . '/../views/assessment/index.php';
