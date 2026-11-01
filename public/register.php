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
    $result = $controller->register($_POST);
    $message = $result['message'];

    if ($result['success']) {
        redirect('login.php');
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
                    <span class="auth-ribbon">Start Your Journey</span>
                    <h1>Buat akun agar bisa mengikuti asesmen dan roadmap belajar.</h1>
                    <p>Daftarkan diri Anda untuk melihat potensi skill, minat karier, serta rekomendasi pengembangan yang relevan dengan masa depan.</p>
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
                    <h2 class="auth-form-title">Daftar</h2>
                    <p class="auth-form-subtitle">Isi identitas Anda untuk memulai.</p>

                    <?php if ($message): ?>
                        <div style="margin-bottom: 16px; background: rgba(239,71,111,0.08); border: 1px solid rgba(239,71,111,0.2); color: #b93f5f; border-radius: 14px; padding: 12px 14px; font-weight:600;">
                            <?php echo e($message); ?>
                        </div>
                    <?php endif; ?>

                    <form method="post" class="form-grid">
                        <?php echo csrf_field(); ?>
                        <div class="form-grid" style="grid-template-columns: 1fr 1fr;">
                            <div class="form-field">
                                <label for="register-name">Nama lengkap</label>
                                <input id="register-name" type="text" name="name" placeholder="Nama lengkap" required>
                            </div>
                            <div class="form-field">
                                <label for="register-nis">NIS</label>
                                <input id="register-nis" type="text" name="nis" placeholder="Contoh: 20241234">
                            </div>
                        </div>

                        <div class="form-grid" style="grid-template-columns: 1fr 1fr;">
                            <div class="form-field">
                                <label for="register-email">Email</label>
                                <input id="register-email" type="email" name="email" placeholder="nama@email.com" required>
                            </div>
                            <div class="form-field">
                                <label for="register-kelas">Kelas</label>
                                <input id="register-kelas" type="text" name="kelas" placeholder="XII RPL 1">
                            </div>
                        </div>

                        <div class="form-grid" style="grid-template-columns: 1fr 1fr;">
                            <div class="form-field">
                                <label for="register-jurusan">Jurusan</label>
                                <select id="register-jurusan" name="jurusan">
                                    <option value="">Pilih jurusan</option>
                                    <option value="RPL">RPL</option>
                                    <option value="PPLG">PPLG</option>
                                    <option value="TKJ">TKJ</option>
                                    <option value="TBSM">TBSM</option>
                                </select>
                            </div>
                            <div class="form-field">
                                <label for="register-password">Password</label>
                                <div class="password-wrap">
                                    <input id="register-password" type="password" name="password" placeholder="Minimal 6 karakter" required>
                                    <button type="button" class="password-toggle" data-toggle-password="register-password">Show</button>
                                </div>
                            </div>
                        </div>

                        <div class="form-field">
                            <label for="register-confirm">Konfirmasi password</label>
                            <div class="password-wrap">
                                <input id="register-confirm" type="password" name="confirm_password" placeholder="Ulangi password" required>
                                <button type="button" class="password-toggle" data-toggle-password="register-confirm">Show</button>
                            </div>
                        </div>

                        <button type="submit" class="auth-submit">Daftar</button>
                    </form>

                    <div class="auth-meta">
                        Sudah punya akun? <a href="login.php">Masuk</a>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="assets/js/app.js?v=20261101"></script>
</body>
</html>

