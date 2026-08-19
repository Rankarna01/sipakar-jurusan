<?php
/**
 * Kumpulan fungsi bantu (helper) global
 */

/**
 * Membersihkan input dari karakter berbahaya (XSS Protection)
 */
function clean(?string $string): string
{
    if ($string === null) return '';
    return htmlspecialchars(trim($string), ENT_QUOTES, 'UTF-8');
}

/**
 * Generate CSRF Token dan simpan ke session
 */
function csrf_token(): string
{
    if (empty($_SESSION[CSRF_TOKEN_NAME])) {
        $_SESSION[CSRF_TOKEN_NAME] = bin2hex(random_bytes(32));
    }
    return $_SESSION[CSRF_TOKEN_NAME];
}

/**
 * Cetak input hidden CSRF token untuk form
 */
function csrf_field(): string
{
    return '<input type="hidden" name="' . CSRF_TOKEN_NAME . '" value="' . csrf_token() . '">';
}

/**
 * Validasi CSRF Token dari request
 */
function verify_csrf(?string $token): bool
{
    if (empty($token) || empty($_SESSION[CSRF_TOKEN_NAME])) {
        return false;
    }
    return hash_equals($_SESSION[CSRF_TOKEN_NAME], $token);
}

/**
 * Generate slug dari string (untuk URL friendly)
 */
function generate_slug(string $string): string
{
    $slug = strtolower(trim($string));
    $slug = preg_replace('/[^a-z0-9]+/', '-', $slug);
    return trim($slug, '-');
}

/**
 * Generate kode unik dengan prefix (contoh: KONS-20260728-A1B2)
 */
function generate_code(string $prefix): string
{
    return strtoupper($prefix) . '-' . date('Ymd') . '-' . strtoupper(substr(bin2hex(random_bytes(4)), 0, 6));
}

/**
 * Format tanggal ke format Indonesia
 */
function format_tanggal(?string $date, bool $withTime = false): string
{
    if (empty($date)) return '-';
    $bulan = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
    $ts = strtotime($date);
    $result = date('d', $ts) . ' ' . $bulan[(int)date('n', $ts)] . ' ' . date('Y', $ts);
    if ($withTime) {
        $result .= ', ' . date('H:i', $ts) . ' WIB';
    }
    return $result;
}

/**
 * Format angka desimal ke persentase
 */
function format_persen(float $value, int $decimal = 2): string
{
    return number_format($value * 100, $decimal, ',', '.') . '%';
}

/**
 * Cek apakah siswa sedang login
 */
function is_siswa_login(): bool
{
    return isset($_SESSION['siswa_id']);
}

/**
 * Cek apakah admin sedang login
 */
function is_admin_login(): bool
{
    return isset($_SESSION['admin_id']);
}

/**
 * Ambil nilai setting dari database (dengan cache statis per request)
 */
function get_setting(string $key, $default = '')
{
    static $cache = [];
    if (empty($cache)) {
        $db = Database::getInstance();
        $stmt = $db->query("SELECT setting_key, setting_value FROM setting");
        foreach ($stmt->fetchAll() as $row) {
            $cache[$row['setting_key']] = $row['setting_value'];
        }
    }
    return $cache[$key] ?? $default;
}

/**
 * Redirect helper global (dipakai di luar controller, misal index.php)
 */
function redirect_to(string $path): void
{
    header('Location: ' . BASE_URL . ltrim($path, '/'));
    exit;
}

/**
 * Catat aktivitas admin ke log_activity (audit trail)
 */
function log_activity(string $modul, string $aksi, string $deskripsi = '', $dataLama = null, $dataBaru = null): void
{
    $db = Database::getInstance();
    $stmt = $db->prepare("INSERT INTO log_activity (id_admin, modul, aksi, deskripsi, data_lama, data_baru, ip_address) 
                           VALUES (:id_admin, :modul, :aksi, :deskripsi, :data_lama, :data_baru, :ip_address)");
    $stmt->execute([
        'id_admin'    => $_SESSION['admin_id'] ?? null,
        'modul'       => $modul,
        'aksi'        => $aksi,
        'deskripsi'   => $deskripsi,
        'data_lama'   => $dataLama ? json_encode($dataLama, JSON_UNESCAPED_UNICODE) : null,
        'data_baru'   => $dataBaru ? json_encode($dataBaru, JSON_UNESCAPED_UNICODE) : null,
        'ip_address'  => $_SERVER['REMOTE_ADDR'] ?? null,
    ]);
}

/**
 * Catat log login (berhasil/gagal)
 */
function log_login(string $userType, ?int $userId, string $username, string $status, string $keterangan = ''): void
{
    $db = Database::getInstance();
    $stmt = $db->prepare("INSERT INTO log_login (user_type, user_id, username, ip_address, user_agent, status, keterangan) 
                           VALUES (:user_type, :user_id, :username, :ip_address, :user_agent, :status, :keterangan)");
    $stmt->execute([
        'user_type'  => $userType,
        'user_id'    => $userId,
        'username'   => $username,
        'ip_address' => $_SERVER['REMOTE_ADDR'] ?? null,
        'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? null,
        'status'     => $status,
        'keterangan' => $keterangan,
    ]);
}

/**
 * Validasi upload file gambar
 */
function validate_image_upload(array $file): array
{
    $errors = [];
    if ($file['error'] !== UPLOAD_ERR_OK) {
        $errors[] = 'Terjadi kesalahan saat upload file.';
        return $errors;
    }
    if ($file['size'] > MAX_UPLOAD_SIZE) {
        $errors[] = 'Ukuran file maksimal 4MB.';
    }
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime = finfo_file($finfo, $file['tmp_name']);
    finfo_close($finfo);
    if (!in_array($mime, ALLOWED_IMAGE_TYPES, true)) {
        $errors[] = 'Format file harus JPG, PNG, WEBP, atau GIF.';
    }
    return $errors;
}

/**
 * Upload file gambar ke folder tertentu, mengembalikan nama file baru atau null
 */
function upload_image(array $file, string $folder = 'general'): ?string
{
    $errors = validate_image_upload($file);
    if (!empty($errors)) {
        return null;
    }
    $targetDir = UPLOAD_PATH . $folder . '/';
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0755, true);
    }
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $newName = uniqid($folder . '_') . '.' . $ext;
    if (move_uploaded_file($file['tmp_name'], $targetDir . $newName)) {
        return $folder . '/' . $newName;
    }
    return null;
}

/**
 * Memotong teks dengan aman, dengan fallback jika ekstensi mbstring tidak aktif
 */
function truncate_text(?string $text, int $length = 100, string $suffix = '...'): string
{
    if ($text === null || $text === '') return '';
    if (function_exists('mb_strimwidth')) {
        return mb_strimwidth($text, 0, $length, $suffix);
    }
    // Fallback tanpa mbstring
    if (strlen($text) <= $length) return $text;
    return substr($text, 0, $length) . $suffix;
}

/**
 * Mengembalikan emoji yang relevan untuk sebuah nama fakultas (untuk tampilan kekinian)
 */
function get_fakultas_emoji(string $namaFakultas): string
{
    $map = [
        'Kedokteran' => '🩺',
        'Farmasi' => '💊',
        'Ilmu Keperawatan' => '🏥',
        'Kesehatan Masyarakat dan Gizi' => '🥗',
        'Kedokteran Hewan' => '🐾',
        'Teknik' => '⚙️',
        'Ilmu Komputer' => '💻',
        'Geografi dan Perencanaan' => '🗺️',
        'Ekonomi dan Bisnis' => '📈',
        'Hukum' => '⚖️',
        'Pendidikan' => '🎓',
        'Ilmu Keolahragaan' => '🏆',
        'Psikologi' => '🧠',
        'MIPA' => '🔬',
        'Ilmu Sosial dan Politik' => '🏛️',
        'Ilmu Komunikasi' => '📡',
        'Ilmu Budaya' => '📚',
        'Pertanian' => '🌾',
        'Peternakan' => '🐄',
        'Perikanan dan Ilmu Kelautan' => '🐟',
        'Seni dan Desain' => '🎨',
    ];
    return $map[$namaFakultas] ?? '🎓';
}

/**
 * Debug helper (hanya aktif jika APP_DEBUG true)
 */
function dd(...$vars): void
{
    if (APP_DEBUG) {
        echo '<pre style="background:#1e293b;color:#e2e8f0;padding:1rem;border-radius:8px;">';
        foreach ($vars as $var) {
            print_r($var);
        }
        echo '</pre>';
    }
    exit;
}
