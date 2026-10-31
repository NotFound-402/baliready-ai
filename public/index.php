<?php

require_once __DIR__ . '/../app/bootstrap.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BaliReady AI</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 text-slate-800">
    <header class="bg-white shadow-sm border-b border-slate-200">
        <div class="max-w-6xl mx-auto px-6 py-4 flex justify-between items-center">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-blue-600 text-white font-bold flex items-center justify-center">BR</div>
                <div>
                    <div class="font-bold text-lg">BaliReady AI</div>
                    <div class="text-xs text-slate-500">Assessment & Roadmap Learning</div>
                </div>
            </div>
            <nav class="hidden md:flex gap-6 text-sm font-medium">
                <a href="#features" class="text-slate-600 hover:text-blue-600">Fitur</a>
                <a href="#about" class="text-slate-600 hover:text-blue-600">Tentang</a>
                <a href="#pricing" class="text-slate-600 hover:text-blue-600">Cara Kerja</a>
            </nav>
            <div class="flex gap-3">
                <a href="login.php" class="px-4 py-2 text-sm font-medium text-blue-600 border border-blue-200 rounded-lg hover:bg-blue-50">Masuk</a>
                <a href="register.php" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700">Daftar</a>
            </div>
        </div>
    </header>

    <main>
        <section class="max-w-6xl mx-auto px-6 py-16 grid md:grid-cols-2 gap-12 items-center">
            <div>
                <span class="inline-block px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-xs font-semibold">AI Web Innovation Challenge 2026</span>
                <h1 class="mt-6 text-4xl md:text-5xl font-black leading-tight text-slate-900">Uji kemampuan teknologimu dan raih roadmap belajar personal.</h1>
                <p class="mt-5 text-lg text-slate-600">BaliReady AI membantu siswa kelas 12 jurusan RPL/PPLG mengukur kemampuan teknis, mendapatkan insight AI, dan memantau progres belajar harian.</p>
                <div class="mt-8 flex gap-4">
                    <a href="register.php" class="px-6 py-3 rounded-xl bg-blue-600 text-white font-semibold hover:bg-blue-700">Mulai Sekarang</a>
                    <a href="login.php" class="px-6 py-3 rounded-xl border border-slate-200 bg-white text-slate-700 font-semibold hover:bg-slate-100">Saya Sudah Punya Akun</a>
                </div>
                <div class="mt-8 flex items-center gap-8 text-sm text-slate-500">
                    <div><span class="font-bold text-slate-900">5</span> Kompetensi</div>
                    <div><span class="font-bold text-slate-900">30 Hari</span> Roadmap</div>
                    <div><span class="font-bold text-slate-900">AI</span> Insight</div>
                </div>
            </div>
            <div class="bg-white rounded-3xl shadow-lg p-6 border border-slate-200">
                <div class="grid gap-4">
                    <div class="rounded-2xl bg-blue-50 p-4">
                        <div class="text-xs uppercase text-blue-600 font-semibold">Ringkasan assessment</div>
                        <div class="mt-3 text-3xl font-black text-slate-900">82%</div>
                        <div class="text-sm text-slate-600">Kemampuan pemrograman yang berkembang baik</div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-slate-50 rounded-2xl p-4">
                            <div class="text-xs text-slate-500">HTML & CSS</div>
                            <div class="mt-2 text-xl font-bold">88</div>
                        </div>
                        <div class="bg-slate-50 rounded-2xl p-4">
                            <div class="text-xs text-slate-500">JavaScript</div>
                            <div class="mt-2 text-xl font-bold">75</div>
                        </div>
                        <div class="bg-slate-50 rounded-2xl p-4">
                            <div class="text-xs text-slate-500">PHP</div>
                            <div class="mt-2 text-xl font-bold">79</div>
                        </div>
                        <div class="bg-slate-50 rounded-2xl p-4">
                            <div class="text-xs text-slate-500">Database</div>
                            <div class="mt-2 text-xl font-bold">70</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="features" class="max-w-6xl mx-auto px-6 py-10">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-bold">Fitur utama</h2>
            </div>
            <div class="grid md:grid-cols-3 gap-6">
                <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
                    <div class="text-blue-600 text-2xl mb-3">✓</div>
                    <h3 class="font-bold text-lg">Assessment berbasis kompetensi</h3>
                    <p class="mt-2 text-slate-600">Pilihan ganda dan coding challenge yang sesuai dengan kurikulum RPL/PPLG.</p>
                </div>
                <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
                    <div class="text-blue-600 text-2xl mb-3">AI</div>
                    <h3 class="font-bold text-lg">Analisis personal</h3>
                    <p class="mt-2 text-slate-600">Mendapatkan ringkasan, kekuatan, kelemahan, dan rekomendasi berdasarkan skor assessment.</p>
                </div>
                <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
                    <div class="text-blue-600 text-2xl mb-3">📈</div>
                    <h3 class="font-bold text-lg">Roadmap 30 hari</h3>
                    <p class="mt-2 text-slate-600">Rencana belajar yang konkret dengan materi, estimasi waktu, dan progres harian.</p>
                </div>
            </div>
        </section>
    </main>
</body>
</html>

