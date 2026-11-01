<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Guru BK | BaliReady AI</title>
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
                    <div style="font-weight:900; font-size:1.05rem;">Ibu Sari</div>
                    <div style="font-size: 0.76rem; color: rgba(255,255,255,0.7);">Guru BK</div>
                </div>
            </div>

            <nav class="menu">
                <a href="dashboard.php" class="active">Dashboard</a>
                <a href="progress.php">Siswa</a>
                <a href="analysis.php">Laporan</a>
                <a href="roadmap.php">Notifikasi</a>
                <a href="dashboard.php">Pengaturan</a>
                <a href="logout.php" class="logout">Keluar</a>
            </nav>
        </aside>

        <main class="dashboard-main">
            <div class="dashboard-topbar">
                <div>
                    <p style="margin:0; color: rgba(20,43,80,0.7); font-weight:700;">Overview</p>
                    <h1>Dashboard Guru BK</h1>
                </div>
                <a href="analysis.php" class="btn-primary">Cetak Laporan</a>
            </div>

            <section class="teacher-summary">
                <article class="metric-card">
                    <div class="label">Total Siswa</div>
                    <div class="value">324</div>
                    <div class="caption">Siswa aktif</div>
                </article>
                <article class="metric-card">
                    <div class="label">Selesai Asesmen</div>
                    <div class="value">278</div>
                    <div class="caption">85.8%</div>
                </article>
                <article class="metric-card">
                    <div class="label">Notifikasi</div>
                    <div class="value">02</div>
                    <div class="caption">Perlu perhatian</div>
                </article>
                <article class="metric-card">
                    <div class="label">Status</div>
                    <div class="value">Baik</div>
                    <div class="caption">70% siswa stabil</div>
                </article>
            </section>

            <section class="content-grid">
                <article class="content-panel">
                    <h2 style="margin:0 0 16px; font-size:1.2rem; font-weight:900; color: var(--dark-navy);">Status Perkembangan</h2>
                    <div class="chart-mini" aria-hidden="true">
                        <svg viewBox="0 0 250 120" preserveAspectRatio="none">
                            <path d="M0 90 C 60 80, 90 50, 130 70 S 200 35, 250 20" fill="none" stroke="#1769D2" stroke-width="4" stroke-linecap="round"/>
                            <path d="M0 90 C 60 80, 90 50, 130 70 S 200 35, 250 20 L250 120 L0 120Z" fill="rgba(23,105,210,0.08)"/>
                        </svg>
                    </div>
                    <div class="notice-list" style="margin-top: 16px;">
                        <div class="notice-item"><span>Baik</span><span class="status-badge success">70%</span></div>
                        <div class="notice-item"><span>Sedang</span><span class="status-badge warning">20%</span></div>
                        <div class="notice-item"><span>Perlu perhatian</span><span class="status-badge danger">10%</span></div>
                    </div>
                </article>

                <aside class="notice-card">
                    <h2 style="margin:0; font-size:1.2rem; font-weight:900; color: var(--dark-navy);">Ringkasan</h2>
                    <div class="notice-list">
                        <div class="notice-item">
                            <span>Penilaian asesmen</span>
                            <span class="status-badge success">Selesai</span>
                        </div>
                        <div class="notice-item">
                            <span>Progress siswa</span>
                            <span class="status-badge warning">Sedang diawasi</span>
                        </div>
                        <div class="notice-item">
                            <span>Notifikasi</span>
                            <span class="status-badge danger">2 item</span>
                        </div>
                    </div>
                </aside>
            </section>

            <section class="table-card">
                <table>
                    <thead>
                        <tr>
                            <th>Nama Siswa</th>
                            <th>Kelas</th>
                            <th>Progress</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Dewi Putri</td>
                            <td>XII RPL 1</td>
                            <td>78%</td>
                            <td><span class="status-badge success">Baik</span></td>
                        </tr>
                        <tr>
                            <td>Made Prasetya</td>
                            <td>XII PPLG 2</td>
                            <td>62%</td>
                            <td><span class="status-badge warning">Sedang</span></td>
                        </tr>
                        <tr>
                            <td>Raka Satria</td>
                            <td>XII RPL 3</td>
                            <td>45%</td>
                            <td><span class="status-badge danger">Perlu perhatian</span></td>
                        </tr>
                    </tbody>
                </table>
            </section>
        </main>
    </div>
    <script src="assets/js/app.js?v=20261101"></script>
</body>
</html>
