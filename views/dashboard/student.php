<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Siswa | BaliReady AI</title>
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
                <a href="dashboard.php" class="active">Dashboard</a>
                <a href="assessment.php">Asesmen</a>
                <a href="analysis.php">Minat Karier</a>
                <a href="progress.php">Refleksi Diri</a>
                <a href="roadmap.php">AI Roadmap</a>
                <a href="dashboard.php">Pengaturan</a>
                <a href="logout.php" class="logout">Keluar</a>
            </nav>
        </aside>

        <main class="dashboard-main">
            <div class="dashboard-topbar">
                <div>
                    <p style="margin:0; color: rgba(20,43,80,0.7); font-weight:700;">Halo,</p>
                    <h1>Dwita Safitri</h1>
                </div>
                <a href="assessment.php" class="btn-primary">Mulai Asesmen</a>
            </div>

            <section class="dashboard-grid">
                <article class="metric-card">
                    <div class="label">Skill Mapping</div>
                    <div class="value">75%</div>
                    <div class="caption">+ 4% dari bulan lalu</div>
                </article>
                <article class="metric-card">
                    <div class="label">Career Interest</div>
                    <div class="value">80%</div>
                    <div class="caption">Minat karier sudah jelas</div>
                </article>
                <article class="metric-card">
                    <div class="label">Personal Growth</div>
                    <div class="value">70%</div>
                    <div class="caption">Progress pengembangan diri</div>
                </article>
            </section>

            <section class="content-grid">
                <article class="content-panel">
                    <div style="display:flex; align-items:center; justify-content:space-between; gap:10px; margin-bottom:12px;">
                        <h2 style="margin:0; font-size:1.25rem; font-weight:900; color: var(--dark-navy);">Progress Pengembangan</h2>
                    </div>
                    <div class="progress-line"><span style="width: 75%;"></span></div>
                    <div class="list-activity">
                        <div class="activity-item">
                            <div>
                                <div style="font-weight:800; color: var(--dark-navy);">HTML & CSS</div>
                                <div style="font-size: 0.76rem; color: rgba(20,43,80,0.62);">Minggu ini</div>
                            </div>
                            <span class="status-badge success">75%</span>
                        </div>
                        <div class="activity-item">
                            <div>
                                <div style="font-weight:800; color: var(--dark-navy);">JavaScript</div>
                                <div style="font-size: 0.76rem; color: rgba(20,43,80,0.62);">Minggu ini</div>
                            </div>
                            <span class="status-badge warning">60%</span>
                        </div>
                    </div>
                </article>

                <aside class="notice-card">
                    <h2 style="margin:0; font-size:1.2rem; font-weight:900; color: var(--dark-navy);">Rekomendasi Aktivitas</h2>
                    <div class="notice-list">
                        <div class="notice-item">
                            <span style="font-weight: 700; color: var(--dark-navy);">Belajar CSS Grid</span>
                            <span class="status-badge success">Baik</span>
                        </div>
                        <div class="notice-item">
                            <span style="font-weight: 700; color: var(--dark-navy);">Latihan JS DOM</span>
                            <span class="status-badge warning">Perlu peningkatan</span>
                        </div>
                        <div class="notice-item">
                            <span style="font-weight: 700; color: var(--dark-navy);">Project mini</span>
                            <span class="status-badge danger">Terlambat</span>
                        </div>
                    </div>
                </aside>
            </section>
        </main>
    </div>
    <script src="assets/js/app.js?v=20261101"></script>
</body>
</html>
