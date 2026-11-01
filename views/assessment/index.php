<?php
$questions = $data['questions'] ?? [];
$optionsByQuestion = $data['optionsByQuestion'] ?? [];
$competencies = $data['competencies'] ?? [];
$questionCount = count($questions);
$activeSession = $controller->getActiveSession((int) current_user()['id']) ?? null;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assessment | BaliReady AI</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="assets/css/style.css?v=20261101">
</head>
<body class="assessment-shell">
    <div class="assessment-layout">
        <aside class="side-panel">
            <div class="brand">
                <span class="logo-mark">BR</span>
                <span>BaliReady AI</span>
            </div>

            <div style="margin-top: 22px; background: rgba(234,243,255,0.6); border: 1px solid rgba(16,45,89,0.08); border-radius: 18px; padding: 16px;">
                <div style="font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.1em; color: rgba(20,43,80,0.7); font-weight: 800;">Assessment</div>
                <div style="font-size: 1.2rem; font-weight: 900; color: var(--dark-navy); margin-top: 8px;">
                    <?php echo e($questions[0]['competency_name'] ?? 'Ujian'); ?>
                </div>
            </div>

            <?php if (!empty($competencies)): ?>
                <div class="chapter-list">
                    <?php foreach ($competencies as $index => $competency): ?>
                        <div class="chapter-item <?php echo $index === 0 ? 'active' : ''; ?>">
                            <span class="chapter-number"><?php echo (int) ($index + 1); ?></span>
                            <?php echo e($competency['name']); ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </aside>

        <main class="question-panel">
            <?php if (!empty($errorMessage)): ?>
                <div style="margin-bottom: 16px; background: rgba(239,71,111,0.08); border: 1px solid rgba(239,71,111,0.2); color: #b93f5f; border-radius: 14px; padding: 12px 14px; font-weight:600;">
                    <?php echo e($errorMessage); ?>
                </div>
            <?php endif; ?>

            <?php if ($questionCount > 0): ?>
                <form method="post" id="assessment-form">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="submit_assessment" value="1">
                    <?php if ($activeSession): ?>
                        <input type="hidden" name="session_id" value="<?php echo (int) $activeSession['id']; ?>">
                    <?php endif; ?>

                    <div class="question-topbar">
                        <div>
                            <div style="font-size: 0.76rem; text-transform: uppercase; letter-spacing: 0.12em; color: rgba(20,43,80,0.68); font-weight: 800;">Task</div>
                            <h1 id="assessment-title" style="margin: 8px 0 0; font-size: 2rem; font-weight: 900; color: var(--dark-navy);">Bagian 1 dari <?php echo (int) $questionCount; ?></h1>
                        </div>
                        <div class="progress-bar"><span id="assessment-progress" style="width: <?php echo ($questionCount > 0) ? (100 / $questionCount) : 0; ?>%;"></span></div>
                    </div>

                    <?php foreach ($questions as $index => $question): ?>
                        <div class="question-card assessment-question" data-question-index="<?php echo (int) $index; ?>" style="<?php echo $index === 0 ? '' : 'display: none;'; ?>">
                            <div class="q-headline">
                                <div class="q-tag"><?php echo $question['type'] === 'coding' ? 'Coding' : 'Pilihan Ganda'; ?></div>
                                <span style="font-weight: 700; color: rgba(20,43,80,0.7);">Skor: <?php echo e($question['points']); ?></span>
                            </div>

                            <h2 style="margin: 0 0 12px; font-size: 1.6rem; font-weight: 900; color: var(--dark-navy);"><?php echo e($question['title']); ?></h2>
                            <p style="margin:0; color: rgba(20,43,80,0.72); line-height: 1.7;">
                                <?php echo nl2br(e($question['question_text'])); ?>
                            </p>

                            <?php if ($question['type'] === 'multiple_choice'): ?>
                                <div class="answer-list">
                                    <?php foreach ($optionsByQuestion[$question['id']] ?? [] as $option): ?>
                                        <label class="answer-option">
                                            <input type="radio" name="answers[<?php echo (int) $question['id']; ?>][option]" value="<?php echo (int) $option['id']; ?>">
                                            <span><?php echo e($option['option_label'] . '. ' . $option['option_text']); ?></span>
                                        </label>
                                    <?php endforeach; ?>
                                </div>
                            <?php else: ?>
                                <?php if (!empty($question['starter_code'])): ?>
                                    <div style="margin-top: 18px; margin-bottom: 10px; font-size: 0.78rem; letter-spacing: 0.12em; text-transform: uppercase; color: rgba(20,43,80,0.68); font-weight: 800;">Starter code</div>
                                    <pre style="margin: 0 0 14px; padding: 16px; border-radius: 18px; background: rgba(16,45,89,0.05); border: 1px solid rgba(16,45,89,0.08); overflow: auto; color: var(--dark-navy); font-size: 0.82rem;"><?php echo e($question['starter_code']); ?></pre>
                                <?php endif; ?>
                                <textarea class="coding-box" name="answers[<?php echo (int) $question['id']; ?>][code]" placeholder="Tulis jawaban coding Anda di sini..."></textarea>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>

                    <div class="action-row">
                        <button class="btn-secondary" type="button" data-assessment-prev>Sebelumnya</button>
                        <button class="btn-primary" type="button" data-assessment-next>Selanjutnya</button>
                    </div>
                </form>
            <?php else: ?>
                <div class="question-card" style="padding: 28px; text-align: center;">
                    <h2 style="margin: 0 0 8px; font-size: 1.7rem; font-weight: 900; color: var(--dark-navy);">Assessment belum tersedia</h2>
                    <p style="margin: 0; color: rgba(20,43,80,0.7);">Belum ada soal yang terdaftar di database. Silakan cek data soal di tabel questions.</p>
                </div>
            <?php endif; ?>
        </main>
    </div>
    <script src="assets/js/app.js?v=20261101"></script>
</body>
</html>

