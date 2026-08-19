<?php
/**
 * AdminPengembangController
 * CRUD profil pengembang sistem (maksimal 5, tampil di halaman Kontak publik)
 */
class AdminPengembangController extends Controller
{
    const MAX_PENGEMBANG = 5;

    private $pengembangModel;

    public function __construct()
    {
        if (!is_admin_login()) { $this->redirect('auth/adminLogin'); }
        $this->pengembangModel = $this->model('Pengembang');
    }

    public function index()
    {
        $this->view('admin/pengembang/index', [
            'title' => 'Master Pengembang - Admin',
            'pageTitle' => 'Master Pengembang',
            'activeMenu' => 'pengembang',
            'pengembang' => $this->pengembangModel->all('urutan', 'ASC'),
            'maxPengembang' => self::MAX_PENGEMBANG,
        ]);
    }

    public function tambah()
    {
        $total = $this->pengembangModel->count();
        if ($total >= self::MAX_PENGEMBANG) {
            $_SESSION['error'] = 'Maksimal ' . self::MAX_PENGEMBANG . ' pengembang. Hapus salah satu terlebih dahulu untuk menambah yang baru.';
            $this->redirect('adminPengembang');
            return;
        }
        $this->view('admin/pengembang/form', [
            'title' => 'Tambah Pengembang - Admin', 'pageTitle' => 'Tambah Pengembang',
            'activeMenu' => 'pengembang', 'pengembang' => null,
        ]);
    }

    public function simpan()
    {
        $this->onlyPost();
        if (!verify_csrf($_POST[CSRF_TOKEN_NAME] ?? '')) { die('Token tidak valid'); }

        $total = $this->pengembangModel->count();
        if ($total >= self::MAX_PENGEMBANG) {
            $_SESSION['error'] = 'Maksimal ' . self::MAX_PENGEMBANG . ' pengembang.';
            $this->redirect('adminPengembang');
            return;
        }

        $data = [
            'nama' => clean($_POST['nama']),
            'jabatan' => clean($_POST['jabatan'] ?? ''),
            'bio' => clean($_POST['bio'] ?? ''),
            'keahlian' => clean($_POST['keahlian'] ?? ''),
            'urutan' => (int) ($_POST['urutan'] ?? 0),
        ];

        if (!empty($_FILES['foto']['name'])) {
            $errFoto = validate_image_upload($_FILES['foto']);
            if (!empty($errFoto)) {
                $_SESSION['error'] = implode(' ', $errFoto);
                $this->redirect('adminPengembang/tambah');
                return;
            }
            $data['foto'] = upload_image($_FILES['foto'], 'pengembang');
        }

        $this->pengembangModel->insert($data);
        log_activity('Master Pengembang', 'create', "Menambahkan pengembang: {$data['nama']}");
        $_SESSION['success'] = 'Pengembang berhasil ditambahkan.';
        $this->redirect('adminPengembang');
    }

    public function edit($id)
    {
        $pengembang = $this->pengembangModel->find($id);
        if (!$pengembang) { $this->redirect('adminPengembang'); return; }
        $this->view('admin/pengembang/form', [
            'title' => 'Edit Pengembang - Admin', 'pageTitle' => 'Edit Pengembang',
            'activeMenu' => 'pengembang', 'pengembang' => $pengembang,
        ]);
    }

    public function update($id)
    {
        $this->onlyPost();
        if (!verify_csrf($_POST[CSRF_TOKEN_NAME] ?? '')) { die('Token tidak valid'); }

        $data = [
            'nama' => clean($_POST['nama']),
            'jabatan' => clean($_POST['jabatan'] ?? ''),
            'bio' => clean($_POST['bio'] ?? ''),
            'keahlian' => clean($_POST['keahlian'] ?? ''),
            'urutan' => (int) ($_POST['urutan'] ?? 0),
            'status' => $_POST['status'] ?? 'aktif',
        ];

        if (!empty($_FILES['foto']['name'])) {
            $errFoto = validate_image_upload($_FILES['foto']);
            if (!empty($errFoto)) {
                $_SESSION['error'] = implode(' ', $errFoto);
                $this->redirect('adminPengembang/edit/' . $id);
                return;
            }
            $data['foto'] = upload_image($_FILES['foto'], 'pengembang');
        }

        $this->pengembangModel->update($id, $data);
        log_activity('Master Pengembang', 'update', "Mengubah pengembang #$id");
        $_SESSION['success'] = 'Pengembang berhasil diperbarui.';
        $this->redirect('adminPengembang');
    }

    public function hapus($id)
    {
        $old = $this->pengembangModel->find($id);
        if ($old) {
            $this->pengembangModel->delete($id);
            log_activity('Master Pengembang', 'delete', "Menghapus pengembang: {$old['nama']}");
        }
        $_SESSION['success'] = 'Pengembang berhasil dihapus.';
        $this->redirect('adminPengembang');
    }
}
