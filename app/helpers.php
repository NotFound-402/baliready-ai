<?php

function app_env(string $key, mixed $default = null): mixed
{
    $value = getenv($key);
    if ($value !== false && $value !== '') {
        return $value;
    }

    if (isset($_ENV[$key])) {
        return $_ENV[$key];
    }

    return $default;
}

function e(mixed $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function current_user(): ?array
{
    if (empty($_SESSION['user_id'])) {
        return null;
    }

    return [
        'id' => (int) $_SESSION['user_id'],
        'name' => $_SESSION['user_name'] ?? 'User',
        'email' => $_SESSION['user_email'] ?? '',
        'role' => $_SESSION['user_role'] ?? 'student',
    ];
}

function is_logged_in(): bool
{
    return !empty($_SESSION['user_id']);
}

function app_base_path(): string
{
    $scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
    if ($scriptName !== '') {
        $base = dirname($scriptName);
        if ($base === '/' || $base === '\\' || $base === '.') {
            return '';
        }
        return $base;
    }

    return '';
}

function require_login(): void
{
    if (!is_logged_in()) {
        redirect((app_base_path() ?: '') . '/login.php');
    }
}

function require_admin(): void
{
    require_login();

    if ((current_user()['role'] ?? 'student') !== 'admin') {
        redirect((app_base_path() ?: '') . '/dashboard.php');
    }
}

function csrf_token(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    return $_SESSION['csrf_token'];
}

function csrf_field(): string
{
    return '<input type="hidden" name="csrf_token" value="' . e(csrf_token()) . '">';
}

function validate_csrf(string $token): bool
{
    return hash_equals($_SESSION['csrf_token'] ?? '', $token ?? '');
}

function redirect(string $path): void
{
    $normalized = trim($path);
    if ($normalized === '') {
        $normalized = './';
    }

    $normalized = preg_replace('#^/baliready-ai/public/#', '/', $normalized);
    $normalized = preg_replace('#^/baliready-ai/#', '/', $normalized);
    $normalized = preg_replace('#^/public/#', '/', $normalized);

    if (!preg_match('#^https?://#i', $normalized) && !str_starts_with($normalized, '/')) {
        $base = app_base_path();
        $normalized = ($base !== '' ? $base : '') . '/' . ltrim($normalized, '/');
    }

    header('Location: ' . $normalized);
    exit;
}

function ensure_demo_data(PDO $pdo): void
{
    $count = (int) $pdo->query('SELECT COUNT(*) FROM questions')->fetchColumn();
    if ($count > 0) {
        return;
    }

    $competencyMap = [
        1 => 'HTML & CSS',
        2 => 'JavaScript',
        3 => 'PHP',
        4 => 'Database',
        5 => 'Programming Logic',
    ];

    $questionData = [
        [
            'competency_id' => 1,
            'type' => 'multiple_choice',
            'title' => 'Layout Semantik HTML',
            'question_text' => 'Elemen HTML yang paling tepat untuk menandai seksi utama halaman adalah ...',
            'difficulty' => 'easy',
            'points' => 5,
            'options' => ['A' => '<header>', 'B' => '<main>', 'C' => '<nav>', 'D' => '<aside>'],
            'correct' => 'B',
        ],
        [
            'competency_id' => 2,
            'type' => 'multiple_choice',
            'title' => 'Array dan Loop',
            'question_text' => 'Diketahui array [2, 4, 6]. Perintah JavaScript yang menghasilkan hasil 12 adalah ...',
            'difficulty' => 'medium',
            'points' => 5,
            'options' => ['A' => 'array.reduce()', 'B' => 'Math.max()', 'C' => 'forEach()', 'D' => 'slice()'],
            'correct' => 'A',
        ],
        [
            'competency_id' => 3,
            'type' => 'multiple_choice',
            'title' => 'Superglobal PHP',
            'question_text' => 'Untuk membaca data form yang dikirim dengan method POST di PHP, variabel yang paling tepat digunakan adalah ...',
            'difficulty' => 'easy',
            'points' => 5,
            'options' => ['A' => '$_GET', 'B' => '$_POST', 'C' => '$POST', 'D' => '$REQUEST'],
            'correct' => 'B',
        ],
        [
            'competency_id' => 4,
            'type' => 'multiple_choice',
            'title' => 'Relasi Tabel',
            'question_text' => 'Tipe relasi yang paling tepat untuk menghubungkan tabel siswa dan kelas adalah ...',
            'difficulty' => 'medium',
            'points' => 5,
            'options' => ['A' => 'One-to-one', 'B' => 'Many-to-many', 'C' => 'One-to-many', 'D' => 'Self-relation'],
            'correct' => 'C',
        ],
        [
            'competency_id' => 5,
            'type' => 'multiple_choice',
            'title' => 'Logika Kondisi',
            'question_text' => 'Jika sebuah program menerima angka dan harus mengecek apakah angka itu genap, kondisi yang benar adalah ...',
            'difficulty' => 'easy',
            'points' => 5,
            'options' => ['A' => '$n % 2 === 0', 'B' => '$n / 2 === 0', 'C' => '$n + 2 === 0', 'D' => '$n === 0'],
            'correct' => 'A',
        ],
        [
            'competency_id' => 1,
            'type' => 'coding',
            'title' => 'Membuat Card Responsive',
            'question_text' => 'Buatlah struktur HTML untuk 3 card produk yang responsif dan rapi.',
            'difficulty' => 'medium',
            'points' => 10,
            'programming_language' => 'HTML',
            'starter_code' => '<div class="container">\n  <div class="card">Produk 1</div>\n</div>',
        ],
        [
            'competency_id' => 2,
            'type' => 'coding',
            'title' => 'Penjumlahan Bilangan',
            'question_text' => 'Buat fungsi JavaScript yang menerima dua angka lalu mengembalikan hasil penjumlahannya.',
            'difficulty' => 'medium',
            'points' => 10,
            'programming_language' => 'JavaScript',
            'starter_code' => 'function tambah(a, b) {\n  return a + b;\n}',
        ],
    ];

    $questionInsert = $pdo->prepare('INSERT INTO questions (competency_id, type, title, question_text, difficulty, points, programming_language, starter_code) VALUES (:competency_id, :type, :title, :question_text, :difficulty, :points, :programming_language, :starter_code)');
    $optionInsert = $pdo->prepare('INSERT INTO question_options (question_id, option_label, option_text, is_correct) VALUES (:question_id, :option_label, :option_text, :is_correct)');

    foreach ($questionData as $question) {
        $questionInsert->execute([
            'competency_id' => $question['competency_id'],
            'type' => $question['type'],
            'title' => $question['title'],
            'question_text' => $question['question_text'],
            'difficulty' => $question['difficulty'],
            'points' => $question['points'],
            'programming_language' => $question['programming_language'] ?? null,
            'starter_code' => $question['starter_code'] ?? null,
        ]);

        $questionId = (int) $pdo->lastInsertId();

        if ($question['type'] === 'multiple_choice') {
            foreach ($question['options'] as $label => $optionText) {
                $optionInsert->execute([
                    'question_id' => $questionId,
                    'option_label' => $label,
                    'option_text' => $optionText,
                    'is_correct' => ($label === $question['correct']) ? 1 : 0,
                ]);
            }
        }
    }

    $materials = [
        ['competency_id' => 1, 'title' => 'HTML Semantics Essentials', 'description' => 'Struktur halaman yang rapi dan ramah aksesibilitas.', 'material_type' => 'article', 'url' => 'https://developer.mozilla.org/en-US/docs/Learn/HTML/Introduction_to_HTML', 'difficulty' => 'easy', 'estimated_minutes' => 35],
        ['competency_id' => 2, 'title' => 'JavaScript Fundamentals', 'description' => 'Variabel, fungsi, dan logika kontrol untuk membangun interaksi.', 'material_type' => 'video', 'url' => 'https://developer.mozilla.org/en-US/docs/Web/JavaScript', 'difficulty' => 'medium', 'estimated_minutes' => 40],
        ['competency_id' => 3, 'title' => 'PHP Form Handling', 'description' => 'Pengolahan form dan session untuk aplikasi web dinamis.', 'material_type' => 'article', 'url' => 'https://www.php.net/manual/en/tutorial.forms.php', 'difficulty' => 'medium', 'estimated_minutes' => 45],
        ['competency_id' => 4, 'title' => 'SQL Query Practice', 'description' => 'Belajar JOIN, relasi tabel, dan pengelolaan data.', 'material_type' => 'practice', 'url' => 'https://www.w3schools.com/sql/', 'difficulty' => 'medium', 'estimated_minutes' => 50],
        ['competency_id' => 5, 'title' => 'Programming Logic Warm Up', 'description' => 'Latihan algoritma dan logika dasar.', 'material_type' => 'project', 'url' => 'https://www.geeksforgeeks.org/algorithms/', 'difficulty' => 'easy', 'estimated_minutes' => 30],
    ];

    $materialInsert = $pdo->prepare('INSERT INTO learning_materials (competency_id, title, description, material_type, url, difficulty, estimated_minutes) VALUES (:competency_id, :title, :description, :material_type, :url, :difficulty, :estimated_minutes)');
    foreach ($materials as $item) {
        $materialInsert->execute($item);
    }
}
