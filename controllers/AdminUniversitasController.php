<?php
/**
 * AdminUniversitasController - CRUD Master Universitas + relasi jurusan
 */
class AdminUniversitasController extends Controller
{
    private $db;

    public function __construct()
    {
        if (!is_admin_login()) { $this->redirect('auth/adminLogin'); }
        $this->db = Database::getInstance();
    }

    public function index()
    {
        $universitas = $this->db->query("SELECT * FROM universitas ORDER BY nama_universitas ASC")->fetchAll();
        $this->view('admin/universitas/index', [
            'title' => 'Master Universitas - Admin', 'pageTitle' => 'Master Universitas',
            'activeMenu' => 'universitas', 'universitas' => $universitas,
        ]);
    }

    public function tambah()
    {
        $jurusan = $this->db->query("SELECT * FROM jurusan WHERE status='aktif' ORDER BY nama_jurusan ASC")->fetchAll();
        $this->view('admin/universitas/form', [
            'title' => 'Tambah Universitas - Admin', 'pageTitle' => 'Tambah Universitas',
            'activeMenu' => 'universitas', 'universitas' => null, 'jurusanList' => $jurusan, 'jurusanTerpilih' => [],
        ]);
    }

    public function simpan()
    {
        $this->onlyPost();
        if (!verify_csrf($_POST[CSRF_TOKEN_NAME] ?? '')) { die('Token tidak valid'); }

        $logo = null;
        if (!empty($_FILES['logo']['name'])) {
            $logo = upload_image($_FILES['logo'], 'universitas');
        }

        $stmt = $this->db->prepare(
            "INSERT INTO universitas (nama_universitas, singkatan, kota, provinsi, jenis, website, logo, akreditasi_institusi, tahun_berdiri, jumlah_mahasiswa) VALUES (:n,:s,:k,:p,:j,:w,:logo,:ak,:th,:jm)"
        );
        $stmt->execute([
            'n' => clean($_POST['nama_universitas']), 's' => clean($_POST['singkatan'] ?? ''),
            'k' => clean($_POST['kota'] ?? ''), 'p' => clean($_POST['provinsi'] ?? ''),
            'j' => $_POST['jenis'] ?? 'negeri', 'w' => clean($_POST['website'] ?? ''),
            'logo' => $logo, 'ak' => clean($_POST['akreditasi_institusi'] ?? ''),
            'th' => !empty($_POST['tahun_berdiri']) ? (int) $_POST['tahun_berdiri'] : null,
            'jm' => clean($_POST['jumlah_mahasiswa'] ?? ''),
        ]);
        $idUniv = $this->db->lastInsertId();

        $this->simpanRelasiJurusan($idUniv, $_POST['jurusan'] ?? [], $_POST['akreditasi'] ?? []);

        log_activity('Master Universitas', 'create', "Menambahkan universitas: " . clean($_POST['nama_universitas']));
        $_SESSION['success'] = 'Universitas berhasil ditambahkan.';
        $this->redirect('adminUniversitas');
    }

    public function edit($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM universitas WHERE id_universitas = :id");
        $stmt->execute(['id' => $id]);
        $universitas = $stmt->fetch();
        if (!$universitas) { $this->redirect('adminUniversitas'); return; }

        $jurusan = $this->db->query("SELECT * FROM jurusan WHERE status='aktif' ORDER BY nama_jurusan ASC")->fetchAll();
        $stmtRel = $this->db->prepare("SELECT id_jurusan FROM jurusan_universitas WHERE id_universitas = :id");
        $stmtRel->execute(['id' => $id]);
        $jurusanTerpilih = array_column($stmtRel->fetchAll(), 'id_jurusan');

        $this->view('admin/universitas/form', [
            'title' => 'Edit Universitas - Admin', 'pageTitle' => 'Edit Universitas',
            'activeMenu' => 'universitas', 'universitas' => $universitas,
            'jurusanList' => $jurusan, 'jurusanTerpilih' => $jurusanTerpilih,
        ]);
    }

    public function update($id)
    {
        $this->onlyPost();
        if (!verify_csrf($_POST[CSRF_TOKEN_NAME] ?? '')) { die('Token tidak valid'); }

        $params = [
            'n' => clean($_POST['nama_universitas']), 's' => clean($_POST['singkatan'] ?? ''),
            'k' => clean($_POST['kota'] ?? ''), 'p' => clean($_POST['provinsi'] ?? ''),
            'j' => $_POST['jenis'] ?? 'negeri', 'w' => clean($_POST['website'] ?? ''),
            'ak' => clean($_POST['akreditasi_institusi'] ?? ''),
            'th' => !empty($_POST['tahun_berdiri']) ? (int) $_POST['tahun_berdiri'] : null,
            'jm' => clean($_POST['jumlah_mahasiswa'] ?? ''),
            'st' => $_POST['status'] ?? 'aktif', 'id' => $id,
        ];

        $logoSql = '';
        if (!empty($_FILES['logo']['name'])) {
            $logo = upload_image($_FILES['logo'], 'universitas');
            if ($logo) {
                $logoSql = ', logo=:logo';
                $params['logo'] = $logo;
            }
        }

        $stmt = $this->db->prepare(
            "UPDATE universitas SET nama_universitas=:n, singkatan=:s, kota=:k, provinsi=:p, jenis=:j, website=:w,
             akreditasi_institusi=:ak, tahun_berdiri=:th, jumlah_mahasiswa=:jm, status=:st{$logoSql} WHERE id_universitas=:id"
        );
        $stmt->execute($params);

        $del = $this->db->prepare("DELETE FROM jurusan_universitas WHERE id_universitas = :id");
        $del->execute(['id' => $id]);
        $this->simpanRelasiJurusan($id, $_POST['jurusan'] ?? [], $_POST['akreditasi'] ?? []);

        log_activity('Master Universitas', 'update', "Mengubah universitas #$id");
        $_SESSION['success'] = 'Universitas berhasil diperbarui.';
        $this->redirect('adminUniversitas');
    }

    public function hapus($id)
    {
        $stmt = $this->db->prepare("DELETE FROM universitas WHERE id_universitas = :id");
        $stmt->execute(['id' => $id]);
        log_activity('Master Universitas', 'delete', "Menghapus universitas #$id");
        $_SESSION['success'] = 'Universitas berhasil dihapus.';
        $this->redirect('adminUniversitas');
    }

    private function simpanRelasiJurusan($idUniv, array $jurusanIds, array $akreditasiList): void
    {
        foreach ($jurusanIds as $i => $idJurusan) {
            $stmt = $this->db->prepare(
                "INSERT INTO jurusan_universitas (id_jurusan, id_universitas, akreditasi, jalur_masuk) VALUES (:j,:u,:a,'SNBP/SNBT')"
            );
            $stmt->execute(['j' => (int) $idJurusan, 'u' => $idUniv, 'a' => clean($akreditasiList[$i] ?? '')]);
        }
    }
}
