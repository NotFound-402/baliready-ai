-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 01, 2026 at 10:47 AM
-- Server version: 8.4.3
-- PHP Version: 8.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `baliready_ai`
--

-- --------------------------------------------------------

--
-- Table structure for table `ai_analyses`
--

CREATE TABLE `ai_analyses` (
  `id` bigint UNSIGNED NOT NULL,
  `session_id` bigint UNSIGNED NOT NULL,
  `summary` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `strengths` json DEFAULT NULL,
  `weaknesses` json DEFAULT NULL,
  `recommendations` json DEFAULT NULL,
  `raw_response` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ai_analyses`
--

INSERT INTO `ai_analyses` (`id`, `session_id`, `summary`, `strengths`, `weaknesses`, `recommendations`, `raw_response`, `created_at`) VALUES
(1, 1, 'AI fallback aktif karena API Gemini belum dikonfigurasi atau gagal merespons. Hasil ini dibuat dari skor assessment yang tersedia.', '[\"Pemecahan masalah dasar\"]', '[\"HTML & CSS\", \"JavaScript\", \"PHP\", \"Database\", \"Programming Logic\"]', '[\"Tingkatkan latihan soal secara bertahap dan fokus pada kompetensi dengan skor terendah.\", \"Pelajari materi yang relevan dalam 30 hari berikutnya dan ulangi checkpoint setiap minggu.\", \"Bangun proyek mini untuk menerapkan konsep yang dipelajari secara nyata.\"]', '{\"summary\":\"AI fallback aktif karena API Gemini belum dikonfigurasi atau gagal merespons. Hasil ini dibuat dari skor assessment yang tersedia.\",\"strengths\":[\"Pemecahan masalah dasar\"],\"weaknesses\":[\"HTML & CSS\",\"JavaScript\",\"PHP\",\"Database\",\"Programming Logic\"],\"recommendations\":[\"Tingkatkan latihan soal secara bertahap dan fokus pada kompetensi dengan skor terendah.\",\"Pelajari materi yang relevan dalam 30 hari berikutnya dan ulangi checkpoint setiap minggu.\",\"Bangun proyek mini untuk menerapkan konsep yang dipelajari secara nyata.\"],\"project_ideas\":[\"Buat landing page porto digital dengan HTML, CSS, dan JavaScript.\",\"Bangun fitur login dan dashboard sederhana dengan PHP + MySQL.\",\"Rancang aplikasi mini CRUD untuk data siswa atau produk.\"]}', '2026-10-31 16:56:21');

-- --------------------------------------------------------

--
-- Table structure for table `answers`
--

CREATE TABLE `answers` (
  `id` bigint UNSIGNED NOT NULL,
  `session_id` bigint UNSIGNED NOT NULL,
  `question_id` bigint UNSIGNED NOT NULL,
  `selected_option_id` bigint UNSIGNED DEFAULT NULL,
  `code_submission` mediumtext COLLATE utf8mb4_unicode_ci,
  `is_correct` tinyint(1) DEFAULT NULL,
  `score` decimal(6,2) NOT NULL DEFAULT '0.00',
  `submitted_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `answers`
--

INSERT INTO `answers` (`id`, `session_id`, `question_id`, `selected_option_id`, `code_submission`, `is_correct`, `score`, `submitted_at`) VALUES
(1, 1, 1, 1, NULL, 0, 0.00, '2026-11-01 00:56:21'),
(2, 1, 2, 5, NULL, 0, 0.00, '2026-11-01 00:56:21'),
(3, 1, 3, NULL, 'function solve() { return true; }', 0, 20.00, '2026-11-01 00:56:21'),
(4, 1, 4, 9, NULL, 0, 0.00, '2026-11-01 00:56:21'),
(5, 1, 5, 13, NULL, 1, 10.00, '2026-11-01 00:56:21'),
(6, 1, 6, NULL, 'function solve() { return true; }', 0, 20.00, '2026-11-01 00:56:21'),
(7, 1, 7, 17, NULL, 0, 0.00, '2026-11-01 00:56:21'),
(8, 1, 8, 21, NULL, 0, 0.00, '2026-11-01 00:56:21'),
(9, 1, 9, NULL, 'function solve() { return true; }', 0, 20.00, '2026-11-01 00:56:21'),
(10, 1, 10, 25, NULL, 0, 0.00, '2026-11-01 00:56:21'),
(11, 1, 11, 29, NULL, 0, 0.00, '2026-11-01 00:56:21'),
(12, 1, 12, NULL, 'function solve() { return true; }', 0, 20.00, '2026-11-01 00:56:21'),
(13, 1, 13, 33, NULL, 1, 10.00, '2026-11-01 00:56:21'),
(14, 1, 14, 37, NULL, 0, 0.00, '2026-11-01 00:56:21'),
(15, 1, 15, NULL, 'function solve() { return true; }', 0, 20.00, '2026-11-01 00:56:21');

-- --------------------------------------------------------

--
-- Table structure for table `assessment_scores`
--

CREATE TABLE `assessment_scores` (
  `id` bigint UNSIGNED NOT NULL,
  `session_id` bigint UNSIGNED NOT NULL,
  `competency_id` bigint UNSIGNED NOT NULL,
  `multiple_choice_score` decimal(5,2) NOT NULL DEFAULT '0.00',
  `coding_score` decimal(5,2) NOT NULL DEFAULT '0.00',
  `final_score` decimal(5,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `assessment_scores`
--

INSERT INTO `assessment_scores` (`id`, `session_id`, `competency_id`, `multiple_choice_score`, `coding_score`, `final_score`, `created_at`) VALUES
(1, 1, 1, 0.00, 20.00, 12.00, '2026-10-31 16:56:21'),
(2, 1, 2, 50.00, 20.00, 32.00, '2026-10-31 16:56:21'),
(3, 1, 3, 0.00, 20.00, 12.00, '2026-10-31 16:56:21'),
(4, 1, 4, 0.00, 20.00, 12.00, '2026-10-31 16:56:21'),
(5, 1, 5, 50.00, 20.00, 32.00, '2026-10-31 16:56:21');

-- --------------------------------------------------------

--
-- Table structure for table `assessment_sessions`
--

CREATE TABLE `assessment_sessions` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `started_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `finished_at` datetime DEFAULT NULL,
  `status` enum('in_progress','completed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'in_progress'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `assessment_sessions`
--

INSERT INTO `assessment_sessions` (`id`, `user_id`, `started_at`, `finished_at`, `status`) VALUES
(1, 3, '2026-11-01 00:56:21', '2026-11-01 00:56:21', 'completed');

-- --------------------------------------------------------

--
-- Table structure for table `coding_test_cases`
--

CREATE TABLE `coding_test_cases` (
  `id` bigint UNSIGNED NOT NULL,
  `question_id` bigint UNSIGNED NOT NULL,
  `input_data` text COLLATE utf8mb4_unicode_ci,
  `expected_output` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `points` decimal(6,2) NOT NULL DEFAULT '1.00',
  `is_hidden` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `coding_test_cases`
--

INSERT INTO `coding_test_cases` (`id`, `question_id`, `input_data`, `expected_output`, `points`, `is_hidden`) VALUES
(1, 6, '5,4', '20', 10.00, 0),
(2, 6, '10,3', '30', 10.00, 0),
(3, 3, 'Tidak ada input', 'Struktur HTML valid', 20.00, 0),
(4, 9, 'Bali', 'Halo, Bali', 20.00, 0),
(5, 12, 'Tidak ada input', 'SELECT * FROM siswa;', 20.00, 0),
(6, 15, '4', 'Genap', 10.00, 0),
(7, 15, '7', 'Ganjil', 10.00, 0);

-- --------------------------------------------------------

--
-- Table structure for table `competencies`
--

CREATE TABLE `competencies` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `competencies`
--

INSERT INTO `competencies` (`id`, `name`, `description`, `created_at`) VALUES
(1, 'HTML & CSS', 'Struktur halaman, semantic HTML, layout, dan responsive design', '2026-10-31 16:32:50'),
(2, 'JavaScript', 'Variabel, kondisi, perulangan, fungsi, dan DOM', '2026-10-31 16:32:50'),
(3, 'PHP', 'Sintaks PHP, form, session, dan CRUD', '2026-10-31 16:32:50'),
(4, 'Database', 'SQL, relasi tabel, JOIN, dan pengelolaan data', '2026-10-31 16:32:50'),
(5, 'Programming Logic', 'Algoritma, logika pemrograman, dan problem solving', '2026-10-31 16:32:50');

-- --------------------------------------------------------

--
-- Table structure for table `learning_materials`
--

CREATE TABLE `learning_materials` (
  `id` bigint UNSIGNED NOT NULL,
  `competency_id` bigint UNSIGNED NOT NULL,
  `title` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `material_type` enum('article','video','practice','project') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'article',
  `url` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `difficulty` enum('easy','medium','hard') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'easy',
  `estimated_minutes` int NOT NULL DEFAULT '30',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` bigint UNSIGNED NOT NULL,
  `competency_id` bigint UNSIGNED NOT NULL,
  `type` enum('multiple_choice','coding') COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `question_text` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `difficulty` enum('easy','medium','hard') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'easy',
  `points` decimal(6,2) NOT NULL DEFAULT '1.00',
  `programming_language` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `starter_code` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `competency_id`, `type`, `title`, `question_text`, `difficulty`, `points`, `programming_language`, `starter_code`, `created_at`) VALUES
(1, 1, 'multiple_choice', 'Fungsi HTML', 'Apa fungsi utama HTML dalam pembuatan website?', 'easy', 10.00, NULL, NULL, '2026-10-31 16:34:42'),
(2, 1, 'multiple_choice', 'Semantic HTML', 'Tag HTML apa yang digunakan untuk membuat navigasi?', 'easy', 10.00, NULL, NULL, '2026-10-31 16:34:42'),
(3, 1, 'coding', 'Membuat Struktur HTML', 'Buat struktur HTML sederhana yang memiliki heading, paragraf, dan tombol.', 'easy', 20.00, NULL, NULL, '2026-10-31 16:34:42'),
(4, 2, 'multiple_choice', 'Variabel JavaScript', 'Keyword apa yang digunakan untuk membuat variabel yang nilainya dapat diubah?', 'easy', 10.00, NULL, NULL, '2026-10-31 16:34:42'),
(5, 2, 'multiple_choice', 'Fungsi JavaScript', 'Apa fungsi utama dari function dalam JavaScript?', 'easy', 10.00, NULL, NULL, '2026-10-31 16:34:42'),
(6, 2, 'coding', 'Menghitung Luas Persegi Panjang', 'Buat function bernama hitungLuas yang menerima panjang dan lebar, lalu mengembalikan hasil perkaliannya.', 'easy', 20.00, 'javascript', NULL, '2026-10-31 16:34:42'),
(7, 3, 'multiple_choice', 'Variabel PHP', 'Simbol apa yang digunakan untuk menandai variabel PHP?', 'easy', 10.00, NULL, NULL, '2026-10-31 16:34:42'),
(8, 3, 'multiple_choice', 'Form PHP', 'Superglobal PHP apa yang biasanya digunakan untuk menerima data form dengan metode POST?', 'easy', 10.00, NULL, NULL, '2026-10-31 16:34:42'),
(9, 3, 'coding', 'Menampilkan Pesan PHP', 'Buat kode PHP untuk menyimpan nama ke variabel dan menampilkannya.', 'easy', 20.00, NULL, NULL, '2026-10-31 16:34:42'),
(10, 4, 'multiple_choice', 'Perintah SELECT', 'Perintah SQL apa yang digunakan untuk mengambil data dari tabel?', 'easy', 10.00, NULL, NULL, '2026-10-31 16:34:42'),
(11, 4, 'multiple_choice', 'Primary Key', 'Apa fungsi Primary Key dalam sebuah tabel database?', 'easy', 10.00, NULL, NULL, '2026-10-31 16:34:42'),
(12, 4, 'coding', 'Query Mengambil Data', 'Buat query SQL untuk mengambil semua data dari tabel siswa.', 'easy', 20.00, NULL, NULL, '2026-10-31 16:34:42'),
(13, 5, 'multiple_choice', 'Percabangan', 'Struktur apa yang digunakan untuk menjalankan kode berdasarkan kondisi?', 'easy', 10.00, NULL, NULL, '2026-10-31 16:34:42'),
(14, 5, 'multiple_choice', 'Perulangan', 'Struktur apa yang digunakan untuk menjalankan kode berulang kali?', 'easy', 10.00, NULL, NULL, '2026-10-31 16:34:42'),
(15, 5, 'coding', 'Menentukan Bilangan Genap', 'Buat function JavaScript yang menerima sebuah angka dan mengembalikan teks Genap atau Ganjil.', 'easy', 20.00, 'javascript', NULL, '2026-10-31 16:34:42');

-- --------------------------------------------------------

--
-- Table structure for table `question_options`
--

CREATE TABLE `question_options` (
  `id` bigint UNSIGNED NOT NULL,
  `question_id` bigint UNSIGNED NOT NULL,
  `option_label` char(1) COLLATE utf8mb4_unicode_ci NOT NULL,
  `option_text` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_correct` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `question_options`
--

INSERT INTO `question_options` (`id`, `question_id`, `option_label`, `option_text`, `is_correct`) VALUES
(1, 1, 'A', 'Mengatur database', 0),
(2, 1, 'B', 'Membuat struktur halaman web', 1),
(3, 1, 'C', 'Mengatur server', 0),
(4, 1, 'D', 'Membuat animasi 3D', 0),
(5, 2, 'A', '<section>', 0),
(6, 2, 'B', '<footer>', 0),
(7, 2, 'C', '<nav>', 1),
(8, 2, 'D', '<article>', 0),
(9, 4, 'A', 'const', 0),
(10, 4, 'B', 'let', 1),
(11, 4, 'C', 'static', 0),
(12, 4, 'D', 'define', 0),
(13, 5, 'A', 'Mengelompokkan kode agar dapat digunakan kembali', 1),
(14, 5, 'B', 'Menghapus database', 0),
(15, 5, 'C', 'Mengatur tampilan CSS', 0),
(16, 5, 'D', 'Menghubungkan komputer ke internet', 0),
(17, 7, 'A', '#', 0),
(18, 7, 'B', '$', 1),
(19, 7, 'C', '@', 0),
(20, 7, 'D', '&', 0),
(21, 8, 'A', '$_GET', 0),
(22, 8, 'B', '$_SESSION', 0),
(23, 8, 'C', '$_POST', 1),
(24, 8, 'D', '$_SERVER', 0),
(25, 10, 'A', 'INSERT', 0),
(26, 10, 'B', 'UPDATE', 0),
(27, 10, 'C', 'SELECT', 1),
(28, 10, 'D', 'DELETE', 0),
(29, 11, 'A', 'Menghapus tabel', 0),
(30, 11, 'B', 'Mengidentifikasi setiap baris secara unik', 1),
(31, 11, 'C', 'Mengubah warna tabel', 0),
(32, 11, 'D', 'Menyimpan gambar', 0),
(33, 13, 'A', 'if-else', 1),
(34, 13, 'B', 'print', 0),
(35, 13, 'C', 'input', 0),
(36, 13, 'D', 'comment', 0),
(37, 14, 'A', 'variable', 0),
(38, 14, 'B', 'loop', 1),
(39, 14, 'C', 'array', 0),
(40, 14, 'D', 'string', 0);

-- --------------------------------------------------------

--
-- Table structure for table `roadmaps`
--

CREATE TABLE `roadmaps` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `analysis_id` bigint UNSIGNED NOT NULL,
  `title` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `duration_days` int NOT NULL DEFAULT '30',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roadmaps`
--

INSERT INTO `roadmaps` (`id`, `user_id`, `analysis_id`, `title`, `description`, `duration_days`, `created_at`) VALUES
(1, 3, 1, 'Roadmap Belajar 30 Hari', 'Roadmap berdasarkan hasil assessment dan analisis AI.', 30, '2026-10-31 16:56:21');

-- --------------------------------------------------------

--
-- Table structure for table `roadmap_items`
--

CREATE TABLE `roadmap_items` (
  `id` bigint UNSIGNED NOT NULL,
  `roadmap_id` bigint UNSIGNED NOT NULL,
  `material_id` bigint UNSIGNED DEFAULT NULL,
  `title` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `day_number` int NOT NULL,
  `status` enum('pending','in_progress','completed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `completed_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('student','admin') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'student',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'Verify User', 'verify_1793465607@example.com', '$2y$10$xVTSV3Ve106W/qE8hSVSheCupzssMqmQ7hbL8KQUc1fxWdpBMfxAG', 'student', '2026-10-31 16:53:27'),
(2, 'Copilot Verify', 'copilot_verify_1793465625@example.com', '$2y$10$eoCeXwPTHk8EXFsDVo9l3.aeN1cdiIpmhLHfwHL6JMlTxwnPebG4a', 'student', '2026-10-31 16:53:45'),
(3, 'Assess User', 'assess_1793465780@example.com', '$2y$10$3Pkc4kZ4RsS/FSs4ymvJVOcvDJzJl9sF2YN2TgsR9ktIKaJpEoQDS', 'student', '2026-10-31 16:56:20'),
(4, 'Admin BaliReady', 'admin@baliready.ai', '$2y$10$gbQiub5TP.kDDD52rvAFOud.mPc08Vmc1OxPK89Mm39Kv0l9lSgfe', 'admin', '2026-10-31 17:02:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ai_analyses`
--
ALTER TABLE `ai_analyses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_analysis_session` (`session_id`);

--
-- Indexes for table `answers`
--
ALTER TABLE `answers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_session_question` (`session_id`,`question_id`),
  ADD KEY `fk_answers_question` (`question_id`),
  ADD KEY `fk_answers_option` (`selected_option_id`);

--
-- Indexes for table `assessment_scores`
--
ALTER TABLE `assessment_scores`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_session_competency` (`session_id`,`competency_id`),
  ADD KEY `fk_scores_competency` (`competency_id`);

--
-- Indexes for table `assessment_sessions`
--
ALTER TABLE `assessment_sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_sessions_user` (`user_id`);

--
-- Indexes for table `coding_test_cases`
--
ALTER TABLE `coding_test_cases`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_testcases_question` (`question_id`);

--
-- Indexes for table `competencies`
--
ALTER TABLE `competencies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `learning_materials`
--
ALTER TABLE `learning_materials`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_materials_competency` (`competency_id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_questions_competency` (`competency_id`);

--
-- Indexes for table `question_options`
--
ALTER TABLE `question_options`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_question_option` (`question_id`,`option_label`);

--
-- Indexes for table `roadmaps`
--
ALTER TABLE `roadmaps`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_roadmaps_user` (`user_id`),
  ADD KEY `fk_roadmaps_analysis` (`analysis_id`);

--
-- Indexes for table `roadmap_items`
--
ALTER TABLE `roadmap_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_items_roadmap` (`roadmap_id`),
  ADD KEY `fk_items_material` (`material_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ai_analyses`
--
ALTER TABLE `ai_analyses`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `answers`
--
ALTER TABLE `answers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `assessment_scores`
--
ALTER TABLE `assessment_scores`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `assessment_sessions`
--
ALTER TABLE `assessment_sessions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `coding_test_cases`
--
ALTER TABLE `coding_test_cases`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `competencies`
--
ALTER TABLE `competencies`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `learning_materials`
--
ALTER TABLE `learning_materials`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `question_options`
--
ALTER TABLE `question_options`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `roadmaps`
--
ALTER TABLE `roadmaps`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `roadmap_items`
--
ALTER TABLE `roadmap_items`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ai_analyses`
--
ALTER TABLE `ai_analyses`
  ADD CONSTRAINT `fk_analyses_session` FOREIGN KEY (`session_id`) REFERENCES `assessment_sessions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `answers`
--
ALTER TABLE `answers`
  ADD CONSTRAINT `fk_answers_option` FOREIGN KEY (`selected_option_id`) REFERENCES `question_options` (`id`),
  ADD CONSTRAINT `fk_answers_question` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`),
  ADD CONSTRAINT `fk_answers_session` FOREIGN KEY (`session_id`) REFERENCES `assessment_sessions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `assessment_scores`
--
ALTER TABLE `assessment_scores`
  ADD CONSTRAINT `fk_scores_competency` FOREIGN KEY (`competency_id`) REFERENCES `competencies` (`id`),
  ADD CONSTRAINT `fk_scores_session` FOREIGN KEY (`session_id`) REFERENCES `assessment_sessions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `assessment_sessions`
--
ALTER TABLE `assessment_sessions`
  ADD CONSTRAINT `fk_sessions_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `coding_test_cases`
--
ALTER TABLE `coding_test_cases`
  ADD CONSTRAINT `fk_testcases_question` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `learning_materials`
--
ALTER TABLE `learning_materials`
  ADD CONSTRAINT `fk_materials_competency` FOREIGN KEY (`competency_id`) REFERENCES `competencies` (`id`);

--
-- Constraints for table `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `fk_questions_competency` FOREIGN KEY (`competency_id`) REFERENCES `competencies` (`id`);

--
-- Constraints for table `question_options`
--
ALTER TABLE `question_options`
  ADD CONSTRAINT `fk_options_question` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `roadmaps`
--
ALTER TABLE `roadmaps`
  ADD CONSTRAINT `fk_roadmaps_analysis` FOREIGN KEY (`analysis_id`) REFERENCES `ai_analyses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_roadmaps_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `roadmap_items`
--
ALTER TABLE `roadmap_items`
  ADD CONSTRAINT `fk_items_material` FOREIGN KEY (`material_id`) REFERENCES `learning_materials` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_items_roadmap` FOREIGN KEY (`roadmap_id`) REFERENCES `roadmaps` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
