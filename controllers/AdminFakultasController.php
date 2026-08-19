<?php
/**
 * AdminFakultasController - CRUD Master Fakultas
 */
class AdminFakultasController extends Controller
{
    private $fakultasModel;

    public function __construct()
    {
        if (!is_admin_login()) { $this->redirect('auth/adminLogin'); }
        $this->fakultasModel = $this->model('Fakultas');
    }

    public function index()
    {
        $this->view('admin/fakultas/index', [
            'title' => 'Master Fakultas - Admin',
            'pageTitle' => 'Master Fakultas',
            'activeMenu' => 'fakultas',
            'fakultas' => $this->fakultasModel->allWithJumlahJurusan(),
        ]);
    }

    public function tambah()
    {
        $this->view('admin/fakultas/form', [
            'title' => 'Tambah Fakultas - Admin', 'pageTitle' => 'Tambah Fakultas',
            'activeMenu' => 'fakultas', 'fakultas' => null,
        ]);
    }

    public function simpan()
    {
        $this->onlyPost();
        if (!verify_csrf($_POST[CSRF_TOKEN_NAME] ?? '')) { die('Token tidak valid'); }

        $nama = clean($_POST['nama_fakultas']);
        $data = [
            'kode_fakultas' => clean($_POST['kode_fakultas']),
            'nama_fakultas' => $nama,
            'slug' => generate_slug($nama),
            'deskripsi' => clean($_POST['deskripsi'] ?? ''),
            'icon' => clean($_POST['icon'] ?? 'bi-mortarboard'),
            'urutan' => (int) ($_POST['urutan'] ?? 0),
        ];

        if (!empty($_FILES['gambar']['name'])) {
            $data['gambar'] = upload_image($_FILES['gambar'], 'fakultas');
        }

        $id = $this->fakultasModel->insert($data);
        log_activity('Master Fakultas', 'create', "Menambahkan fakultas: $nama", null, $data);

        $_SESSION['success'] = 'Fakultas berhasil ditambahkan.';
        $this->redirect('adminFakultas');
    }

    public function edit($id)
    {
        $fakultas = $this->fakultasModel->find($id);
        if (!$fakultas) { $this->redirect('adminFakultas'); return; }
        $this->view('admin/fakultas/form', [
            'title' => 'Edit Fakultas - Admin', 'pageTitle' => 'Edit Fakultas',
            'activeMenu' => 'fakultas', 'fakultas' => $fakultas,
        ]);
    }

    public function update($id)
    {
        $this->onlyPost();
        if (!verify_csrf($_POST[CSRF_TOKEN_NAME] ?? '')) { die('Token tidak valid'); }

        $old = $this->fakultasModel->find($id);
        $nama = clean($_POST['nama_fakultas']);
        $data = [
            'kode_fakultas' => clean($_POST['kode_fakultas']),
            'nama_fakultas' => $nama,
            'slug' => generate_slug($nama),
            'deskripsi' => clean($_POST['deskripsi'] ?? ''),
            'icon' => clean($_POST['icon'] ?? 'bi-mortarboard'),
            'urutan' => (int) ($_POST['urutan'] ?? 0),
            'status' => $_POST['status'] ?? 'aktif',
        ];

        if (!empty($_FILES['gambar']['name'])) {
            $data['gambar'] = upload_image($_FILES['gambar'], 'fakultas');
        }

        $this->fakultasModel->update($id, $data);
        log_activity('Master Fakultas', 'update', "Mengubah fakultas: $nama", $old, $data);

        $_SESSION['success'] = 'Fakultas berhasil diperbarui.';
        $this->redirect('adminFakultas');
    }

    public function hapus($id)
    {
        $old = $this->fakultasModel->find($id);
        if ($old) {
            $this->fakultasModel->delete($id);
            log_activity('Master Fakultas', 'delete', "Menghapus fakultas: {$old['nama_fakultas']}", $old, null);
        }
        $_SESSION['success'] = 'Fakultas berhasil dihapus.';
        $this->redirect('adminFakultas');
    }
}
