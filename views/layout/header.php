<!DOCTYPE html>
<html lang="id" data-bs-theme="light">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= $title ?? APP_NAME ?></title>
<meta name="description" content="Sistem Pakar Rekomendasi Jurusan Perguruan Tinggi Negeri menggunakan Metode Dempster-Shafer">
<?php $siteFavicon = get_setting('favicon', ''); ?>
<link rel="icon" href="<?= ($siteFavicon && file_exists(UPLOAD_PATH . $siteFavicon)) ? UPLOAD_URL . clean($siteFavicon) : BASE_URL . 'assets/img/favicon.png' ?>">

<!-- Bootstrap 5 -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
<!-- Google Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&family=Nunito:wght@400;500;600;700&display=swap" rel="stylesheet">
<!-- AOS Scroll Animation -->
<link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
<!-- Custom Style -->
<link rel="stylesheet" href="<?= BASE_URL ?>assets/css/style.css">
</head>
<body>

<!-- Loading Screen -->
<div id="loading-screen">
    <div class="loader-box">
        <div class="loader-ring"></div>
        <span class="loader-text">SiJurusan</span>
    </div>
</div>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-glass sticky-top" id="mainNavbar">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-2" href="<?= BASE_URL ?>">
            <?php $siteLogo = get_setting('logo', ''); ?>
            <?php if ($siteLogo && file_exists(UPLOAD_PATH . $siteLogo)): ?>
                <img src="<?= UPLOAD_URL . clean($siteLogo) ?>" alt="Logo" style="height:44px;width:44px;object-fit:contain;border-radius:12px;">
            <?php else: ?>
                <div class="brand-icon"><i class="bi bi-mortarboard-fill"></i></div>
            <?php endif; ?>
            <div class="brand-text">
                <span class="brand-title">SiJurusan</span>
                <span class="brand-sub">Dempster-Shafer Expert System</span>
            </div>
        </a>
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navMain">
            <i class="bi bi-list fs-2"></i>
        </button>
        <div class="collapse navbar-collapse" id="navMain">
            <ul class="navbar-nav mx-auto gap-1">
                <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>home/tentang">Tentang</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>fakultas">Fakultas</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>jurusan">Jurusan</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>home/kontak">Kontak</a></li>
            </ul>
            <div class="d-flex align-items-center gap-2">
                <button id="darkModeToggle" class="btn-icon-toggle" title="Mode Gelap">
                    <i class="bi bi-moon-stars-fill"></i>
                </button>
                <?php if (is_siswa_login()): ?>
                    <a href="<?= BASE_URL ?>siswa/dashboard" class="btn btn-outline-navy rounded-pill px-3">
                        <i class="bi bi-person-circle me-1"></i> <?= clean($_SESSION['siswa_nama']) ?>
                    </a>
                <?php else: ?>
                    <a href="<?= BASE_URL ?>auth/login" class="btn btn-outline-navy rounded-pill px-3">Masuk</a>
                <?php endif; ?>
                <a href="<?= BASE_URL ?>konsultasi" class="btn btn-gradient rounded-pill px-3">
                    <i class="bi bi-chat-dots-fill me-1"></i> Konsultasi
                </a>
            </div>
        </div>
    </div>
</nav>

<main>
