
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

    public function getLatestCompletedSession(int $userId): ?array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM assessment_sessions WHERE user_id = :user_id AND status = "completed" ORDER BY finished_at DESC, id DESC LIMIT 1');
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetch() ?: null;
    }

    public function startSession(int $userId): int
    {
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

        $session = $this->getActiveSession($userId);
        if (!$session) {
            $sessionId = $this->startSession($userId);
        } else {
            $sessionId = (int) $session['id'];
        }

        $questions = $this->questionModel->getAllQuestions();
        $scoreAccumulator = [];

        foreach ($questions as $question) {
            $questionId = (int) $question['id'];
            $competencyId = (int) $question['competency_id'];
            $answerData = $input['answers'][$questionId] ?? null;
            $selectedOptionId = null;
            $codeSubmission = null;
            $isCorrect = null;
            $score = 0.0;

            if (!isset($scoreAccumulator[$competencyId])) {
                $scoreAccumulator[$competencyId] = [
                    'multiple_choice_total' => 0,
                    'multiple_choice_correct' => 0,
                    'coding_total' => 0,
                    'coding_values' => [],
                ];
            }

            if ($question['type'] === 'multiple_choice') {
                $selectedOptionId = isset($answerData['option']) ? (int) $answerData['option'] : null;
                $correctId = $this->questionModel->getCorrectOptionId($questionId);
                $isCorrect = $selectedOptionId !== null && $correctId !== null && $selectedOptionId === $correctId;
                $score = $isCorrect ? (float) $question['points'] : 0.0;

                $scoreAccumulator[$competencyId]['multiple_choice_total']++;
                if ($isCorrect) {
                    $scoreAccumulator[$competencyId]['multiple_choice_correct']++;
                }
            } else {
                $codeSubmission = trim((string) ($answerData['code'] ?? ''));
                $score = $this->evaluateCodingRubric((int) $questionId, $codeSubmission);
                $scoreAccumulator[$competencyId]['coding_total']++;
                $scoreAccumulator[$competencyId]['coding_values'][] = $score;
            }

            $this->questionModel->saveAnswer($sessionId, $questionId, $selectedOptionId, $codeSubmission, $isCorrect, $score);
        }

        $scores = [];
        foreach ($scoreAccumulator as $competencyId => $data) {
            $mcTotal = (int) $data['multiple_choice_total'];
            $mcCorrect = (int) $data['multiple_choice_correct'];
            $mcPercent = $mcTotal > 0 ? ($mcCorrect / $mcTotal) * 100 : 0;

            $codingValues = $data['coding_values'];
            $codingPercent = !empty($codingValues) ? array_sum($codingValues) / count($codingValues) : null;

            if ($mcTotal > 0 && $codingPercent !== null) {
                $final = ($mcPercent * 0.4) + ($codingPercent * 0.6);
            } elseif ($mcTotal > 0) {
                $final = $mcPercent;
            } elseif ($codingPercent !== null) {
                $final = $codingPercent;
            } else {
                $final = 0;
            }

            $scores[(int) $competencyId] = [
                'multiple_choice_score' => round($mcPercent, 2),
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

        $question = $this->questionModel->getQuestionById($questionId);
        $score = 0.0;
        $codeLength = mb_strlen($code);
        $keywords = ['function', 'if', 'else', 'for', 'foreach', 'while', 'return', '$', 'echo', 'array', '=>'];

        foreach ($keywords as $keyword) {
            if (stripos($code, $keyword) !== false) {
                $score += 10;
            }
        }

        if ($codeLength > 80) {
            $score += 20;
        }

        if (isset($question['starter_code']) && $question['starter_code'] !== '' && str_contains($code, 'function')) {
            $score += 15;
        }

        $score = min(100, max(0, $score));

        return round((float) $score, 2);
    }
}