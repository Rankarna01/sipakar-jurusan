<?php
/**
 * ============================================================
 * FRONT CONTROLLER - Sistem Pakar Rekomendasi Jurusan PTN
 * Metode Dempster-Shafer | SMA Muhammadiyah 18 Sunggal
 * ============================================================
 * Seluruh request masuk lewat file ini (lihat .htaccess)
 */

require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/core/Database.php';
require_once __DIR__ . '/helpers/functions.php';
require_once __DIR__ . '/core/Router.php';
require_once __DIR__ . '/core/DempsterShafer.php';

// ==== Security Headers ====
header('X-Frame-Options: SAMEORIGIN');
header('X-Content-Type-Options: nosniff');
header('X-XSS-Protection: 1; mode=block');
header('Referrer-Policy: strict-origin-when-cross-origin');

// ==== Jalankan Router ====
try {
    $router = new Router();
    $router->dispatch();
} catch (Throwable $e) {
    error_log('Application Error: ' . $e->getMessage());
    http_response_code(500);
    if (APP_DEBUG) {
        echo '<h2>Terjadi Kesalahan</h2>';
        echo '<pre>' . htmlspecialchars($e->getMessage()) . "\n\n" . htmlspecialchars($e->getTraceAsString()) . '</pre>';
    } else {
        echo 'Terjadi kesalahan pada server. Silakan coba lagi nanti.';
    }
}
