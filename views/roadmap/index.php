<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Roadmap | BaliReady AI</title>
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
                <a href="analysis.php" class="block rounded-xl text-slate-600 hover:bg-slate-100 px-4 py-3">AI Analysis</a>
                <a href="roadmap.php" class="block rounded-xl bg-blue-50 text-blue-700 px-4 py-3">Roadmap</a>
                <a href="progress.php" class="block rounded-xl text-slate-600 hover:bg-slate-100 px-4 py-3">Progress</a>
                <a href="logout.php" class="block rounded-xl text-red-600 hover:bg-red-50 px-4 py-3 mt-8">Logout</a>
            </nav>
        </aside>

        <main class="flex-1 p-6 md:p-10">
            <div class="max-w-5xl mx-auto">
                <div class="flex justify-between items-center mb-8">
                    <div>
                        <p class="text-sm text-blue-600 font-semibold">Roadmap</p>
                        <h1 class="text-3xl font-bold text-slate-900">30 Hari Belajar Personal</h1>
                    </div>
                    <div class="bg-white rounded-xl px-4 py-2 border border-slate-200 text-sm text-slate-600">Progress: <?php echo e($progress['percent'] ?? 0); ?>%</div>
                </div>

                <?php if (!empty($roadmap['items'])): ?>
                    <div class="space-y-4">
                        <?php foreach ($roadmap['items'] as $item): ?>
                            <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm">
                                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                                    <div>
                                        <div class="text-xs uppercase tracking-[0.2em] text-slate-500">Hari <?php echo e($item['day_number']); ?></div>
                                        <h3 class="text-xl font-bold text-slate-900 mt-2"><?php echo e($item['title']); ?></h3>
                                        <p class="text-slate-600 mt-2"><?php echo e($item['description']); ?></p>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <span class="px-3 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-600"><?php echo e($item['status']); ?></span>
                                        <form method="post" class="inline">
                                            <?php echo csrf_field(); ?>
                                            <input type="hidden" name="item_id" value="<?php echo (int) $item['id']; ?>">
                                            <input type="hidden" name="status" value="completed">
                                            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700">Tandai Selesai</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="rounded-2xl border border-dashed border-slate-300 bg-white p-8 text-slate-500">Belum ada roadmap. Selesaikan assessment untuk membuat plan belajar.</div>
                <?php endif; ?>
            </div>
        </main>
    </div>
</body>
</html>

