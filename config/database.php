<?php
/**
 * Konfigurasi Koneksi Database
 * Otomatis mendeteksi environment (Localhost vs Production)
 */

$is_localhost = in_array($_SERVER['HTTP_HOST'] ?? '', ['localhost', '127.0.0.1', '::1']);
$is_localhost = $is_localhost || (strpos($_SERVER['HTTP_HOST'] ?? '', 'localhost:') === 0);

if ($is_localhost) {
    // ==== KREDENSIAL LOKAL (XAMPP/MAMP/Laragon) ====
    define('DB_HOST', 'localhost');
    define('DB_NAME', 'sipakar');
    define('DB_USER', 'root');
    define('DB_PASS', '');
    define('DB_CHARSET', 'utf8mb4');
} else {
    // ==== KREDENSIAL PRODUCTION (Hosting/Server) ====
    define('DB_HOST', 'localhost'); // Biasanya di hosting tetap localhost
    define('DB_NAME', 'u117434194_sipakar');
    define('DB_USER', 'u117434194_sipakar');
    define('DB_PASS', 'Randy2005_');
    define('DB_CHARSET', 'utf8mb4');
}
