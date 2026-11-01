<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Progress Tracking | BaliReady AI</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="assets/css/style.css?v=20261101">
</head>
<body>
    <div class="dashboard-shell">
        <aside class="dashboard-sidebar">
            <div class="brand">
                <span class="logo-mark">BR</span>
                <span>BaliReady AI</span>
            </div>

            <div class="profile-box">
                <div class="avatar" style="width:52px; height:52px; background:linear-gradient(135deg,#e7f0ff,#b9d1ff);"></div>
                <div>
                    <div style="font-weight:900; font-size:1.05rem;">Dwita Safitri</div>
                    <div style="font-size: 0.76rem; color: rgba(255,255,255,0.7);">XII RPL 1</div>
                </div>
            </div>

            <nav class="menu">
                <a href="dashboard.php">Dashboard</a>
                <a href="assessment.php">Asesmen</a>
                <a href="analysis.php">Minat Karier</a>
                <a href="roadmap.php">AI Roadmap</a>
                <a href="progress.php" class="active">Progress</a>
                <a href="dashboard.php">Pengaturan</a>
                <a href="logout.php" class="logout">Keluar</a>
            </nav>
        </aside>

        <main class="dashboard-main">
            <div class="dashboard-topbar">
                <div>
                    <p style="margin:0; color: rgba(20,43,80,0.7); font-weight:700;">Progress Tracking</p>
                    <h1>Pantau perkembangan belajar</h1>
                </div>
                <span class="status-badge success"><?php echo e($progress['percent'] ?? 0); ?>% selesai</span>
            </div>

            <section class="content-grid">
                <article class="content-panel">
                    <h2 style="margin:0 0 12px; font-size:1.25rem; font-weight:900; color: var(--dark-navy);">Kemajuan Roadmap</h2>
                    <div class="progress-line"><span style="width: <?php echo e($progress['percent'] ?? 0); ?>%;"></span></div>
                    <div class="notice-list" style="margin-top: 18px;">
                        <div class="notice-item">
                            <span style="font-weight:700; color: var(--dark-navy);">Tuntas</span>
                            <span class="status-badge success"><?php echo e($progress['completed'] ?? 0); ?> item</span>
                        </div>
                        <div class="notice-item">
                            <span style="font-weight:700; color: var(--dark-navy);">Total roadmap</span>
                            <span class="status-badge warning"><?php echo e($progress['total'] ?? 0); ?> item</span>
                        </div>
                    </div>
                </article>

                <aside class="notice-card">
                    <h2 style="margin:0; font-size:1.2rem; font-weight:900; color: var(--dark-navy);">Kompetensi prioritas</h2>
                    <div class="notice-list">
                        <div class="notice-item">
                            <span style="font-weight:700; color: var(--dark-navy);">PHP</span>
                            <span class="status-badge warning">Prioritas</span>
                        </div>
                        <div class="notice-item">
                            <span style="font-weight:700; color: var(--dark-navy);">Database</span>
                            <span class="status-badge warning">Prioritas</span>
                        </div>
                        <div class="notice-item">
                            <span style="font-weight:700; color: var(--dark-navy);">JavaScript</span>
                            <span class="status-badge success">Sedang</span>
                        </div>
                    </div>
                </aside>
            </section>

            <section class="content-grid" style="margin-top:18px;">
                <article class="content-panel">
                    <h2 style="margin:0 0 12px; font-size:1.25rem; font-weight:900; color: var(--dark-navy);">Catatan kebiasaan belajar</h2>
                    <div class="list-activity">
                        <div class="activity-item">
                            <div>
                                <div style="font-weight:800; color: var(--dark-navy);">Latihan 30 menit</div>
                                <div style="font-size: 0.76rem; color: rgba(20,43,80,0.62);">Fokus pada topik hari ini</div>
                            </div>
                            <span class="status-badge success">Aktif</span>
                        </div>
                        <div class="activity-item">
                            <div>
                                <div style="font-weight:800; color: var(--dark-navy);">Review kode</div>
                                <div style="font-size: 0.76rem; color: rgba(20,43,80,0.62);">2 kali per minggu</div>
                            </div>
                            <span class="status-badge warning">Rutin</span>
                        </div>
                        <div class="activity-item">
                            <div>
                                <div style="font-weight:800; color: var(--dark-navy);">Mini project</div>
                                <div style="font-size: 0.76rem; color: rgba(20,43,80,0.62);">Sesuai roadmap</div>
                            </div>
                            <span class="status-badge success">Baik</span>
                        </div>
                    </div>
                </article>

                <aside class="notice-card">
                    <h2 style="margin:0; font-size:1.2rem; font-weight:900; color: var(--dark-navy);">Target minggu ini</h2>
                    <div class="notice-list">
                        <div class="notice-item">
                            <span style="font-weight:700; color: var(--dark-navy);">Menyelesaikan layout CSS</span>
                            <span class="status-badge success">Ready</span>
                        </div>
                        <div class="notice-item">
                            <span style="font-weight:700; color: var(--dark-navy);">Praktik DOM JavaScript</span>
                            <span class="status-badge warning">Proses</span>
                        </div>
                        <div class="notice-item">
                            <span style="font-weight:700; color: var(--dark-navy);">Analisis project mini</span>
                            <span class="status-badge danger">Belum</span>
                        </div>
                    </div>
                </aside>
            </section>
        </main>
    </div>

    <script src="assets/js/app.js?v=20261101"></script>
</body>
</html>
