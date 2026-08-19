<?php
/**
 * Class Database
 * Mengelola koneksi database menggunakan PDO dengan pola Singleton
 * agar hanya ada satu koneksi aktif di seluruh aplikasi.
 */

class Database
{
    private static ?PDO $instance = null;

    /**
     * Mendapatkan instance koneksi PDO (Singleton)
     */
    public static function getInstance(): PDO
    {
        if (self::$instance === null) {
            try {
                $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET;
                $options = [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES   => false, // Mencegah SQL Injection lebih ketat
                ];
                self::$instance = new PDO($dsn, DB_USER, DB_PASS, $options);
            } catch (PDOException $e) {
                error_log('Database Connection Error: ' . $e->getMessage());
                if (APP_DEBUG) {
                    die('Koneksi database gagal: ' . $e->getMessage());
                }
                die('Koneksi database gagal. Silakan hubungi administrator.');
            }
        }
        return self::$instance;
    }

    // Mencegah instansiasi & cloning langsung (Singleton)
    private function __construct() {}
    private function __clone() {}
}
