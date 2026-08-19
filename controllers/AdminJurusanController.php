<?php
/**
 * AdminJurusanController - CRUD Master Jurusan
 */
class AdminJurusanController extends Controller
{
    private $jurusanModel;
    private $fakultasModel;

    public function __construct()
    {
        if (!is_admin_login()) { $this->redirect('auth/adminLogin'); }
        $this->jurusanModel = $this->model('Jurusan');
        $this->fakultasModel = $this->model('Fakultas');
    }

    public function index()
    {
        $this->view('admin/jurusan/index', [
            'title' => 'Master Jurusan - Admin', 'pageTitle' => 'Master Jurusan',
            'activeMenu' => 'jurusan', 'jurusan' => $this->jurusanModel->allWithFakultas(),
        ]);
    }

    public function tambah()
    {
        $this->view('admin/jurusan/form', [
            'title' => 'Tambah Jurusan - Admin', 'pageTitle' => 'Tambah Jurusan',
            'activeMenu' => 'jurusan', 'jurusan' => null,
            'fakultasList' => $this->fakultasModel->all('nama_fakultas'),
        ]);
    }

    public function simpan()
    {
        $this->onlyPost();
        if (!verify_csrf($_POST[CSRF_TOKEN_NAME] ?? '')) { die('Token tidak valid'); }

        $nama = clean($_POST['nama_jurusan']);
        $data = [
            'id_fakultas' => (int) $_POST['id_fakultas'],
            'kode_jurusan' => clean($_POST['kode_jurusan']),
            'nama_jurusan' => $nama,
            'slug' => generate_slug($nama),
            'deskripsi' => clean($_POST['deskripsi'] ?? ''),
            'skill_dibutuhkan' => clean($_POST['skill_dibutuhkan'] ?? ''),
            'prospek_kerja' => clean($_POST['prospek_kerja'] ?? ''),
            'peluang_karier' => clean($_POST['peluang_karier'] ?? ''),
            'mata_kuliah_inti' => clean($_POST['mata_kuliah_inti'] ?? ''),
            'range_gaji' => clean($_POST['range_gaji'] ?? ''),
            'top_kampus' => clean($_POST['top_kampus'] ?? ''),
            'icon' => clean($_POST['icon'] ?? 'bi-book'),
        ];

        if (!empty($_FILES['gambar']['name'])) {
            $errGambar = validate_image_upload($_FILES['gambar']);
            if (!empty($errGambar)) {
                $_SESSION['error'] = implode(' ', $errGambar);
                $this->redirect('adminJurusan/tambah');
                return;
            }
            $data['gambar'] = upload_image($_FILES['gambar'], 'jurusan');
        }

        $this->jurusanModel->insert($data);
        log_activity('Master Jurusan', 'create', "Menambahkan jurusan: $nama", null, $data);

        $_SESSION['success'] = 'Jurusan berhasil ditambahkan.';
        $this->redirect('adminJurusan');
    }

    public function edit($id)
    {
        $jurusan = $this->jurusanModel->find($id);
        if (!$jurusan) { $this->redirect('adminJurusan'); return; }
        $this->view('admin/jurusan/form', [
            'title' => 'Edit Jurusan - Admin', 'pageTitle' => 'Edit Jurusan',
            'activeMenu' => 'jurusan', 'jurusan' => $jurusan,
            'fakultasList' => $this->fakultasModel->all('nama_fakultas'),
        ]);
    }

    public function update($id)
    {
        $this->onlyPost();
        if (!verify_csrf($_POST[CSRF_TOKEN_NAME] ?? '')) { die('Token tidak valid'); }

        $old = $this->jurusanModel->find($id);
        $nama = clean($_POST['nama_jurusan']);
        $data = [
            'id_fakultas' => (int) $_POST['id_fakultas'],
            'kode_jurusan' => clean($_POST['kode_jurusan']),
            'nama_jurusan' => $nama,
            'slug' => generate_slug($nama),
            'deskripsi' => clean($_POST['deskripsi'] ?? ''),
            'skill_dibutuhkan' => clean($_POST['skill_dibutuhkan'] ?? ''),
            'prospek_kerja' => clean($_POST['prospek_kerja'] ?? ''),
            'peluang_karier' => clean($_POST['peluang_karier'] ?? ''),
            'mata_kuliah_inti' => clean($_POST['mata_kuliah_inti'] ?? ''),
            'range_gaji' => clean($_POST['range_gaji'] ?? ''),
            'top_kampus' => clean($_POST['top_kampus'] ?? ''),
            'icon' => clean($_POST['icon'] ?? 'bi-book'),
            'status' => $_POST['status'] ?? 'aktif',
        ];

        if (!empty($_FILES['gambar']['name'])) {
            $errGambar = validate_image_upload($_FILES['gambar']);
            if (!empty($errGambar)) {
                $_SESSION['error'] = implode(' ', $errGambar);
                $this->redirect('adminJurusan/edit/' . $id);
                return;
            }
            $data['gambar'] = upload_image($_FILES['gambar'], 'jurusan');
        }

        $this->jurusanModel->update($id, $data);
        log_activity('Master Jurusan', 'update', "Mengubah jurusan: $nama", $old, $data);

        $_SESSION['success'] = 'Jurusan berhasil diperbarui.';
        $this->redirect('adminJurusan');
    }

    public function hapus($id)
    {
        $old = $this->jurusanModel->find($id);
        if ($old) {
            $this->jurusanModel->delete($id);
            log_activity('Master Jurusan', 'delete', "Menghapus jurusan: {$old['nama_jurusan']}", $old, null);
        }
        $_SESSION['success'] = 'Jurusan berhasil dihapus.';
        $this->redirect('adminJurusan');
    }
}
