<?php

class RoadmapModel
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function createRoadmap(int $userId, int $analysisId, string $title, string $description, int $durationDays = 30): int
    {
        $stmt = $this->pdo->prepare('INSERT INTO roadmaps (user_id, analysis_id, title, description, duration_days) VALUES (:user_id, :analysis_id, :title, :description, :duration_days)');
        $stmt->execute([
            'user_id' => $userId,
            'analysis_id' => $analysisId,
            'title' => $title,
            'description' => $description,
            'duration_days' => $durationDays,
        ]);

        return (int) $this->pdo->lastInsertId();
    }

    public function addRoadmapItem(int $roadmapId, ?int $materialId, string $title, string $description, int $dayNumber, string $status = 'pending'): void
    {
        $stmt = $this->pdo->prepare('INSERT INTO roadmap_items (roadmap_id, material_id, title, description, day_number, status) VALUES (:roadmap_id, :material_id, :title, :description, :day_number, :status)');
        $stmt->execute([
            'roadmap_id' => $roadmapId,
            'material_id' => $materialId,
            'title' => $title,
            'description' => $description,
            'day_number' => $dayNumber,
            'status' => $status,
        ]);
    }

    public function getLatestRoadmap(int $userId): ?array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM roadmaps WHERE user_id = :user_id ORDER BY created_at DESC LIMIT 1');
        $stmt->execute(['user_id' => $userId]);
        $roadmap = $stmt->fetch();

        if (!$roadmap) {
            return null;
        }

        $items = $this->getRoadmapItems((int) $roadmap['id']);
        $roadmap['items'] = $items;
        return $roadmap;
    }

    public function getRoadmapItems(int $roadmapId): array
    {
        $stmt = $this->pdo->prepare('SELECT ri.*, lm.title AS material_title, lm.estimated_minutes FROM roadmap_items ri LEFT JOIN learning_materials lm ON lm.id = ri.material_id WHERE ri.roadmap_id = :roadmap_id ORDER BY ri.day_number ASC');
        $stmt->execute(['roadmap_id' => $roadmapId]);
        return $stmt->fetchAll();
    }

    public function markItemStatus(int $itemId, int $userId, string $status): bool
    {
        $stmt = $this->pdo->prepare('SELECT ri.* FROM roadmap_items ri JOIN roadmaps r ON r.id = ri.roadmap_id WHERE ri.id = :item_id AND r.user_id = :user_id LIMIT 1');
        $stmt->execute(['item_id' => $itemId, 'user_id' => $userId]);

        if (!$stmt->fetch()) {
            return false;
        }

        $update = $this->pdo->prepare('UPDATE roadmap_items SET status = :status, completed_at = CASE WHEN :status = "completed" THEN CURRENT_TIMESTAMP ELSE NULL END WHERE id = :item_id');
        $update->execute(['status' => $status, 'item_id' => $itemId]);

        return true;
    }

    public function getProgress(int $roadmapId): array
    {
        $stmt = $this->pdo->prepare('SELECT COUNT(*) AS total, SUM(CASE WHEN status = "completed" THEN 1 ELSE 0 END) AS completed FROM roadmap_items WHERE roadmap_id = :roadmap_id');
        $stmt->execute(['roadmap_id' => $roadmapId]);
        $row = $stmt->fetch();

        $total = (int) ($row['total'] ?? 0);
        $completed = (int) ($row['completed'] ?? 0);
        $percent = $total > 0 ? round(($completed / $total) * 100, 1) : 0;

        return ['total' => $total, 'completed' => $completed, 'percent' => $percent];
    }
}
