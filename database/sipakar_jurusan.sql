-- =====================================================================
-- SISTEM PAKAR REKOMENDASI JURUSAN PTN - METODE DEMPSTER-SHAFER
-- SMA Muhammadiyah 18 Sunggal
-- Database: sipakar_jurusan
-- Normalisasi: 3NF
-- =====================================================================

SET FOREIGN_KEY_CHECKS = 0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+07:00";

CREATE DATABASE IF NOT EXISTS `sipakar_jurusan` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `sipakar_jurusan`;

-- =====================================================================
-- 1. TABEL ADMIN
-- =====================================================================
CREATE TABLE `admin` (
  `id_admin` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `nama` VARCHAR(100) NOT NULL,
  `username` VARCHAR(50) NOT NULL UNIQUE,
  `email` VARCHAR(100) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL COMMENT 'bcrypt hash',
  `foto` VARCHAR(255) DEFAULT NULL,
  `role` ENUM('superadmin','admin','guru_bk') NOT NULL DEFAULT 'admin',
  `status` ENUM('aktif','nonaktif') NOT NULL DEFAULT 'aktif',
  `last_login` DATETIME DEFAULT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- =====================================================================
-- 2. TABEL SISWA
-- =====================================================================
CREATE TABLE `siswa` (
  `id_siswa` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `nama` VARCHAR(100) NOT NULL,
  `nisn` VARCHAR(20) NOT NULL UNIQUE,
  `kelas` VARCHAR(20) NOT NULL,
  `email` VARCHAR(100) NOT NULL UNIQUE,
  `no_wa` VARCHAR(20) DEFAULT NULL,
  `password` VARCHAR(255) NOT NULL COMMENT 'bcrypt hash',
  `foto` VARCHAR(255) DEFAULT NULL,
  `jenis_kelamin` ENUM('L','P') DEFAULT NULL,
  `status` ENUM('aktif','nonaktif') NOT NULL DEFAULT 'aktif',
  `email_verified_at` DATETIME DEFAULT NULL,
  `last_login` DATETIME DEFAULT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- =====================================================================
-- 3. TABEL FAKULTAS
-- =====================================================================
CREATE TABLE `fakultas` (
  `id_fakultas` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `kode_fakultas` VARCHAR(10) NOT NULL UNIQUE,
  `nama_fakultas` VARCHAR(150) NOT NULL,
  `slug` VARCHAR(160) NOT NULL UNIQUE,
  `deskripsi` TEXT,
  `icon` VARCHAR(100) DEFAULT 'bi-mortarboard' COMMENT 'bootstrap icon class',
  `gambar` VARCHAR(255) DEFAULT NULL,
  `urutan` INT DEFAULT 0,
  `status` ENUM('aktif','nonaktif') NOT NULL DEFAULT 'aktif',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- =====================================================================
-- 4. TABEL JURUSAN
-- =====================================================================
CREATE TABLE `jurusan` (
  `id_jurusan` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `id_fakultas` INT UNSIGNED NOT NULL,
  `kode_jurusan` VARCHAR(15) NOT NULL UNIQUE,
  `nama_jurusan` VARCHAR(150) NOT NULL,
  `slug` VARCHAR(160) NOT NULL UNIQUE,
  `deskripsi` TEXT,
  `skill_dibutuhkan` TEXT COMMENT 'JSON array atau teks list',
  `prospek_kerja` TEXT,
  `peluang_karier` TEXT,
  `mata_kuliah_inti` TEXT COMMENT 'Daftar mata kuliah inti/wajib program studi',
  `range_gaji` VARCHAR(100) COMMENT 'Estimasi rentang gaji lulusan (contoh: Rp5.000.000 - Rp12.000.000)',
  `top_kampus` TEXT COMMENT 'Daftar top 10 PTN penyedia jurusan ini (dipisah | )',
  `mata_pelajaran_pendukung` VARCHAR(255) DEFAULT NULL,
  `gambar` VARCHAR(255) DEFAULT NULL,
  `icon` VARCHAR(100) DEFAULT 'bi-book',
  `urutan` INT DEFAULT 0,
  `status` ENUM('aktif','nonaktif') NOT NULL DEFAULT 'aktif',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`id_fakultas`) REFERENCES `fakultas`(`id_fakultas`) ON DELETE CASCADE ON UPDATE CASCADE,
  INDEX idx_jurusan_fakultas (`id_fakultas`)
) ENGINE=InnoDB;

-- =====================================================================
-- 5. TABEL UNIVERSITAS
-- =====================================================================
CREATE TABLE `universitas` (
  `id_universitas` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `nama_universitas` VARCHAR(150) NOT NULL,
  `singkatan` VARCHAR(20) DEFAULT NULL,
  `kota` VARCHAR(100) DEFAULT NULL,
  `provinsi` VARCHAR(100) DEFAULT NULL,
  `jenis` ENUM('negeri','swasta','kedinasan') NOT NULL DEFAULT 'negeri',
  `logo` VARCHAR(255) DEFAULT NULL,
  `akreditasi_institusi` VARCHAR(20) DEFAULT NULL,
  `tahun_berdiri` YEAR DEFAULT NULL,
  `jumlah_mahasiswa` VARCHAR(50) DEFAULT NULL,
  `website` VARCHAR(255) DEFAULT NULL,
  `status` ENUM('aktif','nonaktif') NOT NULL DEFAULT 'aktif',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Relasi many-to-many: jurusan tersedia di universitas mana saja
CREATE TABLE `jurusan_universitas` (
  `id_jurusan_universitas` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `id_jurusan` INT UNSIGNED NOT NULL,
  `id_universitas` INT UNSIGNED NOT NULL,
  `akreditasi` VARCHAR(20) DEFAULT NULL,
  `jalur_masuk` VARCHAR(100) DEFAULT NULL COMMENT 'SNBP/SNBT/Mandiri',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`id_jurusan`) REFERENCES `jurusan`(`id_jurusan`) ON DELETE CASCADE,
  FOREIGN KEY (`id_universitas`) REFERENCES `universitas`(`id_universitas`) ON DELETE CASCADE,
  UNIQUE KEY uniq_jurusan_univ (`id_jurusan`, `id_universitas`)
) ENGINE=InnoDB;

-- =====================================================================
-- 6. TABEL EVIDENCE (kategori bukti/gejala inti - dipakai Dempster-Shafer)
-- =====================================================================
CREATE TABLE `evidence` (
  `id_evidence` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `kode_evidence` VARCHAR(10) NOT NULL UNIQUE COMMENT 'contoh: E001, E002',
  `nama_evidence` VARCHAR(150) NOT NULL,
  `kategori` ENUM('minat','bakat','kemampuan','kepribadian','tujuan_karier') NOT NULL,
  `keterangan` TEXT,
  `status` ENUM('aktif','nonaktif') NOT NULL DEFAULT 'aktif',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- =====================================================================
-- 7. TABEL PERTANYAAN (setiap pertanyaan terhubung ke 1 evidence)
-- =====================================================================
CREATE TABLE `pertanyaan` (
  `id_pertanyaan` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `id_evidence` INT UNSIGNED NOT NULL,
  `kode_pertanyaan` VARCHAR(10) NOT NULL UNIQUE COMMENT 'contoh: P001',
  `kategori` ENUM('minat','bakat','kemampuan','kepribadian','tujuan_karier') NOT NULL,
  `pertanyaan` TEXT NOT NULL,
  `urutan` INT DEFAULT 0,
  `status` ENUM('aktif','nonaktif') NOT NULL DEFAULT 'aktif',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`id_evidence`) REFERENCES `evidence`(`id_evidence`) ON DELETE CASCADE,
  INDEX idx_pertanyaan_evidence (`id_evidence`)
) ENGINE=InnoDB;

-- =====================================================================
-- 8. TABEL ATURAN (basis pengetahuan many-to-many: evidence <-> jurusan)
--    Ini adalah tabel mass function dasar untuk Dempster-Shafer
-- =====================================================================
CREATE TABLE `aturan` (
  `id_aturan` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `id_evidence` INT UNSIGNED NOT NULL,
  `id_jurusan` INT UNSIGNED NOT NULL,
  `nilai_belief` DECIMAL(4,3) NOT NULL COMMENT 'Nilai belief 0.000 - 1.000',
  `nilai_plausibility` DECIMAL(4,3) NOT NULL DEFAULT 1.000 COMMENT 'Nilai plausibility 0.000 - 1.000',
  `keterangan` VARCHAR(255) DEFAULT NULL,
  `status` ENUM('aktif','nonaktif') NOT NULL DEFAULT 'aktif',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`id_evidence`) REFERENCES `evidence`(`id_evidence`) ON DELETE CASCADE,
  FOREIGN KEY (`id_jurusan`) REFERENCES `jurusan`(`id_jurusan`) ON DELETE CASCADE,
  UNIQUE KEY uniq_evidence_jurusan (`id_evidence`, `id_jurusan`),
  INDEX idx_aturan_jurusan (`id_jurusan`),
  CONSTRAINT chk_belief CHECK (`nilai_belief` >= 0 AND `nilai_belief` <= 1),
  CONSTRAINT chk_plausibility CHECK (`nilai_plausibility` >= 0 AND `nilai_plausibility` <= 1)
) ENGINE=InnoDB;

-- =====================================================================
-- 9. TABEL HASIL (header konsultasi)
-- =====================================================================
CREATE TABLE `hasil` (
  `id_hasil` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `kode_konsultasi` VARCHAR(30) NOT NULL UNIQUE COMMENT 'contoh: KONS-20260728-XXXX',
  `id_siswa` INT UNSIGNED DEFAULT NULL COMMENT 'NULL jika konsultasi tanpa login',
  `nama_tamu` VARCHAR(100) DEFAULT NULL COMMENT 'diisi jika tanpa login',
  `kelas_tamu` VARCHAR(20) DEFAULT NULL,
  `jenis_kelamin` ENUM('L','P') DEFAULT NULL COMMENT 'Jenis kelamin siswa/tamu, untuk keperluan filter laporan',
  `id_jurusan_terbaik` INT UNSIGNED DEFAULT NULL,
  `id_fakultas_terbaik` INT UNSIGNED DEFAULT NULL COMMENT 'Fakultas dengan agregat belief tertinggi (rekomendasi utama)',
  `persentase_fakultas_terbaik` DECIMAL(5,2) DEFAULT NULL,
  `nilai_belief_akhir` DECIMAL(6,4) DEFAULT NULL,
  `persentase_akhir` DECIMAL(5,2) DEFAULT NULL,
  `jumlah_evidence_dipilih` INT DEFAULT 0,
  `waktu_mulai` DATETIME DEFAULT NULL,
  `waktu_selesai` DATETIME DEFAULT NULL,
  `durasi_detik` INT DEFAULT NULL,
  `ip_address` VARCHAR(45) DEFAULT NULL,
  `status` ENUM('proses','selesai') NOT NULL DEFAULT 'proses',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`id_siswa`) REFERENCES `siswa`(`id_siswa`) ON DELETE SET NULL,
  FOREIGN KEY (`id_jurusan_terbaik`) REFERENCES `jurusan`(`id_jurusan`) ON DELETE SET NULL,
  FOREIGN KEY (`id_fakultas_terbaik`) REFERENCES `fakultas`(`id_fakultas`) ON DELETE SET NULL,
  INDEX idx_hasil_siswa (`id_siswa`),
  INDEX idx_hasil_kode (`kode_konsultasi`)
) ENGINE=InnoDB;

-- =====================================================================
-- 10. TABEL DETAIL_HASIL (ranking seluruh jurusan per konsultasi + jejak evidence)
-- =====================================================================
CREATE TABLE `detail_hasil` (
  `id_detail_hasil` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `id_hasil` INT UNSIGNED NOT NULL,
  `id_jurusan` INT UNSIGNED NOT NULL,
  `nilai_belief` DECIMAL(6,4) NOT NULL,
  `nilai_plausibility` DECIMAL(6,4) DEFAULT NULL,
  `persentase` DECIMAL(5,2) NOT NULL,
  `ranking` INT NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`id_hasil`) REFERENCES `hasil`(`id_hasil`) ON DELETE CASCADE,
  FOREIGN KEY (`id_jurusan`) REFERENCES `jurusan`(`id_jurusan`) ON DELETE CASCADE,
  INDEX idx_detail_hasil (`id_hasil`),
  INDEX idx_detail_ranking (`id_hasil`, `ranking`)
) ENGINE=InnoDB;

-- Jejak jawaban siswa per pertanyaan (untuk ditampilkan ulang & audit)
CREATE TABLE `jawaban_konsultasi` (
  `id_jawaban` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `id_hasil` INT UNSIGNED NOT NULL,
  `id_pertanyaan` INT UNSIGNED NOT NULL,
  `id_evidence` INT UNSIGNED NOT NULL,
  `jawaban` ENUM('ya','tidak') NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`id_hasil`) REFERENCES `hasil`(`id_hasil`) ON DELETE CASCADE,
  FOREIGN KEY (`id_pertanyaan`) REFERENCES `pertanyaan`(`id_pertanyaan`) ON DELETE CASCADE,
  FOREIGN KEY (`id_evidence`) REFERENCES `evidence`(`id_evidence`) ON DELETE CASCADE,
  INDEX idx_jawaban_hasil (`id_hasil`)
) ENGINE=InnoDB;

-- Jejak langkah perhitungan Dempster-Shafer (kombinasi evidence per evidence, untuk ditampilkan step-by-step)
CREATE TABLE `langkah_perhitungan` (
  `id_langkah` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `id_hasil` INT UNSIGNED NOT NULL,
  `urutan_evidence` INT NOT NULL COMMENT 'urutan evidence ke-berapa yang dikombinasikan',
  `id_evidence` INT UNSIGNED NOT NULL,
  `id_jurusan` INT UNSIGNED NOT NULL,
  `m1_belief` DECIMAL(6,4) DEFAULT NULL COMMENT 'mass function evidence sebelumnya untuk jurusan ini',
  `m2_belief` DECIMAL(6,4) DEFAULT NULL COMMENT 'mass function evidence baru untuk jurusan ini',
  `m1_theta` DECIMAL(6,4) DEFAULT NULL,
  `m2_theta` DECIMAL(6,4) DEFAULT NULL,
  `nilai_kombinasi` DECIMAL(6,4) DEFAULT NULL COMMENT 'm3 hasil kombinasi sebelum normalisasi',
  `nilai_konflik` DECIMAL(6,4) DEFAULT NULL COMMENT 'k = jumlah konflik',
  `nilai_normalisasi` DECIMAL(6,4) DEFAULT NULL COMMENT 'hasil setelah dibagi (1-k)',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`id_hasil`) REFERENCES `hasil`(`id_hasil`) ON DELETE CASCADE,
  INDEX idx_langkah_hasil (`id_hasil`, `urutan_evidence`)
) ENGINE=InnoDB;

-- =====================================================================
-- 11. TABEL ARTIKEL
-- =====================================================================
CREATE TABLE `artikel` (
  `id_artikel` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `id_admin` INT UNSIGNED DEFAULT NULL,
  `judul` VARCHAR(200) NOT NULL,
  `slug` VARCHAR(220) NOT NULL UNIQUE,
  `thumbnail` VARCHAR(255) DEFAULT NULL,
  `kategori` VARCHAR(50) DEFAULT NULL,
  `konten` LONGTEXT NOT NULL,
  `ringkasan` VARCHAR(500) DEFAULT NULL,
  `views` INT UNSIGNED DEFAULT 0,
  `status` ENUM('draft','publish') NOT NULL DEFAULT 'draft',
  `published_at` DATETIME DEFAULT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`id_admin`) REFERENCES `admin`(`id_admin`) ON DELETE SET NULL
) ENGINE=InnoDB;

-- =====================================================================
-- 12. TABEL SLIDER
-- =====================================================================
CREATE TABLE `slider` (
  `id_slider` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `judul` VARCHAR(150) DEFAULT NULL,
  `subjudul` VARCHAR(255) DEFAULT NULL,
  `gambar` VARCHAR(255) NOT NULL,
  `link_tombol` VARCHAR(255) DEFAULT NULL,
  `teks_tombol` VARCHAR(50) DEFAULT NULL,
  `urutan` INT DEFAULT 0,
  `status` ENUM('aktif','nonaktif') NOT NULL DEFAULT 'aktif',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- =====================================================================
-- 13. TABEL TESTIMONI
-- =====================================================================
CREATE TABLE `testimoni` (
  `id_testimoni` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `id_siswa` INT UNSIGNED DEFAULT NULL,
  `nama` VARCHAR(100) NOT NULL,
  `sekolah_asal` VARCHAR(150) DEFAULT NULL,
  `foto` VARCHAR(255) DEFAULT NULL,
  `pesan` TEXT NOT NULL,
  `rating` TINYINT UNSIGNED NOT NULL DEFAULT 5 COMMENT '1-5',
  `status` ENUM('pending','tampil','sembunyi') NOT NULL DEFAULT 'pending',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`id_siswa`) REFERENCES `siswa`(`id_siswa`) ON DELETE SET NULL,
  CONSTRAINT chk_rating CHECK (`rating` BETWEEN 1 AND 5)
) ENGINE=InnoDB;

-- =====================================================================
-- 14. TABEL SETTING (pengaturan website & konsultasi, key-value fleksibel)
-- =====================================================================
CREATE TABLE `setting` (
  `id_setting` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `setting_key` VARCHAR(100) NOT NULL UNIQUE,
  `setting_value` LONGTEXT,
  `setting_group` VARCHAR(50) DEFAULT 'umum' COMMENT 'umum, konsultasi, tampilan, kontak, dsb',
  `keterangan` VARCHAR(255) DEFAULT NULL,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- =====================================================================
-- 15. TABEL LOG_LOGIN
-- =====================================================================
CREATE TABLE `log_login` (
  `id_log` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `user_type` ENUM('admin','siswa') NOT NULL,
  `user_id` INT UNSIGNED DEFAULT NULL,
  `username` VARCHAR(100) DEFAULT NULL,
  `ip_address` VARCHAR(45) DEFAULT NULL,
  `user_agent` VARCHAR(255) DEFAULT NULL,
  `status` ENUM('berhasil','gagal') NOT NULL,
  `keterangan` VARCHAR(255) DEFAULT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_log_login_user (`user_type`, `user_id`)
) ENGINE=InnoDB;

-- =====================================================================
-- 16. TABEL LOG_ACTIVITY (audit trail admin)
-- =====================================================================
CREATE TABLE `log_activity` (
  `id_log` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `id_admin` INT UNSIGNED DEFAULT NULL,
  `modul` VARCHAR(50) NOT NULL COMMENT 'contoh: Master Jurusan, Master Aturan',
  `aksi` ENUM('create','update','delete','login','logout','backup','restore','export','import') NOT NULL,
  `deskripsi` TEXT,
  `data_lama` LONGTEXT COMMENT 'JSON snapshot sebelum perubahan',
  `data_baru` LONGTEXT COMMENT 'JSON snapshot sesudah perubahan',
  `ip_address` VARCHAR(45) DEFAULT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`id_admin`) REFERENCES `admin`(`id_admin`) ON DELETE SET NULL,
  INDEX idx_log_activity_admin (`id_admin`)
) ENGINE=InnoDB;

SET FOREIGN_KEY_CHECKS = 1;

-- =====================================================================
-- TABEL PENGEMBANG (maksimal 5, ditampilkan di halaman Kontak)
-- =====================================================================
CREATE TABLE `pengembang` (
  `id_pengembang` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `nama` VARCHAR(100) NOT NULL,
  `jabatan` VARCHAR(255) DEFAULT NULL,
  `bio` TEXT,
  `keahlian` VARCHAR(500) DEFAULT NULL COMMENT 'Dipisah tanda |',
  `foto` VARCHAR(255) DEFAULT NULL,
  `urutan` INT DEFAULT 0,
  `status` ENUM('aktif','nonaktif') NOT NULL DEFAULT 'aktif',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- =====================================================================
-- DATA AWAL (SEED)
-- =====================================================================

-- Admin default (password: admin123 - HARUS diganti setelah instalasi)
INSERT INTO `admin` (`nama`, `username`, `email`, `password`, `role`) VALUES
('Administrator Sistem', 'admin', 'admin@smamuh18sunggal.sch.id', '$2y$10$lWiHyrFhE2u0kF/qVyIQU.VVVaW5OmHyJoRkfZGhZZ0xEfBVjij/C', 'superadmin');
-- Hash di atas adalah bcrypt tervalidasi untuk password 'admin123'.

-- Pengaturan dasar
INSERT INTO `setting` (`setting_key`, `setting_value`, `setting_group`, `keterangan`) VALUES
('nama_sekolah', 'SMA Muhammadiyah 18 Sunggal', 'umum', 'Nama instansi'),
('alamat_sekolah', 'Jalan Medan Krio', 'umum', 'Alamat sekolah'),
('nama_sistem', 'Sistem Pakar Rekomendasi Jurusan PTN Metode Dempster-Shafer', 'umum', 'Nama aplikasi'),
('logo', 'assets/img/logo.png', 'tampilan', 'Logo sekolah'),
('favicon', 'assets/img/favicon.png', 'tampilan', 'Favicon'),
('no_wa', '', 'kontak', 'Nomor WhatsApp'),
('email_kontak', '', 'kontak', 'Email kontak'),
('wajib_login', '0', 'konsultasi', '1 = wajib login, 0 = tanpa login'),
('dark_mode_default', '0', 'tampilan', 'Mode gelap default'),
('copyright_text', 'SMA Muhammadiyah 18 Sunggal', 'umum', 'Teks copyright footer'),
('smtp_host', '', 'email', 'SMTP Host (contoh: smtp.gmail.com)'),
('smtp_port', '587', 'email', 'SMTP Port'),
('smtp_username', '', 'email', 'SMTP Username / Email pengirim'),
('smtp_password', '', 'email', 'SMTP Password / App Password'),
('smtp_encryption', 'tls', 'email', 'Jenis enkripsi: tls atau ssl'),
('smtp_from_email', 'noreply@smamuh18sunggal.sch.id', 'email', 'Alamat email pengirim'),
('email_notif_aktif', '0', 'email', '1 = kirim email otomatis aktif, 0 = nonaktif'),
('dev_nama', 'Godan', 'pengembang', 'Nama pengembang sistem'),
('dev_jabatan', 'Dosen Program Studi Manajemen Informatika, Politeknik Negeri Medan (Polmed)', 'pengembang', 'Jabatan/institusi pengembang'),
('dev_bio', 'Berbasis di wilayah Sunggal / Medan, Sumatera Utara. Aktif dalam penelitian dan pengembangan sistem pakar berbasis metode ketidakpastian (Dempster-Shafer, Certainty Factor, Bayes) untuk domain pendidikan, serta pengembangan aplikasi web full-stack menggunakan PHP Native MVC.', 'pengembang', 'Bio singkat pengembang'),
('dev_keahlian', '🎓 Dosen Polmed | 🧠 Peneliti Sistem Pakar | 💻 Full-Stack Developer', 'pengembang', 'Daftar keahlian dipisah |'),
('konsultasi_banner', '', 'tampilan', 'Gambar banner halaman awal konsultasi');

INSERT INTO `pengembang` (`nama`, `jabatan`, `bio`, `keahlian`, `urutan`) VALUES
('Godan', 'Dosen Program Studi Manajemen Informatika, Politeknik Negeri Medan (Polmed)', 'Berbasis di wilayah Sunggal / Medan, Sumatera Utara. Aktif dalam penelitian dan pengembangan sistem pakar berbasis metode ketidakpastian (Dempster-Shafer, Certainty Factor, Bayes) untuk domain pendidikan, serta pengembangan aplikasi web full-stack menggunakan PHP Native MVC.', '🎓 Dosen Polmed | 🧠 Peneliti Sistem Pakar | 💻 Full-Stack Developer', 1);
