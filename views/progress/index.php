<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Progress | BaliReady AI</title>
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
                <a href="roadmap.php" class="block rounded-xl text-slate-600 hover:bg-slate-100 px-4 py-3">Roadmap</a>
                <a href="progress.php" class="block rounded-xl bg-blue-50 text-blue-700 px-4 py-3">Progress</a>
                <a href="logout.php" class="block rounded-xl text-red-600 hover:bg-red-50 px-4 py-3 mt-8">Logout</a>
            </nav>
        </aside>

        <main class="flex-1 p-6 md:p-10">
            <div class="max-w-5xl mx-auto">
                <div class="mb-8">
                    <p class="text-sm text-blue-600 font-semibold">Progress Tracking</p>
                    <h1 class="text-3xl font-bold text-slate-900">Pantau perkembangan belajar</h1>
                </div>

                <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm mb-6">
                    <div class="flex justify-between items-center mb-3">
                        <h2 class="text-xl font-bold">Kemajuan Roadmap</h2>
                        <span class="text-sm text-slate-500"><?php echo e($progress['completed'] ?? 0); ?> / <?php echo e($progress['total'] ?? 0); ?></span>
                    </div>
                    <div class="h-3 w-full rounded-full bg-slate-200 overflow-hidden">
                        <div class="h-full rounded-full bg-blue-600" style="width: <?php echo e($progress['percent'] ?? 0); ?>%"></div>
                    </div>
                    <p class="mt-3 text-sm text-slate-600"><?php echo e($progress['percent'] ?? 0); ?>% selesai.</p>
                </div>

                <div class="grid md:grid-cols-2 gap-6">
                    <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
                        <h3 class="text-lg font-bold mb-4">Kompetensi yang perlu ditingkatkan</h3>
                        <ul class="space-y-3">
                            <li class="flex justify-between text-slate-700"><span>PHP</span><span class="text-amber-600">Prioritas</span></li>
                            <li class="flex justify-between text-slate-700"><span>Database</span><span class="text-amber-600">Prioritas</span></li>
                            <li class="flex justify-between text-slate-700"><span>JavaScript</span><span class="text-slate-500">Sedang</span></li>
                        </ul>
                    </div>

                    <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
                        <h3 class="text-lg font-bold mb-4">Catatan kebiasaan belajar</h3>
                        <ul class="space-y-3 text-slate-700">
                            <li>• Fokus 30 menit setiap hari untuk materi yang dibutuhkan</li>
                            <li>• Ulang kode 2x per minggu untuk memperkuat konsep</li>
                            <li>• Kerjakan mini project sesuai roadmap</li>
                        </ul>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
