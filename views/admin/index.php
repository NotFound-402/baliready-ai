<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | BaliReady AI</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 text-slate-800">
    <div class="min-h-screen p-6 md:p-10">
        <div class="max-w-7xl mx-auto">
            <div class="flex justify-between items-center mb-8">
                <div>
                    <p class="text-sm text-blue-600 font-semibold">Admin Panel</p>
                    <h1 class="text-3xl font-bold">Kelola Soal & Materi</h1>
                </div>
                <a href="logout.php" class="text-red-600 font-medium">Logout</a>
            </div>

            <?php if ($message): ?>
                <div class="mb-6 rounded-xl bg-blue-50 border border-blue-200 text-blue-700 px-4 py-3 text-sm"><?php echo e($message); ?></div>
            <?php endif; ?>

            <div class="grid lg:grid-cols-2 gap-6 mb-8">
                <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
                    <h2 class="text-xl font-bold mb-4">Tambah Pertanyaan Baru</h2>
                    <form method="post" class="space-y-4">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="action" value="add_question">

                        <div>
                            <label class="block text-sm font-medium mb-1">Kompetensi</label>
                            <select name="competency_id" class="w-full rounded-xl border border-slate-300 px-4 py-3">
                                <?php foreach ($competencies ?? [] as $competency): ?>
                                    <option value="<?php echo (int) $competency['id']; ?>"><?php echo e($competency['name']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-1">Tipe</label>
                            <select name="type" class="w-full rounded-xl border border-slate-300 px-4 py-3">
                                <option value="multiple_choice">Pilihan Ganda</option>
                                <option value="coding">Coding</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-1">Judul</label>
                            <input type="text" name="title" required class="w-full rounded-xl border border-slate-300 px-4 py-3">
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-1">Pertanyaan</label>
                            <textarea name="question_text" required rows="3" class="w-full rounded-xl border border-slate-300 px-4 py-3"></textarea>
                        </div>

                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium mb-1">Difficulty</label>
                                <select name="difficulty" class="w-full rounded-xl border border-slate-300 px-4 py-3">
                                    <option value="easy">Easy</option>
                                    <option value="medium">Medium</option>
                                    <option value="hard">Hard</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-1">Poin</label>
                                <input type="number" name="points" value="5" min="1" class="w-full rounded-xl border border-slate-300 px-4 py-3">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-1">Bahasa Coding (opsional)</label>
                            <input type="text" name="programming_language" placeholder="PHP / JavaScript / HTML" class="w-full rounded-xl border border-slate-300 px-4 py-3">
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-1">Starter Code</label>
                            <textarea name="starter_code" rows="5" class="w-full rounded-xl border border-slate-300 px-4 py-3" placeholder="Kode awal untuk soal coding."></textarea>
                        </div>

                        <div class="grid md:grid-cols-2 gap-4">
                            <?php foreach (['A', 'B', 'C', 'D'] as $label): ?>
                                <div>
                                    <label class="block text-sm font-medium mb-1">Pilihan <?php echo e($label); ?></label>
                                    <input type="text" name="option_<?php echo strtolower($label); ?>" class="w-full rounded-xl border border-slate-300 px-4 py-3">
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-1">Jawaban Benar</label>
                            <select name="correct_option" class="w-full rounded-xl border border-slate-300 px-4 py-3">
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="C">C</option>
                                <option value="D">D</option>
                            </select>
                        </div>

                        <button type="submit" class="w-full bg-blue-600 text-white rounded-xl py-3 font-semibold hover:bg-blue-700">Simpan Pertanyaan</button>
                    </form>
                </div>

                <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
                    <h2 class="text-xl font-bold mb-4">Tambah Materi Belajar</h2>
                    <form method="post" class="space-y-4">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="action" value="add_material">

                        <div>
                            <label class="block text-sm font-medium mb-1">Kompetensi</label>
                            <select name="competency_id" class="w-full rounded-xl border border-slate-300 px-4 py-3">
                                <?php foreach ($competencies ?? [] as $competency): ?>
                                    <option value="<?php echo (int) $competency['id']; ?>"><?php echo e($competency['name']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-1">Judul materi</label>
                            <input type="text" name="title" required class="w-full rounded-xl border border-slate-300 px-4 py-3">
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-1">Deskripsi</label>
                            <textarea name="description" rows="3" class="w-full rounded-xl border border-slate-300 px-4 py-3"></textarea>
                        </div>

                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium mb-1">Tipe materi</label>
                                <select name="material_type" class="w-full rounded-xl border border-slate-300 px-4 py-3">
                                    <option value="article">Article</option>
                                    <option value="video">Video</option>
                                    <option value="practice">Practice</option>
                                    <option value="project">Project</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-1">Est. menit</label>
                                <input type="number" name="estimated_minutes" value="30" class="w-full rounded-xl border border-slate-300 px-4 py-3">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-1">URL</label>
                            <input type="url" name="url" class="w-full rounded-xl border border-slate-300 px-4 py-3">
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-1">Difficulty</label>
                            <select name="difficulty" class="w-full rounded-xl border border-slate-300 px-4 py-3">
                                <option value="easy">Easy</option>
                                <option value="medium">Medium</option>
                                <option value="hard">Hard</option>
                            </select>
                        </div>

                        <button type="submit" class="w-full bg-slate-900 text-white rounded-xl py-3 font-semibold hover:bg-slate-800">Simpan Materi</button>
                    </form>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
                <h2 class="text-xl font-bold mb-4">Daftar Pertanyaan</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr class="border-b border-slate-200 text-left text-slate-600">
                                <th class="py-2 pr-3">Judul</th>
                                <th class="py-2 pr-3">Kompetensi</th>
                                <th class="py-2 pr-3">Tipe</th>
                                <th class="py-2 pr-3">Difficulty</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($questions ?? [] as $question): ?>
                                <tr class="border-b border-slate-100">
                                    <td class="py-3 pr-3"><?php echo e($question['title']); ?></td>
                                    <td class="py-3 pr-3"><?php echo e($question['competency_name']); ?></td>
                                    <td class="py-3 pr-3"><?php echo e($question['type']); ?></td>
                                    <td class="py-3 pr-3"><?php echo e($question['difficulty']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
