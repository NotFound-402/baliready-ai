<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AI Analysis | BaliReady AI</title>
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
                <a href="assessment.php" class="block rounded-xl text-slate-600 hover:bg-slate-100 px-4 py-3">Assessment</a>
                <a href="analysis.php" class="block rounded-xl bg-blue-50 text-blue-700 px-4 py-3">AI Analysis</a>
                <a href="roadmap.php" class="block rounded-xl text-slate-600 hover:bg-slate-100 px-4 py-3">Roadmap</a>
                <a href="progress.php" class="block rounded-xl text-slate-600 hover:bg-slate-100 px-4 py-3">Progress</a>
                <a href="logout.php" class="block rounded-xl text-red-600 hover:bg-red-50 px-4 py-3 mt-8">Logout</a>
            </nav>
        </aside>

        <main class="flex-1 p-6 md:p-10">
            <div class="max-w-5xl mx-auto">
                <h1 class="text-3xl font-bold text-slate-900">AI Analysis</h1>
                <p class="mt-2 text-slate-600">Ringkasan kemampuan, kekuatan, dan fokus belajar terbaik.</p>

                <?php if (!empty($analysis)): ?>
                    <div class="mt-8 grid gap-6">
                        <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
                            <h2 class="text-xl font-bold mb-3">Ringkasan</h2>
                            <p class="text-slate-700"><?php echo e($analysis['summary']); ?></p>
                        </div>

                        <div class="grid md:grid-cols-2 gap-6">
                            <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
                                <h3 class="text-lg font-bold mb-4">Kekuatan</h3>
                                <ul class="space-y-2">
                                    <?php foreach ($analysis['strengths'] ?? [] as $item): ?>
                                        <li class="flex gap-2 text-slate-700"><span class="text-green-600">●</span> <?php echo e($item); ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                            <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
                                <h3 class="text-lg font-bold mb-4">Area perlu ditingkatkan</h3>
                                <ul class="space-y-2">
                                    <?php foreach ($analysis['weaknesses'] ?? [] as $item): ?>
                                        <li class="flex gap-2 text-slate-700"><span class="text-amber-600">●</span> <?php echo e($item); ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>

                        <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
                            <h3 class="text-lg font-bold mb-4">Rekomendasi pembelajaran</h3>
                            <ul class="space-y-3">
                                <?php foreach ($analysis['recommendations'] ?? [] as $item): ?>
                                    <li class="flex gap-3 text-slate-700"><span class="text-blue-600">→</span> <?php echo e($item); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>

                        <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
                            <h3 class="text-lg font-bold mb-4">Saran proyek latihan</h3>
                            <ul class="space-y-3">
                                <?php foreach ($analysis['project_ideas'] ?? [] as $idea): ?>
                                    <li class="flex gap-3 text-slate-700"><span class="text-blue-600">✦</span> <?php echo e($idea); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="mt-8 rounded-2xl border border-dashed border-slate-300 bg-white p-8 text-slate-500">Belum ada hasil AI. Selesaikan assessment terlebih dahulu.</div>
                <?php endif; ?>
            </div>
        </main>
    </div>
</body>
</html>

