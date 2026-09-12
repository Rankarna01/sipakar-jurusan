<?php
/**
 * Layout Admin - Header + Sidebar
 * Wajib: $activeMenu diset di controller untuk highlight menu aktif
 */
if (!is_admin_login()) {
    header('Location: ' . BASE_URL . 'auth/adminLogin');
    exit;
}
$activeMenu = $activeMenu ?? '';
?>
<!DOCTYPE html>
<html lang="id" data-bs-theme="light">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= $title ?? 'Admin Panel' ?></title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;600;700;800&family=Nunito:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/datatables.net-bs5@1.13.11/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="<?= BASE_URL ?>assets/css/style.css">
<link rel="stylesheet" href="<?= BASE_URL ?>assets/css/admin.css">
</head>
<body>
<div class="admin-wrapper">

    <!-- Sidebar -->
    <aside class="admin-sidebar" id="adminSidebar">
        <div class="sidebar-brand">
            <div class="brand-icon"><i class="bi bi-mortarboard-fill"></i></div>
            <div>
                <div class="fw-bold">SiJurusan</div>
                <small class="text-white-50" style="font-size:0.65rem;">Admin Panel</small>
            </div>
        </div>
        <div class="sidebar-menu">
            <a href="<?= BASE_URL ?>admin/dashboard" class="menu-link <?= $activeMenu === 'dashboard' ? 'active' : '' ?>"><i class="bi bi-grid-1x2-fill"></i> Dashboard</a>

            <?php
            // Definisi grup menu: [label grup, icon grup, kunci aktif di dalamnya, item menu]
            $menuGroups = [
                'master' => [
                    'label' => 'Master Data', 'icon' => 'bi-database-fill-gear',
                    'keys' => ['fakultas', 'jurusan', 'pekerjaan', 'pertanyaan', 'evidence', 'universitas'],
                    'items' => [
                        ['adminFakultas', 'fakultas', 'bi-bank', 'Data Fakultas'],
                        ['adminJurusan', 'jurusan', 'bi-book', 'Data Jurusan'],
                        ['adminPekerjaan', 'pekerjaan', 'bi-briefcase', 'Data Pekerjaan'],
                        ['adminPertanyaan', 'pertanyaan', 'bi-diagram-3', 'Data Pertanyaan'],
                        ['adminEvidence', 'evidence', 'bi-clipboard-data', 'Data Evidence (Opsional)'],
                        ['adminUniversitas', 'universitas', 'bi-building', 'Data Universitas (Opsional)'],
                    ],
                ],
                'pengguna' => [
                    'label' => 'Siswa & Konsultasi', 'icon' => 'bi-people-fill',
                    'keys' => ['siswa', 'import', 'konsultasi', 'admin'],
                    'items' => [
                        ['adminSiswa', 'siswa', 'bi-people', 'Data Siswa'],
                        ['adminSiswa?import=1', 'import', 'bi-file-earmark-excel', 'Import Excel'],
                        ['adminKonsultasi', 'konsultasi', 'bi-chat-square-text', 'Hasil Konsultasi'],
                        ['adminAdmin', 'admin', 'bi-person-badge', 'Data Admin'],
                    ],
                ],
                'konten' => [
                    'label' => 'Konten Website', 'icon' => 'bi-layout-text-window-reverse',
                    'keys' => ['slider', 'artikel', 'testimoni', 'pengembang'],
                    'items' => [
                        ['adminSlider', 'slider', 'bi-images', 'Background/Slideshow'],
                        ['adminArtikel', 'artikel', 'bi-newspaper', 'Artikel'],
                        ['adminTestimoni', 'testimoni', 'bi-chat-heart', 'Testimoni'],
                        ['adminPengembang', 'pengembang', 'bi-person-badge-fill', 'Pengembang'],
                    ],
                ],
                'sistem' => [
                    'label' => 'Sistem & Laporan', 'icon' => 'bi-gear-wide-connected',
                    'keys' => ['pengaturan', 'laporan', 'backup', 'log'],
                    'items' => [
                        ['adminPengaturan', 'pengaturan', 'bi-gear-fill', 'Pengaturan'],
                        ['adminLaporan', 'laporan', 'bi-bar-chart-fill', 'Laporan'],
                        ['adminBackup', 'backup', 'bi-database-fill-down', 'Backup Database'],
                        ['log/logActivity', 'log', 'bi-clock-history', 'Log Aktivitas'],
                    ],
                ],
            ];

            foreach ($menuGroups as $groupKey => $group):
                $isGroupActive = in_array($activeMenu, $group['keys'], true);
            ?>
            <div class="menu-group">
                <button class="menu-link menu-group-toggle <?= $isGroupActive ? 'active' : '' ?>" type="button" data-bs-toggle="collapse" data-bs-target="#group-<?= $groupKey ?>" aria-expanded="<?= $isGroupActive ? 'true' : 'false' ?>">
                    <i class="bi <?= $group['icon'] ?>"></i> <?= $group['label'] ?>
                    <i class="bi bi-chevron-down ms-auto chevron-icon"></i>
                </button>
                <div class="collapse <?= $isGroupActive ? 'show' : '' ?>" id="group-<?= $groupKey ?>">
                    <div class="menu-submenu">
                        <?php foreach ($group['items'] as [$url, $key, $icon, $label]): ?>
                        <a href="<?= BASE_URL . $url ?>" class="menu-link menu-sublink <?= $activeMenu === $key ? 'active' : '' ?>"><i class="bi <?= $icon ?>"></i> <?= $label ?></a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </aside>

    <div class="admin-content">
        <div class="admin-topbar">
            <button class="btn btn-sm btn-light border d-lg-none" onclick="document.getElementById('adminSidebar').classList.toggle('show')"><i class="bi bi-list"></i></button>
            <h5 class="fw-bold mb-0 d-none d-lg-block"><?= $pageTitle ?? 'Dashboard' ?></h5>
            <div class="d-flex align-items-center gap-3">
                <a href="<?= BASE_URL ?>" target="_blank" class="text-muted small"><i class="bi bi-box-arrow-up-right"></i> Lihat Website</a>
                <div class="dropdown">
                    <button class="btn btn-light border rounded-pill dropdown-toggle d-flex align-items-center gap-2" data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle"></i> <?= clean($_SESSION['admin_nama']) ?>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="<?= BASE_URL ?>auth/adminLogout"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="admin-body">
