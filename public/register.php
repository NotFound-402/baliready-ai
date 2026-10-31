<?php

require_once __DIR__ . '/../app/bootstrap.php';

if (!($pdo instanceof PDO)) {
    http_response_code(500);
    echo 'Database connection error.';
    exit;
}

if (is_logged_in()) {
    redirect('/baliready-ai/public/dashboard.php');
}

$message = null;
$controller = new AuthController($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $result = $controller->register($_POST);
    $message = $result['message'];

    if ($result['success']) {
        redirect('/baliready-ai/public/login.php');
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | BaliReady AI</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 min-h-screen flex items-center justify-center p-6">
    <div class="w-full max-w-md bg-white rounded-3xl shadow-lg border border-slate-200 p-8">
        <div class="text-center mb-8">
            <div class="mx-auto w-12 h-12 rounded-2xl bg-blue-600 text-white font-bold flex items-center justify-center">BR</div>
            <h1 class="mt-4 text-2xl font-bold text-slate-900">Buat akun</h1>
        </div>

        <?php if ($message): ?>
            <div class="mb-4 rounded-xl bg-red-50 border border-red-200 text-red-700 px-4 py-3 text-sm"><?php echo e($message); ?></div>
        <?php endif; ?>

        <form method="post" class="space-y-4">
            <?php echo csrf_field(); ?>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Nama lengkap</label>
                <input type="text" name="name" required class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Masukkan nama lengkap">
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Email</label>
                <input type="email" name="email" required class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="nama@email.com">
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Password</label>
                <input type="password" name="password" required class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Minimal 6 karakter">
            </div>
            <button type="submit" class="w-full rounded-xl bg-blue-600 text-white font-semibold py-3 hover:bg-blue-700">Daftar</button>
        </form>

        <p class="mt-6 text-center text-sm text-slate-600">Sudah punya akun? <a href="login.php" class="text-blue-600 font-medium">Masuk</a></p>
    </div>
</body>
</html>

