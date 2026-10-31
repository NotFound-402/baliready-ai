<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | BaliReady AI</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 text-slate-800">
    <?php $summary = $summary ?? []; $scoreRows = $scoreRows ?? []; $user = $user ?? []; ?>
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
                <a href="dashboard.php" class="block rounded-xl bg-blue-50 text-blue-700 px-4 py-3">Dashboard</a>
                <a href="assessment.php" class="block rounded-xl text-slate-600 hover:bg-slate-100 px-4 py-3">Assessment</a>
                <a href="analysis.php" class="block rounded-xl text-slate-600 hover:bg-slate-100 px-4 py-3">AI Analysis</a>
                <a href="roadmap.php" class="block rounded-xl text-slate-600 hover:bg-slate-100 px-4 py-3">Roadmap</a>
                <a href="progress.php" class="block rounded-xl text-slate-600 hover:bg-slate-100 px-4 py-3">Progress</a>
                <a href="logout.php" class="block rounded-xl text-red-600 hover:bg-red-50 px-4 py-3 mt-8">Logout</a>
            </nav>
        </aside>

        <main class="flex-1 p-6 md:p-10">
            <div class="flex justify-between items-center mb-8">
                <div>
                    <p class="text-sm text-slate-500">Halo,</p>
                    <h1 class="text-3xl font-bold text-slate-900"><?php echo e($user['name'] ?? 'Siswa'); ?></h1>
                </div>
                <a href="assessment.php" class="bg-blue-600 text-white px-5 py-3 rounded-xl font-semibold hover:bg-blue-700">Mulai Assessment</a>
            </div>

            <div class="grid md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm">
                    <div class="text-sm text-slate-500">Assessment Terakhir</div>
                    <div class="mt-3 text-3xl font-black text-slate-900"><?php echo e(($summary['lastSession'] ?? null) ? 'Selesai' : 'Belum'); ?></div>
                    <div class="text-xs text-slate-500 mt-2"><?php echo ($summary['lastSession'] ?? null) ? e(date('d M Y', strtotime($summary['lastSession']['finished_at']))) : 'Mulai assessment untuk melihat hasil'; ?></div>
                </div>
                <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm">
                    <div class="text-sm text-slate-500">Rata-rata Skor</div>
                    <div class="mt-3 text-3xl font-black text-slate-900"><?php echo e($averageScore); ?>%</div>
                    <div class="text-xs text-slate-500 mt-2">Berdasarkan kompetensi</div>
                </div>
                <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm">
                    <div class="text-sm text-slate-500">Progress Roadmap</div>
                    <div class="mt-3 text-3xl font-black text-slate-900"><?php echo e($summary['progress']['percent'] ?? 0); ?>%</div>
                    <div class="text-xs text-slate-500 mt-2"><?php echo e($summary['progress']['completed'] ?? 0); ?> dari <?php echo e($summary['progress']['total'] ?? 0); ?> selesai</div>
                </div>
            </div>

            <div class="grid lg:grid-cols-2 gap-6">
                <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
                    <h2 class="text-xl font-bold mb-4">Skor per Kompetensi</h2>
                    <div class="space-y-4">
                        <?php foreach ($scoreRows ?? [] as $score): ?>
                            <div>
                                <div class="flex justify-between text-sm mb-1">
                                    <span class="font-medium text-slate-700"><?php echo e($score['competency_name']); ?></span>
                                    <span class="text-slate-500"><?php echo e($score['final_score']); ?>%</span>
                                </div>
                                <div class="h-2.5 w-full rounded-full bg-slate-200 overflow-hidden">
                                    <div class="h-full rounded-full bg-blue-600" style="width: <?php echo e(min(100, max(0, (float) $score['final_score']))); ?>%;"></div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
                    <h2 class="text-xl font-bold mb-4">Roadmap Belajar</h2>
                    <?php if (!empty($summary['roadmap']['items'])): ?>
                        <div class="space-y-3">
                            <?php foreach (array_slice($summary['roadmap']['items'], 0, 4) as $item): ?>
                                <div class="border border-slate-200 rounded-xl p-3">
                                    <div class="flex justify-between items-start gap-3">
                                        <div>
                                            <div class="font-semibold text-slate-800"><?php echo e($item['title']); ?></div>
                                            <div class="text-xs text-slate-500">Hari <?php echo e($item['day_number']); ?></div>
                                        </div>
                                        <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-700"><?php echo e($item['status']); ?></span>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <p class="text-slate-500">Belum ada roadmap yang dibuat. Selesaikan assessment untuk mendapatkan rekomendasi belajar.</p>
                    <?php endif; ?>
                </div>
            </div>
        </main>
    </div>
</body>
</html>

