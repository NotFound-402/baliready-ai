<?php

require_once __DIR__ . '/../app/bootstrap.php';

if (!($pdo instanceof PDO)) {
    http_response_code(500);
    echo 'Database connection error.';
    exit;
}

if (is_logged_in()) {
    redirect('dashboard.php');
}

$message = null;
$controller = new AuthController($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $result = $controller->login($_POST);
    $message = $result['message'];

    if ($result['success']) {
        redirect('dashboard.php');
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | BaliReady AI</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="assets/css/style.css?v=20261101">
</head>
<body>
    <div class="auth-shell">
        <div class="auth-card">
            <aside class="auth-panel-left">
                <div class="auth-brand">
                    <span class="logo-mark">BR</span>
                    <span>BaliReady AI</span>
                </div>

                <div class="auth-copy">
                    <span class="auth-ribbon">AI Learning Companion</span>
                    <h1>Masuk ke platform karier & skill kamu.</h1>
                    <p>Ikuti asesmen, lihat hasil analisis AI, dan kelola roadmap belajar yang sesuai potensi diri.</p>
                </div>

                <div class="bali-scene" aria-hidden="true">
                    <div class="roof r1"></div>
                    <div class="roof r2"></div>
                    <div class="roof r3"></div>
                    <div class="pilar"></div>
                    <div class="pilar"></div>
                    <div class="pilar"></div>
                    <div class="pilar"></div>
                </div>
            </aside>

            <main class="auth-panel-right">
                <div class="inner">
                    <div class="auth-brand" style="font-size: 2.1rem; justify-content: flex-start;">
                        <span class="logo-mark">BR</span>
                        <span>BaliReady AI</span>
                    </div>
                    <h2 class="auth-form-title">Masuk</h2>
                    <p class="auth-form-subtitle">Silakan masuk untuk melanjutkan perjalanan belajar.</p>

                    <?php if ($message): ?>
                        <div style="margin-bottom: 16px; background: rgba(239,71,111,0.08); border: 1px solid rgba(239,71,111,0.2); color: #b93f5f; border-radius: 14px; padding: 12px 14px; font-weight:600;">
                            <?php echo e($message); ?>
                        </div>
                    <?php endif; ?>

                    <div class="role-tabs" aria-label="Pilihan role">
                        <button type="button" class="role-tab active">Siswa</button>
                        <button type="button" class="role-tab">Guru BK</button>
                    </div>

                    <form method="post" class="form-grid">
                        <?php echo csrf_field(); ?>
                        <div class="form-field">
                            <label for="login-email">Email</label>
                            <input id="login-email" type="email" name="email" placeholder="nama@email.com" required>
                        </div>

                        <div class="form-field">
                            <label for="login-password">Password</label>
                            <div class="password-wrap">
                                <input id="login-password" type="password" name="password" placeholder="Masukkan password" required>
                                <button type="button" class="password-toggle" data-toggle-password="login-password">Show</button>
                            </div>
                        </div>

                        <button type="submit" class="auth-submit">Login</button>
                    </form>

                    <div class="auth-meta">
                        Belum punya akun? <a href="register.php">Daftar</a>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="assets/js/app.js?v=20261101"></script>
</body>
</html>

