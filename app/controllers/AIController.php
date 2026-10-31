<?php

class AIController
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function generateAnalysis(int $userId, int $sessionId): array
    {
        $scores = $this->getScoresForSession($sessionId);
        $strengths = [];
        $weaknesses = [];

        foreach ($scores as $score) {
            $competencyName = $score['competency_name'] ?? 'Competency';
            $final = (float) $score['final_score'];

            if ($final >= 75) {
                $strengths[] = $competencyName;
            } elseif ($final < 60) {
                $weaknesses[] = $competencyName;
            }
        }

        $analysisPayload = [
            'summary' => 'Siswa menunjukkan pola belajar yang kuat pada kompetensi yang sudah dikuasai dan perlu fokus pada area yang masih lemah.',
            'strengths' => $strengths ?: ['Pemecahan masalah dasar'],
            'weaknesses' => $weaknesses ?: ['Penguatan fondasi dan latihan konsisten'],
            'recommendations' => [
                'Tingkatkan latihan soal secara bertahap dan fokus pada kompetensi dengan skor terendah.',
                'Pelajari materi yang relevan dalam 30 hari berikutnya dan ulangi checkpoint setiap minggu.',
                'Bangun proyek mini untuk menerapkan konsep yang dipelajari secara nyata.',
            ],
            'project_ideas' => [
                'Buat landing page porto digital dengan HTML, CSS, dan JavaScript.',
                'Bangun fitur login dan dashboard sederhana dengan PHP + MySQL.',
                'Rancang aplikasi mini CRUD untuk data siswa atau produk.',
            ],
        ];

        $aiConfig = require __DIR__ . '/../config/ai.php';
        $gemini = new GeminiService($aiConfig['api_key'], $aiConfig['model']);
        $response = $gemini->generate($this->buildPrompt($scores, $strengths, $weaknesses));

        if (($response['status'] ?? 'fallback') === 'success' && isset($response['content']) && is_array($response['content'])) {
            $analysisPayload = $this->validatePayload($response['content'], $analysisPayload);
        } else {
            $analysisPayload['summary'] = 'AI fallback aktif karena API Gemini belum dikonfigurasi atau gagal merespons. Hasil ini dibuat dari skor assessment yang tersedia.';
        }

        $this->saveAnalysis($sessionId, $analysisPayload);

        $recommendationService = new RecommendationService();
        $recommendationService->generateRoadmap($this->pdo, $userId, $sessionId, $scores, $analysisPayload);

        return $analysisPayload;
    }

    public function getAnalysisForSession(int $sessionId): ?array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM ai_analyses WHERE session_id = :session_id LIMIT 1');
        $stmt->execute(['session_id' => $sessionId]);
        $row = $stmt->fetch();

        if (!$row) {
            return null;
        }

        $decodedRaw = json_decode($row['raw_response'] ?? '{}', true);
        $projectIdeas = is_array($decodedRaw['project_ideas'] ?? null) ? $decodedRaw['project_ideas'] : [];

        return [
            'id' => (int) $row['id'],
            'summary' => $row['summary'],
            'strengths' => json_decode($row['strengths'] ?? '[]', true),
            'weaknesses' => json_decode($row['weaknesses'] ?? '[]', true),
            'recommendations' => json_decode($row['recommendations'] ?? '[]', true),
            'project_ideas' => $projectIdeas,
        ];
    }

    private function buildPrompt(array $scores, array $strengths, array $weaknesses): string
    {
        $scoreText = [];
        foreach ($scores as $score) {
            $scoreText[] = ($score['competency_name'] ?? 'Kompetensi') . ': ' . $score['final_score'];
        }

        return "Anda adalah mentor pembelajaran untuk siswa kelas 12 jurusan RPL/PPLG. Berdasarkan hasil assessment berikut: " . implode('; ', $scoreText) . ". Kekuatan: " . implode(', ', $strengths ?: ['belum ada']) . ". Kelemahan: " . implode(', ', $weaknesses ?: ['belum ada']) . ". Tulis jawaban dalam format JSON valid dengan struktur: {\"summary\":\"...\",\"strengths\":[\"...\"],\"weaknesses\":[\"...\"],\"recommendations\":[\"...\"],\"project_ideas\":[\"...\"]}. Jangan menambahkan teks di luar JSON. ";
    }

    private function validatePayload(array $payload, array $fallback): array
    {
        $normalized = [
            'summary' => isset($payload['summary']) ? (string) $payload['summary'] : $fallback['summary'],
            'strengths' => is_array($payload['strengths'] ?? null) ? array_map('strval', $payload['strengths']) : $fallback['strengths'],
            'weaknesses' => is_array($payload['weaknesses'] ?? null) ? array_map('strval', $payload['weaknesses']) : $fallback['weaknesses'],
            'recommendations' => is_array($payload['recommendations'] ?? null) ? array_map('strval', $payload['recommendations']) : $fallback['recommendations'],
            'project_ideas' => is_array($payload['project_ideas'] ?? null) ? array_map('strval', $payload['project_ideas']) : $fallback['project_ideas'],
        ];

        return $normalized;
    }

    private function saveAnalysis(int $sessionId, array $payload): void
    {
        $stmt = $this->pdo->prepare('INSERT INTO ai_analyses (session_id, summary, strengths, weaknesses, recommendations, raw_response) VALUES (:session_id, :summary, :strengths, :weaknesses, :recommendations, :raw_response) ON DUPLICATE KEY UPDATE summary = VALUES(summary), strengths = VALUES(strengths), weaknesses = VALUES(weaknesses), recommendations = VALUES(recommendations), raw_response = VALUES(raw_response)');

        $stmt->execute([
            'session_id' => $sessionId,
            'summary' => $payload['summary'],
            'strengths' => json_encode($payload['strengths'] ?? []),
            'weaknesses' => json_encode($payload['weaknesses'] ?? []),
            'recommendations' => json_encode($payload['recommendations'] ?? []),
            'raw_response' => json_encode($payload),
        ]);
    }

    private function getScoresForSession(int $sessionId): array
    {
        $stmt = $this->pdo->prepare('SELECT s.*, c.name AS competency_name FROM assessment_scores s JOIN competencies c ON c.id = s.competency_id WHERE s.session_id = :session_id ORDER BY c.id');
        $stmt->execute(['session_id' => $sessionId]);
        return $stmt->fetchAll();
    }
}
