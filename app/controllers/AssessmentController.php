
<?php

class AssessmentController
{
    private PDO $pdo;
    private QuestionModel $questionModel;
    private UserModel $userModel;
    private RoadmapModel $roadmapModel;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->questionModel = new QuestionModel($pdo);
        $this->userModel = new UserModel($pdo);
        $this->roadmapModel = new RoadmapModel($pdo);
    }

    public function index(): array
    {
        $questions = $this->questionModel->getAllQuestions();
        $optionsByQuestion = $this->questionModel->getOptionsByQuestion();
        $competencies = $this->questionModel->getCompetencies();

        return [
            'questions' => $questions,
            'optionsByQuestion' => $optionsByQuestion,
            'competencies' => $competencies,
        ];
    }

    public function dashboardSummary(int $userId): array
    {
        $lastSession = $this->getLatestCompletedSession($userId);
        $lastScores = [];
        $roadmap = $this->roadmapModel->getLatestRoadmap($userId);
        $progress = ['total' => 0, 'completed' => 0, 'percent' => 0];

        if ($lastSession) {
            $lastScores = $this->getSessionScores((int) $lastSession['id']);
        }

        if ($roadmap) {
            $progress = $this->roadmapModel->getProgress((int) $roadmap['id']);
        }

        return [
            'lastSession' => $lastSession,
            'scores' => $lastScores,
            'roadmap' => $roadmap,
            'progress' => $progress,
        ];
    }

    public function getSessionByIdAndUser(int $sessionId, int $userId): ?array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM assessment_sessions WHERE id = :id AND user_id = :user_id LIMIT 1');
        $stmt->execute([
            'id' => $sessionId,
            'user_id' => $userId,
        ]);

        return $stmt->fetch() ?: null;
    }

    public function getLatestCompletedSession(int $userId): ?array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM assessment_sessions WHERE user_id = :user_id AND status = "completed" ORDER BY finished_at DESC, id DESC LIMIT 1');
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetch() ?: null;
    }

    public function startSession(int $userId): int
    {
        $existing = $this->getActiveSession($userId);
        if ($existing) {
            return (int) $existing['id'];
        }

        $stmt = $this->pdo->prepare('INSERT INTO assessment_sessions (user_id, started_at, status) VALUES (:user_id, NOW(), "in_progress")');
        $stmt->execute(['user_id' => $userId]);
        return (int) $this->pdo->lastInsertId();
    }

    public function getActiveSession(int $userId): ?array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM assessment_sessions WHERE user_id = :user_id AND status = "in_progress" ORDER BY started_at DESC LIMIT 1');
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetch() ?: null;
    }

    public function submit(array $input, int $userId): array
    {
        if (!isset($input['csrf_token']) || !validate_csrf($input['csrf_token'])) {
            return ['success' => false, 'message' => 'Token CSRF tidak valid.'];
        }

        $requestedSessionId = isset($input['session_id']) ? (int) $input['session_id'] : 0;
        $session = $requestedSessionId > 0
            ? $this->getSessionByIdAndUser($requestedSessionId, $userId)
            : $this->getActiveSession($userId);

        if (!$session) {
            $session = $this->getActiveSession($userId);
            if (!$session) {
                $sessionId = $this->startSession($userId);
            } else {
                $sessionId = (int) $session['id'];
            }
        } else {
            $sessionId = (int) $session['id'];
        }

        if (($session['status'] ?? 'in_progress') === 'completed') {
            return ['success' => false, 'message' => 'Assessment ini sudah selesai dan tidak dapat dikirim ulang.'];
        }

        $questions = $this->questionModel->getAllQuestions();
        $scoreAccumulator = [];

        foreach ($questions as $question) {
            $questionId = (int) $question['id'];
            $competencyId = (int) $question['competency_id'];
            $answerData = $input['answers'][$questionId] ?? null;

            if (!isset($scoreAccumulator[$competencyId])) {
                $scoreAccumulator[$competencyId] = [
                    'multiple_choice_attempted' => 0,
                    'multiple_choice_correct' => 0,
                    'coding_values' => [],
                ];
            }

            if ($question['type'] === 'multiple_choice') {
                $selectedOptionId = isset($answerData['option']) ? (int) $answerData['option'] : 0;
                if ($selectedOptionId <= 0) {
                    continue;
                }

                $correctId = $this->questionModel->getCorrectOptionId($questionId);
                $isCorrect = $correctId !== null && $selectedOptionId === $correctId;
                $score = $isCorrect ? (float) $question['points'] : 0.0;

                $scoreAccumulator[$competencyId]['multiple_choice_attempted']++;
                if ($isCorrect) {
                    $scoreAccumulator[$competencyId]['multiple_choice_correct']++;
                }

                $this->questionModel->saveAnswer($sessionId, $questionId, $selectedOptionId, null, $isCorrect, $score);
                continue;
            }

            $codeSubmission = trim((string) ($answerData['code'] ?? ''));
            if ($codeSubmission === '') {
                continue;
            }

            $score = $this->evaluateCodingRubric((int) $questionId, $codeSubmission);
            $scoreAccumulator[$competencyId]['coding_values'][] = $score;

            $this->questionModel->saveAnswer($sessionId, $questionId, null, $codeSubmission, null, $score);
        }

        if (empty($scoreAccumulator)) {
            return ['success' => false, 'message' => 'Belum ada jawaban yang dikirim.'];
        }

        $scores = [];
        foreach ($scoreAccumulator as $competencyId => $data) {
            $mcAttempted = (int) $data['multiple_choice_attempted'];
            $mcCorrect = (int) $data['multiple_choice_correct'];
            $mcPercent = $mcAttempted > 0 ? ($mcCorrect / $mcAttempted) * 100 : null;

            $codingValues = $data['coding_values'];
            $codingPercent = !empty($codingValues) ? array_sum($codingValues) / count($codingValues) : null;

            if ($mcPercent !== null && $codingPercent !== null) {
                $final = ($mcPercent * 0.4) + ($codingPercent * 0.6);
            } elseif ($mcPercent !== null) {
                $final = $mcPercent;
            } elseif ($codingPercent !== null) {
                $final = $codingPercent;
            } else {
                $final = 0;
            }

            $scores[(int) $competencyId] = [
                'multiple_choice_score' => $mcPercent !== null ? round($mcPercent, 2) : 0,
                'coding_score' => $codingPercent !== null ? round((float) $codingPercent, 2) : 0,
                'final_score' => round($final, 2),
            ];
        }

        $this->saveScoreRows($sessionId, $scores);

        $stmt = $this->pdo->prepare('UPDATE assessment_sessions SET status = "completed", finished_at = NOW() WHERE id = :id');
        $stmt->execute(['id' => $sessionId]);

        $result = [
            'success' => true,
            'message' => 'Assessment berhasil disimpan.',
            'session_id' => $sessionId,
            'scores' => $scores,
        ];

        $aiController = new AIController($this->pdo);
        $result['analysis'] = $aiController->generateAnalysis($userId, $sessionId);

        return $result;
    }

    public function getSessionScores(int $sessionId): array
    {
        $stmt = $this->pdo->prepare('SELECT s.*, c.name AS competency_name FROM assessment_scores s JOIN competencies c ON c.id = s.competency_id WHERE s.session_id = :session_id ORDER BY c.id');
        $stmt->execute(['session_id' => $sessionId]);
        return $stmt->fetchAll();
    }

    public function saveScoreRows(int $sessionId, array $scores): void
    {
        foreach ($scores as $competencyId => $score) {
            $stmt = $this->pdo->prepare('INSERT INTO assessment_scores (session_id, competency_id, multiple_choice_score, coding_score, final_score) VALUES (:session_id, :competency_id, :multiple_choice_score, :coding_score, :final_score) ON DUPLICATE KEY UPDATE multiple_choice_score = VALUES(multiple_choice_score), coding_score = VALUES(coding_score), final_score = VALUES(final_score)');
            $stmt->execute([
                'session_id' => $sessionId,
                'competency_id' => $competencyId,
                'multiple_choice_score' => number_format((float) $score['multiple_choice_score'], 2, '.', ''),
                'coding_score' => number_format((float) $score['coding_score'], 2, '.', ''),
                'final_score' => number_format((float) $score['final_score'], 2, '.', ''),
            ]);
        }
    }

    private function evaluateCodingRubric(int $questionId, string $code): float
    {
        if (trim($code) === '') {
            return 0.0;
        }

        $question = $this->questionModel->getQuestionById($questionId) ?? [];
        $testCases = $this->questionModel->getCodingTestCases($questionId);
        $score = 0.0;
        $normalized = strtolower($code);

        $patternKeywords = [
            'function', 'if', 'else', 'for', 'while', 'foreach', 'return', 'echo', 'print', 'let', 'const', 'var', 'array', '=>', 'switch', 'map', 'filter', 'reduce', 'console.log', 'document', '$', '=>'
        ];

        foreach ($patternKeywords as $keyword) {
            if (stripos($code, $keyword) !== false) {
                $score += 8;
            }
        }

        if (preg_match('/function\s+[A-Za-z_][A-Za-z0-9_]*/', $code) === 1 || preg_match('/\b(if|for|while|foreach|switch)\b/', $code) === 1) {
            $score += 15;
        }

        if (preg_match('/return\s+.+;/', $code) === 1 || preg_match('/echo\s+.+;/', $code) === 1 || preg_match('/console\.log\s*\(/', $code) === 1) {
            $score += 12;
        }

        if (mb_strlen($code) > 80) {
            $score += 18;
        }

        if (!empty($question['starter_code']) && trim($question['starter_code']) !== '') {
            $starterLower = strtolower((string) $question['starter_code']);
            foreach (['function', 'const', 'let', 'var', 'return', 'if', 'for'] as $token) {
                if (stripos($starterLower, $token) !== false && stripos($normalized, $token) !== false) {
                    $score += 12;
                    break;
                }
            }
        }

        if (!empty($testCases)) {
            $tokens = [];
            foreach ($testCases as $testCase) {
                $sample = strtolower((string) ($testCase['expected_output'] ?? ''));
                foreach (preg_split('/[^a-z0-9_]+/', $sample) as $token) {
                    $token = trim($token);
                    if ($token !== '' && strlen($token) > 2) {
                        $tokens[$token] = true;
                    }
                }
            }

            $matched = 0;
            foreach (array_keys($tokens) as $token) {
                if (stripos($normalized, $token) !== false) {
                    $matched++;
                }
            }

            if ($matched > 0) {
                $score += min(25, $matched * 6);
            }
        }

        $score = min(100, max(0, $score));

        return round((float) $score, 2);
    }
}