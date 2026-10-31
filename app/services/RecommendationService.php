<?php

class RecommendationService
{
    public function build(array $assessmentResult): array
    {
        return [
            'title' => 'Roadmap Belajar 30 Hari',
            'description' => 'Rekomendasi akan dibuat berdasarkan hasil assessment.',
            'items' => $assessmentResult['items'] ?? [],
        ];
    }

    public function generateRoadmap(PDO $pdo, int $userId, int $sessionId, array $scores, array $analysis): array
    {
        $roadmapModel = new RoadmapModel($pdo);
        $analysisId = $this->getAnalysisId($pdo, $sessionId);

        if ($analysisId === null) {
            return ['success' => false, 'message' => 'AI analysis belum tersedia.'];
        }

        $title = 'Roadmap Belajar 30 Hari';
        $description = 'Roadmap berdasarkan hasil assessment dan analisis AI.';
        $roadmapId = $roadmapModel->createRoadmap($userId, $analysisId, $title, $description, 30);

        $materials = $this->getRecommendedMaterials($pdo, $scores);
        foreach ($materials as $index => $material) {
            $materialId = isset($material['id']) ? (int) $material['id'] : null;
            $roadmapModel->addRoadmapItem($roadmapId, $materialId, $material['title'], $material['description'], $index + 1, 'pending');
        }

        return ['success' => true, 'roadmap_id' => $roadmapId, 'items' => $materials];
    }

    private function getAnalysisId(PDO $pdo, int $sessionId): ?int
    {
        $stmt = $pdo->prepare('SELECT id FROM ai_analyses WHERE session_id = :session_id LIMIT 1');
        $stmt->execute(['session_id' => $sessionId]);
        $row = $stmt->fetch();
        return $row ? (int) $row['id'] : null;
    }

    private function getRecommendedMaterials(PDO $pdo, array $scores): array
    {
        $competencyIds = array_keys($scores);
        if (empty($competencyIds)) {
            $stmt = $pdo->query('SELECT * FROM learning_materials ORDER BY id LIMIT 6');
            return $stmt->fetchAll();
        }

        $placeholders = implode(',', array_fill(0, count($competencyIds), '?'));
        $stmt = $pdo->prepare('SELECT * FROM learning_materials WHERE competency_id IN (' . $placeholders . ') ORDER BY estimated_minutes DESC LIMIT 6');
        $stmt->execute(array_map('intval', $competencyIds));
        $materials = $stmt->fetchAll();

        if (empty($materials)) {
            $fallback = $pdo->query('SELECT * FROM learning_materials ORDER BY id LIMIT 6');
            return $fallback->fetchAll();
        }

        return $materials;
    }
}
