<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Assessment | BaliReady AI</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 text-slate-800">
    <div class="min-h-screen p-6 md:p-10">
        <div class="max-w-6xl mx-auto">
            <div class="flex justify-between items-center mb-8">
                <div>
                    <p class="text-sm text-blue-600 font-semibold">Hasil Assessment</p>
                    <h1 class="text-3xl font-bold text-slate-900">Ringkasan skor dan insight AI</h1>
                </div>
                <a href="dashboard.php" class="bg-blue-600 text-white px-5 py-3 rounded-xl hover:bg-blue-700">Kembali ke Dashboard</a>
            </div>

            <?php if (!empty($scoreRows)): ?>
                <div class="grid md:grid-cols-2 xl:grid-cols-3 gap-6 mb-8">
                    <?php foreach ($scoreRows as $score): ?>
                        <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
                            <div class="text-sm text-slate-500"><?php echo e($score['competency_name']); ?></div>
                            <div class="mt-3 text-3xl font-black text-slate-900"><?php echo e($score['final_score']); ?>%</div>
                            <div class="mt-2 text-xs text-slate-500">MC: <?php echo e($score['multiple_choice_score']); ?>% · Coding: <?php echo e($score['coding_score']); ?>%</div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($analysis)): ?>
                <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
                    <h2 class="text-xl font-bold mb-4">AI Analysis</h2>
                    <p class="text-slate-700"><?php echo e($analysis['summary']); ?></p>
                    <div class="mt-6 grid md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="font-bold mb-3">Kekuatan</h3>
                            <ul class="space-y-2 text-slate-700">
                                <?php foreach ($analysis['strengths'] ?? [] as $item): ?>
                                    <li>• <?php echo e($item); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <div>
                            <h3 class="font-bold mb-3">Area perlu ditingkatkan</h3>
                            <ul class="space-y-2 text-slate-700">
                                <?php foreach ($analysis['weaknesses'] ?? [] as $item): ?>
                                    <li>• <?php echo e($item); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                    <div class="mt-6">
                        <h3 class="font-bold mb-3">Rekomendasi</h3>
                        <ul class="space-y-2 text-slate-700">
                            <?php foreach ($analysis['recommendations'] ?? [] as $item): ?>
                                <li>• <?php echo e($item); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
