<?php

session_start();

require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/config/ai.php';
require_once __DIR__ . '/helpers.php';

require_once __DIR__ . '/models/User.php';
require_once __DIR__ . '/models/Question.php';
require_once __DIR__ . '/models/Roadmap.php';

require_once __DIR__ . '/services/GeminiService.php';
require_once __DIR__ . '/services/RecommendationService.php';

require_once __DIR__ . '/controllers/AuthController.php';
require_once __DIR__ . '/controllers/AssessmentController.php';
require_once __DIR__ . '/controllers/AIController.php';

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
