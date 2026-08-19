<?php
/**
 * AdminSliderController - CRUD Slider Homepage
 */
class AdminSliderController extends Controller
{
    private $db;

    public function __construct()
    {
        if (!is_admin_login()) { $this->redirect('auth/adminLogin'); }
        $this->db = Database::getInstance();
    }

    public function index()
    {
        $slider = $this->db->query("SELECT * FROM slider ORDER BY urutan ASC")->fetchAll();
        $this->view('admin/slider/index', [
            'title' => 'Slider - Admin', 'pageTitle' => 'Slider Homepage',
            'activeMenu' => 'slider', 'slider' => $slider,
        ]);
    }

    public function tambah()
    {
        $this->view('admin/slider/form', [
            'title' => 'Tambah Slider - Admin', 'pageTitle' => 'Tambah Slider',
            'activeMenu' => 'slider', 'slider' => null,
        ]);
    }

    public function simpan()
    {
        $this->onlyPost();
        if (!verify_csrf($_POST[CSRF_TOKEN_NAME] ?? '')) { die('Token tidak valid'); }

        if (empty($_FILES['gambar']['name'])) {
            $_SESSION['error'] = 'Gambar wajib diunggah.';
            $this->redirect('adminSlider/tambah');
            return;
        }
        $errors = validate_image_upload($_FILES['gambar']);
        if (!empty($errors)) {
            $_SESSION['error'] = implode(' ', $errors);
            $this->redirect('adminSlider/tambah');
            return;
        }
        $gambar = upload_image($_FILES['gambar'], 'slider');

        $stmt = $this->db->prepare(
            "INSERT INTO slider (judul, subjudul, gambar, link_tombol, teks_tombol, urutan) VALUES (:j,:s,:g,:l,:t,:u)"
        );
        $stmt->execute([
            'j' => clean($_POST['judul'] ?? ''), 's' => clean($_POST['subjudul'] ?? ''),
            'g' => $gambar, 'l' => clean($_POST['link_tombol'] ?? ''),
            't' => clean($_POST['teks_tombol'] ?? ''), 'u' => (int) ($_POST['urutan'] ?? 0),
        ]);

        log_activity('Slider', 'create', 'Menambahkan slider baru');
        $_SESSION['success'] = 'Slider berhasil ditambahkan.';
        $this->redirect('adminSlider');
    }

    public function hapus($id)
    {
        $stmt = $this->db->prepare("DELETE FROM slider WHERE id_slider = :id");
        $stmt->execute(['id' => $id]);
        log_activity('Slider', 'delete', "Menghapus slider #$id");
        $_SESSION['success'] = 'Slider berhasil dihapus.';
        $this->redirect('adminSlider');
    }

    public function toggleStatus($id)
    {
        $stmt = $this->db->prepare("SELECT status FROM slider WHERE id_slider = :id");
        $stmt->execute(['id' => $id]);
        $current = $stmt->fetch();
        if ($current) {
            $newStatus = $current['status'] === 'aktif' ? 'nonaktif' : 'aktif';
            $upd = $this->db->prepare("UPDATE slider SET status = :s WHERE id_slider = :id");
            $upd->execute(['s' => $newStatus, 'id' => $id]);
        }
        $_SESSION['success'] = 'Status slider berhasil diperbarui.';
        $this->redirect('adminSlider');
    }
}
