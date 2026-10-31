
<?php

class QuestionModel
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getCompetencies(): array
    {
        $stmt = $this->pdo->query('SELECT * FROM competencies ORDER BY id');
        return $stmt->fetchAll();
    }

    public function getAllQuestions(): array
    {
        $sql = 'SELECT q.*, c.name AS competency_name FROM questions q JOIN competencies c ON c.id = q.competency_id ORDER BY q.competency_id, q.id';
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll();
    }

    public function getQuestionsGroupedByCompetency(): array
    {
        $questions = $this->getAllQuestions();
        $grouped = [];

        foreach ($questions as $question) {
            $grouped[$question['competency_id']][] = $question;
        }

        return $grouped;
    }

    public function getOptionsByQuestion(): array
    {
        $stmt = $this->pdo->query('SELECT * FROM question_options ORDER BY question_id, option_label');
        $options = $stmt->fetchAll();
        $result = [];

        foreach ($options as $option) {
            $result[$option['question_id']][] = [
                'id' => (int) $option['id'],
                'question_id' => (int) $option['question_id'],
                'option_label' => $option['option_label'],
                'option_text' => $option['option_text'],
            ];
        }

        return $result;
    }

    public function getCorrectOptionId(int $questionId): ?int
    {
        $stmt = $this->pdo->prepare('SELECT id FROM question_options WHERE question_id = :question_id AND is_correct = 1 LIMIT 1');
        $stmt->execute(['question_id' => $questionId]);
        $row = $stmt->fetch();

        return $row ? (int) $row['id'] : null;
    }

    public function saveAnswer(int $sessionId, int $questionId, ?int $selectedOptionId, ?string $codeSubmission, ?bool $isCorrect, float $score): void
    {
        $stmt = $this->pdo->prepare('INSERT INTO answers (session_id, question_id, selected_option_id, code_submission, is_correct, score) VALUES (:session_id, :question_id, :selected_option_id, :code_submission, :is_correct, :score) ON DUPLICATE KEY UPDATE selected_option_id = VALUES(selected_option_id), code_submission = VALUES(code_submission), is_correct = VALUES(is_correct), score = VALUES(score), submitted_at = CURRENT_TIMESTAMP');

        $stmt->execute([
            'session_id' => $sessionId,
            'question_id' => $questionId,
            'selected_option_id' => $selectedOptionId,
            'code_submission' => $codeSubmission,
            'is_correct' => $isCorrect ? 1 : 0,
            'score' => number_format($score, 2, '.', ''),
        ]);
    }

    public function getQuestionById(int $questionId): ?array
    {
        $stmt = $this->pdo->prepare('SELECT q.*, c.name AS competency_name FROM questions q JOIN competencies c ON c.id = q.competency_id WHERE q.id = :id LIMIT 1');
        $stmt->execute(['id' => $questionId]);
        return $stmt->fetch() ?: null;
    }

    public function getCodingTestCases(int $questionId): array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM coding_test_cases WHERE question_id = :question_id ORDER BY id');
        $stmt->execute(['question_id' => $questionId]);
        return $stmt->fetchAll();
    }

    public function createQuestion(array $data): int|false
    {
        $stmt = $this->pdo->prepare('INSERT INTO questions (competency_id, type, title, question_text, difficulty, points, programming_language, starter_code) VALUES (:competency_id, :type, :title, :question_text, :difficulty, :points, :programming_language, :starter_code)');

        $ok = $stmt->execute([
            'competency_id' => (int) $data['competency_id'],
            'type' => $data['type'],
            'title' => trim($data['title']),
            'question_text' => trim($data['question_text']),
            'difficulty' => $data['difficulty'] ?? 'easy',
            'points' => (float) ($data['points'] ?? 1),
            'programming_language' => $data['programming_language'] ?? null,
            'starter_code' => $data['starter_code'] ?? null,
        ]);

        if (!$ok) {
            return false;
        }

        $insertId = (int) $this->pdo->lastInsertId();
        return $insertId > 0 ? $insertId : false;
    }

    public function addOption(int $questionId, string $label, string $text, bool $isCorrect): bool
    {
        $stmt = $this->pdo->prepare('INSERT INTO question_options (question_id, option_label, option_text, is_correct) VALUES (:question_id, :option_label, :option_text, :is_correct)');

        return $stmt->execute([
            'question_id' => $questionId,
            'option_label' => strtoupper(substr($label, 0, 1)),
            'option_text' => $text,
            'is_correct' => $isCorrect ? 1 : 0,
        ]);
    }
}