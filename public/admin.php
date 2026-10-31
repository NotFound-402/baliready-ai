<?php

require_once __DIR__ . '/../app/bootstrap.php';
if (!($pdo instanceof PDO)) {
    http_response_code(500);
    echo 'Database connection error.';
    exit;
}
require_admin();
ensure_demo_data($pdo);

$message = null;
$questionModel = new QuestionModel($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || !validate_csrf($_POST['csrf_token'])) {
        $message = 'Token CSRF tidak valid.';
    } elseif (isset($_POST['action']) && $_POST['action'] === 'add_question') {
        $questionId = $questionModel->createQuestion([
            'competency_id' => (int) ($_POST['competency_id'] ?? 1),
            'type' => $_POST['type'] ?? 'multiple_choice',
            'title' => $_POST['title'] ?? '',
            'question_text' => $_POST['question_text'] ?? '',
            'difficulty' => $_POST['difficulty'] ?? 'easy',
            'points' => (float) ($_POST['points'] ?? 1),
            'programming_language' => $_POST['programming_language'] ?? null,
            'starter_code' => $_POST['starter_code'] ?? null,
        ]);

        if ($questionId) {
            if (($_POST['type'] ?? 'multiple_choice') === 'multiple_choice') {
                foreach (['A', 'B', 'C', 'D'] as $label) {
                    if (!empty($_POST['option_' . strtolower($label)])) {
                        $isCorrect = isset($_POST['correct_option']) && $_POST['correct_option'] === $label;
                        $questionModel->addOption((int) $questionId, $label, $_POST['option_' . strtolower($label)], $isCorrect);
                    }
                }
            }

            $message = 'Pertanyaan berhasil ditambahkan.';
        } else {
            $message = 'Gagal menambahkan pertanyaan.';
        }
    } elseif (isset($_POST['action']) && $_POST['action'] === 'add_material') {
        $stmt = $pdo->prepare('INSERT INTO learning_materials (competency_id, title, description, material_type, url, difficulty, estimated_minutes) VALUES (:competency_id, :title, :description, :material_type, :url, :difficulty, :estimated_minutes)');
        $stmt->execute([
            'competency_id' => (int) ($_POST['competency_id'] ?? 1),
            'title' => $_POST['title'] ?? '',
            'description' => $_POST['description'] ?? '',
            'material_type' => $_POST['material_type'] ?? 'article',
            'url' => $_POST['url'] ?? '',
            'difficulty' => $_POST['difficulty'] ?? 'easy',
            'estimated_minutes' => (int) ($_POST['estimated_minutes'] ?? 30),
        ]);
        $message = 'Materi belajar berhasil ditambahkan.';
    }
}

$questions = $questionModel->getAllQuestions();
$materials = $pdo->query('SELECT lm.*, c.name AS competency_name FROM learning_materials lm JOIN competencies c ON c.id = lm.competency_id ORDER BY lm.id DESC')->fetchAll();
$competencies = $questionModel->getCompetencies();

include __DIR__ . '/../views/admin/index.php';
