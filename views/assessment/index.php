<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assessment | BaliReady AI</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 text-slate-800">
    <div class="min-h-screen flex">
        <aside class="w-72 bg-white border-r border-slate-200 p-6 hidden md:block">
            <div class="flex items-center gap-3 mb-10">
                <div class="w-11 h-11 rounded-2xl bg-blue-600 text-white font-bold flex items-center justify-center">BR</div>
                <div>
                    <div class="font-bold">BaliReady AI</div>
                    <div class="text-xs text-slate-500">Student Portal</div>
                </div>
            </div>
            <nav class="space-y-2 text-sm font-medium">
                <a href="dashboard.php" class="block rounded-xl text-slate-600 hover:bg-slate-100 px-4 py-3">Dashboard</a>
                <a href="assessment.php" class="block rounded-xl bg-blue-50 text-blue-700 px-4 py-3">Assessment</a>
                <a href="analysis.php" class="block rounded-xl text-slate-600 hover:bg-slate-100 px-4 py-3">AI Analysis</a>
                <a href="roadmap.php" class="block rounded-xl text-slate-600 hover:bg-slate-100 px-4 py-3">Roadmap</a>
                <a href="progress.php" class="block rounded-xl text-slate-600 hover:bg-slate-100 px-4 py-3">Progress</a>
                <a href="logout.php" class="block rounded-xl text-red-600 hover:bg-red-50 px-4 py-3 mt-8">Logout</a>
            </nav>
        </aside>

        <main class="flex-1 p-6 md:p-10">
            <div class="max-w-5xl mx-auto">
                <div class="mb-6">
                    <p class="text-sm text-blue-600 font-semibold">Assessment</p>
                    <h1 class="text-3xl font-bold text-slate-900">Uji kemampuan teknismu</h1>
                </div>

                <?php if (!empty($errorMessage)): ?>
                    <div class="mb-6 rounded-xl bg-red-50 border border-red-200 text-red-700 px-4 py-3 text-sm"><?php echo e($errorMessage); ?></div>
                <?php endif; ?>

                <form method="post" class="space-y-8">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="submit_assessment" value="1">

                    <?php foreach ($data['competencies'] ?? [] as $competency): ?>
                        <?php $competencyQuestions = []; ?>
                        <?php foreach ($data['questions'] ?? [] as $question): ?>
                            <?php if ((int) ($question['competency_id'] ?? 0) === (int) ($competency['id'] ?? 0)): ?>
                                <?php $competencyQuestions[] = $question; ?>
                            <?php endif; ?>
                        <?php endforeach; ?>

                        <?php if (!empty($competencyQuestions)): ?>
                            <section class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
                                <div class="mb-5">
                                    <div class="text-xs uppercase tracking-[0.2em] text-slate-500">Kompetensi</div>
                                    <h2 class="text-2xl font-bold text-slate-900 mt-2"><?php echo e($competency['name']); ?></h2>
                                </div>

                                <div class="space-y-5">
                                    <?php foreach ($competencyQuestions as $question): ?>
                                        <div class="border border-slate-200 rounded-2xl p-5">
                                            <div class="flex justify-between items-start gap-3 mb-3">
                                                <div>
                                                    <div class="text-xs font-semibold uppercase text-blue-600"><?php echo $question['type'] === 'coding' ? 'Coding' : 'Pilihan Ganda'; ?></div>
                                                    <h3 class="text-lg font-bold text-slate-900 mt-1"><?php echo e($question['title']); ?></h3>
                                                </div>
                                                <span class="bg-slate-100 text-slate-600 px-2 py-1 text-xs rounded-full"><?php echo e($question['difficulty']); ?></span>
                                            </div>

                                            <p class="text-slate-600 mb-4"><?php echo e($question['question_text']); ?></p>

                                            <?php if ($question['type'] === 'multiple_choice'): ?>
                                                <div class="space-y-3">
                                                    <?php foreach (($data['optionsByQuestion'][$question['id']] ?? []) as $option): ?>
                                                        <label class="flex items-start gap-3 rounded-xl border border-slate-200 p-3 hover:bg-slate-50 cursor-pointer">
                                                            <input type="radio" name="answers[<?php echo (int) $question['id']; ?>][option]" value="<?php echo (int) $option['id']; ?>" class="mt-1 text-blue-600">
                                                            <span class="font-semibold text-slate-700 mr-2"><?php echo e($option['option_label']); ?>.</span>
                                                            <span class="text-slate-700"><?php echo e($option['option_text']); ?></span>
                                                        </label>
                                                    <?php endforeach; ?>
                                                </div>
                                            <?php else: ?>
                                                <textarea name="answers[<?php echo (int) $question['id']; ?>][code]" rows="8" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Tulis solusi Anda di sini..."><?php echo e($question['starter_code'] ?? ''); ?></textarea>
                                            <?php endif; ?>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </section>
                        <?php endif; ?>
                    <?php endforeach; ?>

                    <div class="flex justify-end">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-xl">Submit Assessment</button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>
</html>

