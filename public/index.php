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
    <link rel="stylesheet" href="assets/css/style.css?v=20261101">
</head>
<body>
    <div class="site-shell">
        <header class="topbar">
            <div class="brand-chip">
                <span class="logo-mark">BR</span>
                <div>
                    <div style="font-size: 1.2rem; font-weight: 900; color: var(--dark-navy);">BaliReady AI</div>
                </div>
            </div>

            <nav class="topbar-nav" aria-label="Navigasi utama">
                <a href="index.php">Beranda</a>
                <a href="#features">Tentang</a>
                <a href="#career">Fitur</a>
                <a href="#faq">FAQ</a>
            </nav>

            <div class="topbar-actions">
                <a class="btn-secondary" href="login.php">Login</a>
                <a class="btn-primary" href="register.php">Daftar</a>
            </div>
        </header>

        <main class="hero-panel">
            <div class="hero-layer"></div>
            <div class="hero-grid">
                <div class="hero-copy">
                    <span class="hero-kicker">AI Web Innovation Challenge 2026</span>
                    <h1 class="hero-title">Kenali Potensimu,<br>Siapkan Masa Depanmu.</h1>
                    <p class="hero-text">Bersama BaliReady AI, temukan minat, kemampuan, dan potensi kariermu dengan asesmen yang personal, AI-guided, dan mudah dipahami.</p>
                    <div class="hero-actions">
                        <a class="btn-primary" href="register.php">Mulai Sekarang</a>
                        <a class="btn-secondary" href="login.php">Saya Sudah Punya Akun</a>
                    </div>
                    <div class="hero-meta">
                        <div><strong>5</strong> Kompetensi</div>
                        <div><strong>30 Hari</strong> Roadmap</div>
                        <div><strong>AI</strong> Insight</div>
                    </div>
                </div>

                <div class="hero-visual">
                    <div class="hero-figure">
                        <div class="hero-sun"></div>
                        <div class="hero-card hero-card--tiny">
                            <div style="font-size: 0.7rem; color: rgba(20,43,80,0.65); letter-spacing: 0.12em; text-transform: uppercase; font-weight: 800;">Skill Mapping</div>
                            <div style="font-size: 2rem; font-weight: 900; color: var(--dark-navy); margin-top: 10px;">75%</div>
                            <div style="font-size: 0.75rem; color: rgba(20,43,80,0.7);">Profesional</div>
                        </div>
                        <div class="lead-people" aria-hidden="true">
                            <div class="person person--left">
                                <div class="hair"></div>
                                <div class="head"></div>
                                <div class="arm"></div>
                                <div class="body"></div>
                            </div>
                            <div class="person person--right">
                                <div class="hair"></div>
                                <div class="head"></div>
                                <div class="arm"></div>
                                <div class="body"></div>
                            </div>
                        </div>
                        <div class="hero-card hero-card--metric">
                            <div style="font-size: 0.72rem; text-transform: uppercase; letter-spacing: 0.11em; color: rgba(20,43,80,0.7); font-weight: 800;">AI Roadmap</div>
                            <div style="font-size: 1.5rem; font-weight: 900; color: var(--dark-navy); margin-top: 6px;">82%</div>
                            <div style="font-size: 0.75rem; color: rgba(20,43,80,0.7); margin-top: 4px;">Potensi berkembang</div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <section id="features" class="feature-grid" style="margin-top: 26px;">
            <article class="feature-card">
                <div class="feature-badge">↗</div>
                <h3 style="font-size: 1.25rem; font-weight: 900; color: var(--dark-navy); margin: 0 0 8px;">Skill Mapping</h3>
                <p style="margin: 0; color: rgba(20,43,80,0.68); line-height: 1.7;">Uji kemampuanmu secara bertahap dan identifikasi area yang paling kuat.</p>
            </article>
            <article class="feature-card">
                <div class="feature-badge">◎</div>
                <h3 style="font-size: 1.25rem; font-weight: 900; color: var(--dark-navy); margin: 0 0 8px;">Career Interest</h3>
                <p style="margin: 0; color: rgba(20,43,80,0.68); line-height: 1.7;">Cocokkan bakat dan minat dengan pilihan karier yang relevan untuk masa depan.</p>
            </article>
            <article class="feature-card">
                <div class="feature-badge">✦</div>
                <h3 style="font-size: 1.25rem; font-weight: 900; color: var(--dark-navy); margin: 0 0 8px;">Personal Growth</h3>
                <p style="margin: 0; color: rgba(20,43,80,0.68); line-height: 1.7;">Pantau progres diri dan fokus pada pengembangan kemampuan harian.</p>
            </article>
            <article class="feature-card">
                <div class="feature-badge">AI</div>
                <h3 style="font-size: 1.25rem; font-weight: 900; color: var(--dark-navy); margin: 0 0 8px;">AI Roadmap</h3>
                <p style="margin: 0; color: rgba(20,43,80,0.68); line-height: 1.7;">Dapatkan rekomendasi belajar personal serta roadmap 30 hari yang jelas.</p>
            </article>
        </section>

        <section id="career" class="landing-layout">
            <article class="board-item board-item--blue">
                <div class="board-header">
                    <div style="font-size: 1.15rem; font-weight: 900; color: var(--dark-navy);">Dashboard Siswa</div>
                    <div class="preview-tabs">
                        <span class="preview-dot preview-dot--blue"></span>
                        <span class="preview-dot"></span>
                        <span class="preview-dot"></span>
                    </div>
                </div>
                <div class="dashboard-mini">
                    <div class="stat-row">
                        <div class="stat-box">
                            <div class="label">Skill Mapping</div>
                            <div class="num">75%</div>
                        </div>
                        <div class="stat-box">
                            <div class="label">Career</div>
                            <div class="num">80%</div>
                        </div>
                        <div class="stat-box">
                            <div class="label">Growth</div>
                            <div class="num">70%</div>
                        </div>
                    </div>
                    <div class="chart-mini" aria-hidden="true">
                        <svg viewBox="0 0 250 120" preserveAspectRatio="none">
                            <path d="M0 90 C 50 72, 90 40, 120 60 S 190 65, 250 20" fill="none" stroke="#1769D2" stroke-width="4" stroke-linecap="round"/>
                            <path d="M0 90 C 50 72, 90 40, 120 60 S 190 65, 250 20 L250 120 L0 120Z" fill="rgba(23,105,210,0.08)"/>
                        </svg>
                    </div>
                    <div class="data-box">
                        <div style="font-size: 0.78rem; letter-spacing: 0.11em; text-transform: uppercase; color: rgba(20,43,80,0.66); font-weight: 800;">Rekomendasi</div>
                        <div style="font-weight: 800; margin-top: 6px; color: var(--dark-navy);">Lanjutkan latihan HTML & CSS</div>
                    </div>
                </div>
            </article>

            <article class="board-item">
                <div class="board-header">
                    <div style="font-size: 1.15rem; font-weight: 900; color: var(--dark-navy);">Halaman Asesmen</div>
                    <div class="preview-tabs">
                        <span class="preview-dot preview-dot--blue"></span>
                        <span class="preview-dot"></span>
                        <span class="preview-dot"></span>
                    </div>
                </div>
                <div class="assessment-mini">
                    <div style="font-size: 0.72rem; letter-spacing: 0.12em; text-transform: uppercase; color: rgba(20,43,80,0.67); font-weight: 800;">Tes HTML</div>
                    <div class="question-steps">
                        <span class="step-pill active">1</span>
                        <span class="step-pill">2</span>
                        <span class="step-pill">3</span>
                        <span class="step-pill">4</span>
                    </div>
                    <div class="data-box">
                        <div style="font-weight: 800; color: var(--dark-navy);">Apa fungsi tag &lt;div&gt; dalam HTML?</div>
                    </div>
                    <div class="answer-list">
                        <label class="answer-option"><input type="radio" name="mini-quiz" checked> <span>Membuat tabel</span></label>
                        <label class="answer-option"><input type="radio" name="mini-quiz"> <span>Membungkus elemen</span></label>
                        <label class="answer-option"><input type="radio" name="mini-quiz"> <span>Menambah gambar</span></label>
                    </div>
                </div>
            </article>

            <article class="board-item">
                <div class="board-header">
                    <div style="font-size: 1.15rem; font-weight: 900; color: var(--dark-navy);">Hasil Analisis AI</div>
                    <div class="preview-tabs">
                        <span class="preview-dot preview-dot--blue"></span>
                        <span class="preview-dot"></span>
                        <span class="preview-dot"></span>
                    </div>
                </div>
                <div class="data-box" style="margin-top: 12px;">
                    <div style="font-size: 0.72rem; text-transform: uppercase; letter-spacing: 0.12em; color: rgba(20,43,80,0.7); font-weight: 800;">Potensi</div>
                    <div style="font-weight: 800; color: var(--dark-navy); margin-top: 8px;">Potensi sangat cocok di bidang Web Developer.</div>
                </div>
                <ul class="list-plain" style="margin-top: 16px;">
                    <li><span class="dot"></span><span>Pelajari dasar React.js untuk mempercepat pengembangan UI.</span></li>
                    <li><span class="dot"></span><span>Latihan membuat project mini seperti landing page dan form.</span></li>
                    <li><span class="dot"></span><span>Tingkatkan kemampuan problem solving agar lebih siap kerja.</span></li>
                </ul>
            </article>

            <article class="board-item">
                <div class="board-header">
                    <div style="font-size: 1.15rem; font-weight: 900; color: var(--dark-navy);">Dashboard Guru BK</div>
                    <div class="preview-tabs">
                        <span class="preview-dot preview-dot--blue"></span>
                        <span class="preview-dot"></span>
                        <span class="preview-dot"></span>
                    </div>
                </div>
                <div class="teacher-mini">
                    <div class="teacher-row">
                        <div style="display:flex; align-items:center; gap:10px; align-items:center;">
                            <div class="avatar"></div>
                            <div>
                                <div style="font-weight: 800; color: var(--dark-navy);">Ibu Sari</div>
                                <div style="font-size: 0.75rem; color: rgba(20,43,80,0.6);">Guru BK</div>
                            </div>
                        </div>
                        <span class="status-badge success">Online</span>
                    </div>
                    <div class="stat-row">
                        <div class="stat-box">
                            <div class="label">Siswa</div>
                            <div class="num">324</div>
                        </div>
                        <div class="stat-box">
                            <div class="label">Selesai</div>
                            <div class="num">278</div>
                        </div>
                    </div>
                    <div class="data-box">
                        <div style="font-size: 0.72rem; text-transform: uppercase; letter-spacing: 0.11em; color: rgba(20,43,80,0.7); font-weight: 800;">Status</div>
                        <div style="margin-top: 8px; font-weight: 800; color: var(--dark-navy);">Baik : 70% | Sedang : 20% | Perlu Perhatian : 10%</div>
                    </div>
                </div>
            </article>
        </section>

        <section id="faq" style="margin-top: 32px; padding-bottom: 26px;">
            <div style="display:flex; align-items:center; justify-content:space-between; gap:12px; margin-bottom:18px;">
                <h2 class="section-title" style="margin:0;">FAQ</h2>
            </div>
            <div style="display:grid; gap:12px; max-width: 900px;">
                <div class="notice-card">
                    <button type="button" class="faq-button" data-faq-trigger aria-expanded="false">Apa itu BaliReady AI?</button>
                    <div class="faq-content" style="display:none; margin-top:12px; color: rgba(20,43,80,0.7); line-height: 1.7;">BaliReady AI adalah platform asesmen skill, minat karier, dan roadmap pembelajaran yang dirancang khusus untuk siswa SMK di Indonesia.</div>
                </div>
                <div class="notice-card">
                    <button type="button" class="faq-button" data-faq-trigger aria-expanded="false">Apakah hasilnya bisa dipantau guru BK?</button>
                    <div class="faq-content" style="display:none; margin-top:12px; color: rgba(20,43,80,0.7); line-height: 1.7;">Ya, dashboard guru BK menampilkan ringkasan siswa, status perkembangan, dan indikator performa yang relevan.</div>
                </div>
                <div class="notice-card">
                    <button type="button" class="faq-button" data-faq-trigger aria-expanded="false">Apakah platform cocok untuk siswa RPL/PPLG?</button>
                    <div class="faq-content" style="display:none; margin-top:12px; color: rgba(20,43,80,0.7); line-height: 1.7;">Sangat cocok, karena asesmen dan roadmap dibuat sesuai dengan kebutuhan kompetensi teknologi dan karier digital.</div>
                </div>
            </div>
        </section>

        <footer style="padding: 18px 0 32px; color: rgba(20,43,80,0.72); border-top: 1px solid rgba(16,45,89,0.08);">
            <div style="display:flex; align-items:center; justify-content:space-between; gap:16px; flex-wrap:wrap;">
                <div class="brand-chip">
                    <span class="logo-mark">BR</span>
                    <strong>BaliReady AI</strong>
                </div>
                <div>© 2026 BaliReady AI</div>
            </div>
        </footer>
    </div>

    <script src="assets/js/app.js?v=20261101"></script>
</body>
</html>

