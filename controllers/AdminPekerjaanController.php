<?php
/**
 * AdminPekerjaanController - CRUD Master Pekerjaan
 */
class AdminPekerjaanController extends Controller
{
    private $db;
    private $pekerjaanModel;

    public function __construct()
    {
        if (!is_admin_login()) {
            $this->redirect('auth/adminLogin');
        }
        $this->db = Database::getInstance();
        $this->pekerjaanModel = $this->model('PekerjaanModel');
    }

    public function index()
    {
        $pekerjaan = $this->pekerjaanModel->findAllWithRelations();
        
        $this->view('admin/pekerjaan/index', [
            'title' => 'Master Pekerjaan - Admin',
            'pageTitle' => 'Master Pekerjaan',
            'activeMenu' => 'pekerjaan',
            'pekerjaan' => $pekerjaan
        ]);
    }

    public function tambah()
    {
        $jurusan = $this->db->query("SELECT id_jurusan, nama_jurusan FROM jurusan ORDER BY nama_jurusan ASC")->fetchAll();
        
        $this->view('admin/pekerjaan/form', [
            'title' => 'Tambah Pekerjaan - Admin',
            'pageTitle' => 'Tambah Pekerjaan Baru',
            'activeMenu' => 'pekerjaan',
            'pekerjaan' => null,
            'jurusan_terkait' => [],
            'semua_jurusan' => $jurusan
        ]);
    }

    public function edit($id)
    {
        $pekerjaan = $this->pekerjaanModel->find($id);
        if (!$pekerjaan) {
            $_SESSION['error'] = 'Data pekerjaan tidak ditemukan.';
            $this->redirect('adminPekerjaan');
            return;
        }

        $jurusan = $this->db->query("SELECT id_jurusan, nama_jurusan FROM jurusan ORDER BY nama_jurusan ASC")->fetchAll();
        
        // Ambil ID jurusan yang terkait untuk select box
        $relasi = $this->pekerjaanModel->getJurusanByPekerjaan($id);
        $jurusan_terkait = array_column($relasi, 'id_jurusan');

        $this->view('admin/pekerjaan/form', [
            'title' => 'Edit Pekerjaan - Admin',
            'pageTitle' => 'Edit Pekerjaan',
            'activeMenu' => 'pekerjaan',
            'pekerjaan' => $pekerjaan,
            'jurusan_terkait' => $jurusan_terkait,
            'semua_jurusan' => $jurusan
        ]);
    }

    public function simpan()
    {
        $this->onlyPost();
        if (!verify_csrf($_POST[CSRF_TOKEN_NAME] ?? '')) {
            die('Token tidak valid');
        }

        $id = $_POST['id_pekerjaan'] ?? '';
        $nama = clean($_POST['nama_pekerjaan'] ?? '');
        $deskripsi = clean($_POST['deskripsi'] ?? '');
        $tugas = clean($_POST['tugas_utama'] ?? '');
        $skill = clean($_POST['skill_dibutuhkan'] ?? '');
        $bidang = clean($_POST['bidang_industri'] ?? '');
        $instansi = clean($_POST['contoh_instansi'] ?? '');
        $jurusan_ids = $_POST['jurusan_ids'] ?? [];

        if (empty($nama)) {
            $_SESSION['error'] = 'Nama Pekerjaan wajib diisi.';
            $this->redirect('adminPekerjaan/tambah');
            return;
        }

        if (empty($id)) {
            // INSERT
            $this->pekerjaanModel->insert([
                'nama_pekerjaan' => $nama,
                'deskripsi' => $deskripsi,
                'tugas_utama' => $tugas,
                'skill_dibutuhkan' => $skill,
                'bidang_industri' => $bidang,
                'contoh_instansi' => $instansi
            ]);
            $newId = $this->db->lastInsertId();
            $this->pekerjaanModel->syncJurusan($newId, $jurusan_ids);
            
            log_activity('Master Pekerjaan', 'create', "Menambahkan Pekerjaan: $nama");
            $_SESSION['success'] = 'Data pekerjaan berhasil ditambahkan.';
        } else {
            // UPDATE
            $this->pekerjaanModel->update($id, [
                'nama_pekerjaan' => $nama,
                'deskripsi' => $deskripsi,
                'tugas_utama' => $tugas,
                'skill_dibutuhkan' => $skill,
                'bidang_industri' => $bidang,
                'contoh_instansi' => $instansi
            ]);
            $this->pekerjaanModel->syncJurusan($id, $jurusan_ids);
            
            log_activity('Master Pekerjaan', 'update', "Mengubah Pekerjaan ID $id");
            $_SESSION['success'] = 'Data pekerjaan berhasil diperbarui.';
        }

        $this->redirect('adminPekerjaan');
    }

    public function hapus($id)
    {
        $pekerjaan = $this->pekerjaanModel->find($id);
        if ($pekerjaan) {
            // Relasi di pekerjaan_jurusan otomatis terhapus karena ON DELETE CASCADE
            $this->pekerjaanModel->delete($id);
            log_activity('Master Pekerjaan', 'delete', "Menghapus Pekerjaan: {$pekerjaan['nama_pekerjaan']}");
            $_SESSION['success'] = 'Pekerjaan berhasil dihapus.';
        }
        $this->redirect('adminPekerjaan');
    }
}
