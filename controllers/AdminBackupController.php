<?php
/**
 * AdminBackupController - Backup & Restore Database
 * Menggunakan pendekatan native PHP (tanpa shell_exec mysqldump agar portable
 * di shared hosting XAMPP tanpa akses CLI penuh).
 */
class AdminBackupController extends Controller
{
    private $db;

    public function __construct()
    {
        if (!is_admin_login()) { $this->redirect('auth/adminLogin'); }
        $this->db = Database::getInstance();
    }

    public function index()
    {
        $backupDir = ROOT_PATH . '/database/backups/';
        $files = [];
        if (is_dir($backupDir)) {
            foreach (scandir($backupDir) as $f) {
                if (str_ends_with($f, '.sql')) {
                    $files[] = ['nama' => $f, 'ukuran' => round(filesize($backupDir . $f) / 1024, 2), 'tanggal' => date('d M Y H:i', filemtime($backupDir . $f))];
                }
            }
        }
        $this->view('admin/backup/index', [
            'title' => 'Backup Database - Admin', 'pageTitle' => 'Backup & Restore Database',
            'activeMenu' => 'backup', 'files' => array_reverse($files),
        ]);
    }

    /** Backup seluruh tabel menjadi file SQL, lalu diunduh */
    public function backup()
    {
        $backupDir = ROOT_PATH . '/database/backups/';
        if (!is_dir($backupDir)) { mkdir($backupDir, 0755, true); }

        $filename = 'backup_sipakar_' . date('Ymd_His') . '.sql';
        $filepath = $backupDir . $filename;

        $tables = $this->db->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
        $sql = "-- Backup Database sipakar_jurusan\n-- Dibuat: " . date('Y-m-d H:i:s') . "\n\n";
        $sql .= "SET FOREIGN_KEY_CHECKS=0;\n\n";

        foreach ($tables as $table) {
            $sql .= "-- Struktur tabel `$table`\n";
            $createStmt = $this->db->query("SHOW CREATE TABLE `$table`")->fetch();
            $sql .= "DROP TABLE IF EXISTS `$table`;\n" . $createStmt['Create Table'] . ";\n\n";

            $rows = $this->db->query("SELECT * FROM `$table`")->fetchAll();
            if ($rows) {
                $sql .= "-- Data tabel `$table`\n";
                foreach ($rows as $row) {
                    $values = array_map(function ($v) {
                        if ($v === null) return 'NULL';
                        return $this->db->quote($v);
                    }, array_values($row));
                    $columns = '`' . implode('`, `', array_keys($row)) . '`';
                    $sql .= "INSERT INTO `$table` ($columns) VALUES (" . implode(', ', $values) . ");\n";
                }
                $sql .= "\n";
            }
        }
        $sql .= "SET FOREIGN_KEY_CHECKS=1;\n";

        file_put_contents($filepath, $sql);
        log_activity('Backup Database', 'backup', "Membuat backup: $filename");

        // Unduh langsung
        header('Content-Type: application/sql');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Content-Length: ' . filesize($filepath));
        readfile($filepath);
        exit;
    }

    /** Restore database dari file SQL yang diupload */
    public function restore()
    {
        $this->onlyPost();
        if (!verify_csrf($_POST[CSRF_TOKEN_NAME] ?? '')) { die('Token tidak valid'); }

        if (empty($_FILES['file_sql']['name']) || $_FILES['file_sql']['error'] !== UPLOAD_ERR_OK) {
            $_SESSION['error'] = 'File SQL wajib diunggah.';
            $this->redirect('adminBackup');
            return;
        }

        $content = file_get_contents($_FILES['file_sql']['tmp_name']);
        if ($content === false) {
            $_SESSION['error'] = 'Gagal membaca file SQL.';
            $this->redirect('adminBackup');
            return;
        }

        try {
            // Eksekusi query secara batch (dipisah per titik koma pada akhir baris)
            $queries = array_filter(array_map('trim', explode(";\n", $content)));
            $this->db->beginTransaction();
            foreach ($queries as $query) {
                if ($query !== '') {
                    $this->db->exec($query);
                }
            }
            $this->db->commit();
            log_activity('Backup Database', 'restore', 'Melakukan restore database dari file upload');
            $_SESSION['success'] = 'Database berhasil di-restore.';
        } catch (Exception $e) {
            $this->db->rollBack();
            $_SESSION['error'] = 'Gagal restore: ' . $e->getMessage();
        }

        $this->redirect('adminBackup');
    }

    public function download($filename)
    {
        $filepath = ROOT_PATH . '/database/backups/' . basename($filename);
        if (!file_exists($filepath)) {
            die('File tidak ditemukan.');
        }
        header('Content-Type: application/sql');
        header('Content-Disposition: attachment; filename="' . basename($filename) . '"');
        readfile($filepath);
        exit;
    }
}
