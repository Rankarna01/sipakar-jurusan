<?php
/**
 * AdminEvidenceController - CRUD Master Evidence
 */
class AdminEvidenceController extends Controller
{
    private $evidenceModel;

    public function __construct()
    {
        if (!is_admin_login()) { $this->redirect('auth/adminLogin'); }
        $this->evidenceModel = $this->model('Evidence');
    }

    public function index()
    {
        $this->view('admin/evidence/index', [
            'title' => 'Master Evidence - Admin', 'pageTitle' => 'Master Evidence',
            'activeMenu' => 'evidence', 'evidence' => $this->evidenceModel->all('kategori'),
        ]);
    }

    public function tambah()
    {
        $this->view('admin/evidence/form', [
            'title' => 'Tambah Evidence - Admin', 'pageTitle' => 'Tambah Evidence',
            'activeMenu' => 'evidence', 'evidence' => null,
        ]);
    }

    public function simpan()
    {
        $this->onlyPost();
        if (!verify_csrf($_POST[CSRF_TOKEN_NAME] ?? '')) { die('Token tidak valid'); }

        $nama = clean($_POST['nama_evidence']);
        $data = [
            'kode_evidence' => clean($_POST['kode_evidence']),
            'nama_evidence' => $nama,
            'kategori' => $_POST['kategori'],
            'keterangan' => clean($_POST['keterangan'] ?? ''),
        ];
        $this->evidenceModel->insert($data);
        log_activity('Master Evidence', 'create', "Menambahkan evidence: $nama", null, $data);

        $_SESSION['success'] = 'Evidence berhasil ditambahkan.';
        $this->redirect('adminEvidence');
    }

    public function edit($id)
    {
        $evidence = $this->evidenceModel->find($id);
        if (!$evidence) { $this->redirect('adminEvidence'); return; }
        $this->view('admin/evidence/form', [
            'title' => 'Edit Evidence - Admin', 'pageTitle' => 'Edit Evidence',
            'activeMenu' => 'evidence', 'evidence' => $evidence,
        ]);
    }

    public function update($id)
    {
        $this->onlyPost();
        if (!verify_csrf($_POST[CSRF_TOKEN_NAME] ?? '')) { die('Token tidak valid'); }

        $old = $this->evidenceModel->find($id);
        $nama = clean($_POST['nama_evidence']);
        $data = [
            'kode_evidence' => clean($_POST['kode_evidence']),
            'nama_evidence' => $nama,
            'kategori' => $_POST['kategori'],
            'keterangan' => clean($_POST['keterangan'] ?? ''),
            'status' => $_POST['status'] ?? 'aktif',
        ];
        $this->evidenceModel->update($id, $data);
        log_activity('Master Evidence', 'update', "Mengubah evidence: $nama", $old, $data);

        $_SESSION['success'] = 'Evidence berhasil diperbarui.';
        $this->redirect('adminEvidence');
    }

    public function hapus($id)
    {
        $old = $this->evidenceModel->find($id);
        if ($old) {
            $this->evidenceModel->delete($id);
            log_activity('Master Evidence', 'delete', "Menghapus evidence: {$old['nama_evidence']}", $old, null);
        }
        $_SESSION['success'] = 'Evidence berhasil dihapus.';
        $this->redirect('adminEvidence');
    }
}
