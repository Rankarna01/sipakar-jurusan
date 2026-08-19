<?php
/**
 * Konfigurasi Umum Aplikasi
 * Sistem Pakar Rekomendasi Jurusan PTN - Metode Dempster-Shafer
 * SMA Muhammadiyah 18 Sunggal
 */

// ==== Base URL ====
// Sesuaikan nama folder proyek jika berbeda saat instalasi di XAMPP
define('BASE_URL', 'http://localhost/sipakar-jurusan/');
define('APP_NAME', 'SiJurusan | Sistem Pakar Rekomendasi Jurusan PTN');
define('APP_VERSION', '1.0.0');

// ==== Path Absolut ====
define('ROOT_PATH', dirname(__DIR__));
define('CONTROLLER_PATH', ROOT_PATH . '/controllers/');
define('MODEL_PATH', ROOT_PATH . '/models/');
define('VIEW_PATH', ROOT_PATH . '/views/');
define('HELPER_PATH', ROOT_PATH . '/helpers/');
define('CORE_PATH', ROOT_PATH . '/core/');
define('UPLOAD_PATH', ROOT_PATH . '/assets/uploads/');
define('UPLOAD_URL', BASE_URL . 'assets/uploads/');

// ==== Environment ====
define('APP_ENV', 'development'); // development | production
define('APP_DEBUG', true);

// ==== Session Security ====
define('SESSION_LIFETIME', 7200); // 2 jam dalam detik
define('CSRF_TOKEN_NAME', 'csrf_token');

// ==== Error Reporting ====
if (APP_ENV === 'development') {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}

// ==== Timezone ====
date_default_timezone_set('Asia/Jakarta');

// ==== Session Configuration (harus sebelum session_start) ====
if (session_status() === PHP_SESSION_NONE) {
    ini_set('session.cookie_httponly', 1);
    ini_set('session.use_only_cookies', 1);
    ini_set('session.cookie_samesite', 'Lax');
    session_set_cookie_params(SESSION_LIFETIME);
    session_start();
}

// ==== Upload Restrictions ====
define('MAX_UPLOAD_SIZE', 4 * 1024 * 1024); // 4MB
define('ALLOWED_IMAGE_TYPES', ['image/jpeg', 'image/png', 'image/webp', 'image/gif']);
define('ALLOWED_DOC_TYPES', ['application/pdf']);

// ==== Dempster-Shafer Constants ====
define('DS_THETA_DEFAULT', 1.0); // Theta (semesta) awal sebelum evidence apapun
define('DS_MIN_BELIEF', 0.0);
define('DS_MAX_BELIEF', 1.0);
define('DS_TOP_RANKING', 5); // Jumlah ranking jurusan yang ditampilkan
