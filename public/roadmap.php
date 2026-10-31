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

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['item_id'])) {
    $status = $_POST['status'] ?? 'pending';
    $roadmapModel->markItemStatus((int) $_POST['item_id'], (int) $user['id'], $status);
    redirect('/baliready-ai/public/roadmap.php');
}

$roadmap = $roadmapModel->getLatestRoadmap((int) $user['id']);
$progress = $roadmap ? $roadmapModel->getProgress((int) $roadmap['id']) : ['total' => 0, 'completed' => 0, 'percent' => 0];

include __DIR__ . '/../views/roadmap/index.php';
