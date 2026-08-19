<?php
/**
 * AdminPengaturanController - Pengaturan website & konsultasi (key-value setting)
 */
class AdminPengaturanController extends Controller
{
    private $db;

    public function __construct()
    {
        if (!is_admin_login()) { $this->redirect('auth/adminLogin'); }
        $this->db = Database::getInstance();
    }

    public function index()
    {
        $rows = $this->db->query("SELECT * FROM setting")->fetchAll();
        $settings = [];
        foreach ($rows as $r) {
            $settings[$r['setting_key']] = $r['setting_value'];
        }

        $this->view('admin/pengaturan/index', [
            'title' => 'Pengaturan - Admin', 'pageTitle' => 'Pengaturan Website & Konsultasi',
            'activeMenu' => 'pengaturan', 'settings' => $settings,
        ]);
    }

    public function simpan()
    {
        $this->onlyPost();
        if (!verify_csrf($_POST[CSRF_TOKEN_NAME] ?? '')) { die('Token tidak valid'); }

        $keys = [
            'nama_sekolah', 'alamat_sekolah', 'nama_sistem', 'no_wa', 'email_kontak', 'copyright_text',
            'smtp_host', 'smtp_port', 'smtp_username', 'smtp_password', 'smtp_encryption', 'smtp_from_email',
            'dev_nama', 'dev_jabatan', 'dev_bio', 'dev_keahlian',
        ];

        foreach ($keys as $key) {
            $this->upsertSetting($key, clean($_POST[$key] ?? ''));
        }

        // Toggle switch (checkbox): jika tidak dicentang, tidak terkirim di POST
        $this->upsertSetting('wajib_login', isset($_POST['wajib_login']) ? '1' : '0');
        $this->upsertSetting('dark_mode_default', isset($_POST['dark_mode_default']) ? '1' : '0');
        $this->upsertSetting('email_notif_aktif', isset($_POST['email_notif_aktif']) ? '1' : '0');

        if (!empty($_FILES['logo']['name'])) {
            $logo = upload_image($_FILES['logo'], 'setting');
            if ($logo) $this->upsertSetting('logo', $logo);
        }
        if (!empty($_FILES['favicon']['name'])) {
            $favicon = upload_image($_FILES['favicon'], 'setting');
            if ($favicon) $this->upsertSetting('favicon', $favicon);
        }
        if (!empty($_FILES['dev_foto']['name'])) {
            $errFoto = validate_image_upload($_FILES['dev_foto']);
            if (empty($errFoto)) {
                $devFoto = upload_image($_FILES['dev_foto'], 'setting');
                if ($devFoto) $this->upsertSetting('dev_foto', $devFoto);
            }
        }
        if (!empty($_FILES['konsultasi_banner']['name'])) {
            $errBanner = validate_image_upload($_FILES['konsultasi_banner']);
            if (empty($errBanner)) {
                $banner = upload_image($_FILES['konsultasi_banner'], 'setting');
                if ($banner) $this->upsertSetting('konsultasi_banner', $banner);
            }
        }

        log_activity('Pengaturan', 'update', 'Memperbarui pengaturan website & konsultasi');
        $_SESSION['success'] = 'Pengaturan berhasil disimpan.';
        $this->redirect('adminPengaturan');
    }

    private function upsertSetting(string $key, string $value): void
    {
        $stmt = $this->db->prepare("SELECT id_setting FROM setting WHERE setting_key = :k");
        $stmt->execute(['k' => $key]);
        if ($stmt->fetch()) {
            $upd = $this->db->prepare("UPDATE setting SET setting_value = :v WHERE setting_key = :k");
            $upd->execute(['v' => $value, 'k' => $key]);
        } else {
            $ins = $this->db->prepare("INSERT INTO setting (setting_key, setting_value) VALUES (:k, :v)");
            $ins->execute(['k' => $key, 'v' => $value]);
        }
    }
}
