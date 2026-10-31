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
$roadmapModel = new RoadmapModel($pdo);
$roadmap = $roadmapModel->getLatestRoadmap((int) $user['id']);
$progress = $roadmap ? $roadmapModel->getProgress((int) $roadmap['id']) : ['total' => 0, 'completed' => 0, 'percent' => 0];

include __DIR__ . '/../views/progress/index.php';
