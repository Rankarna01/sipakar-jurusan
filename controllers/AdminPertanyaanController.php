<?php
/**
 * AdminPertanyaanController - CRUD Master Pertanyaan
 */
class AdminPertanyaanController extends Controller
{
    private $pertanyaanModel;
    private $evidenceModel;

    public function __construct()
    {
        if (!is_admin_login()) { $this->redirect('auth/adminLogin'); }
        $this->pertanyaanModel = $this->model('Pertanyaan');
        $this->evidenceModel = $this->model('Evidence');
    }

    public function index()
    {
        $db = Database::getInstance();
        $rekapFakultas = $db->query(
            "SELECT f.nama_fakultas,
                    MIN(p.urutan) + 1 as nomor_awal,
                    MAX(p.urutan) + 1 as nomor_akhir,
                    COUNT(*) as jumlah_soal
             FROM pertanyaan p
             JOIN evidence e ON e.id_evidence = p.id_evidence
             JOIN aturan a ON a.id_evidence = p.id_evidence
             JOIN jurusan j ON j.id_jurusan = a.id_jurusan
             JOIN fakultas f ON f.id_fakultas = j.id_fakultas
             GROUP BY f.id_fakultas
             ORDER BY nomor_awal ASC"
        )->fetchAll();

        // Gabungan: pertanyaan + basis pengetahuan (belief) dalam SATU tampilan,
        // karena setiap pertanyaan (evidence) hanya menunjuk ke SATU jurusan/fakultas
        // (desain single-target), sehingga tidak perlu 2 menu terpisah lagi.
        $pertanyaanLengkap = $db->query(
            "SELECT p.id_pertanyaan, p.kode_pertanyaan, p.pertanyaan, p.kategori, p.urutan, p.status,
                    a.id_aturan, a.nilai_belief,
                    j.nama_jurusan, f.nama_fakultas
             FROM pertanyaan p
             JOIN evidence e ON e.id_evidence = p.id_evidence
             LEFT JOIN aturan a ON a.id_evidence = p.id_evidence
             LEFT JOIN jurusan j ON j.id_jurusan = a.id_jurusan
             LEFT JOIN fakultas f ON f.id_fakultas = j.id_fakultas
             ORDER BY p.urutan ASC"
        )->fetchAll();

        $this->view('admin/pertanyaan/index', [
            'title' => 'Master Pertanyaan & Basis Pengetahuan - Admin', 'pageTitle' => 'Master Pertanyaan & Basis Pengetahuan',
            'activeMenu' => 'pertanyaan',
            'pertanyaanLengkap' => $pertanyaanLengkap,
            'rekapFakultas' => $rekapFakultas,
        ]);
    }

    /** Update nilai belief langsung dari tabel gabungan (AJAX inline-edit) */
    public function updateBelief($idAturan)
    {
        $this->onlyPost();
        if (!verify_csrf($_POST[CSRF_TOKEN_NAME] ?? '')) {
            $this->json(['success' => false, 'message' => 'Token tidak valid'], 403);
            return;
        }

        $belief = (float) ($_POST['nilai_belief'] ?? -1);
        if ($belief < 0 || $belief > 1) {
            $this->json(['success' => false, 'message' => 'Nilai belief harus antara 0 - 1'], 400);
            return;
        }

        $db = Database::getInstance();
        // Plausibility otomatis mengikuti formula tetap: belief + 0.08 (maks 1.0),
        // admin cukup fokus mengedit belief saja (sesuai permintaan: nilai disbelief tidak perlu ditampilkan).
        $plausibility = min(1.0, round($belief + 0.08, 3));

        $stmt = $db->prepare("UPDATE aturan SET nilai_belief = :belief, nilai_plausibility = :plaus WHERE id_aturan = :id");
        $ok = $stmt->execute(['belief' => round($belief, 3), 'plaus' => $plausibility, 'id' => (int) $idAturan]);

        if ($ok) {
            log_activity('Basis Pengetahuan', 'update', "Mengubah belief aturan #$idAturan menjadi $belief");
            $this->json(['success' => true, 'plausibility' => $plausibility]);
        } else {
            $this->json(['success' => false, 'message' => 'Gagal menyimpan'], 500);
        }
    }

    public function tambah()
    {
        $this->view('admin/pertanyaan/form', [
            'title' => 'Tambah Pertanyaan - Admin', 'pageTitle' => 'Tambah Pertanyaan',
            'activeMenu' => 'pertanyaan', 'pertanyaan' => null,
            'evidenceList' => $this->evidenceModel->allAktif(),
        ]);
    }

    public function simpan()
    {
        $this->onlyPost();
        if (!verify_csrf($_POST[CSRF_TOKEN_NAME] ?? '')) { die('Token tidak valid'); }

        $teks = clean($_POST['pertanyaan']);
        $data = [
            'id_evidence' => (int) $_POST['id_evidence'],
            'kode_pertanyaan' => clean($_POST['kode_pertanyaan']),
            'kategori' => $_POST['kategori'],
            'pertanyaan' => $teks,
            'urutan' => (int) ($_POST['urutan'] ?? 0),
        ];
        $this->pertanyaanModel->insert($data);
        log_activity('Master Pertanyaan', 'create', "Menambahkan pertanyaan: $teks", null, $data);

        $_SESSION['success'] = 'Pertanyaan berhasil ditambahkan.';
        $this->redirect('adminPertanyaan');
    }

    public function edit($id)
    {
        $pertanyaan = $this->pertanyaanModel->find($id);
        if (!$pertanyaan) { $this->redirect('adminPertanyaan'); return; }
        $this->view('admin/pertanyaan/form', [
            'title' => 'Edit Pertanyaan - Admin', 'pageTitle' => 'Edit Pertanyaan',
            'activeMenu' => 'pertanyaan', 'pertanyaan' => $pertanyaan,
            'evidenceList' => $this->evidenceModel->allAktif(),
        ]);
    }

    public function update($id)
    {
        $this->onlyPost();
        if (!verify_csrf($_POST[CSRF_TOKEN_NAME] ?? '')) { die('Token tidak valid'); }

        $old = $this->pertanyaanModel->find($id);
        $teks = clean($_POST['pertanyaan']);
        $data = [
            'id_evidence' => (int) $_POST['id_evidence'],
            'kode_pertanyaan' => clean($_POST['kode_pertanyaan']),
            'kategori' => $_POST['kategori'],
            'pertanyaan' => $teks,
            'urutan' => (int) ($_POST['urutan'] ?? 0),
            'status' => $_POST['status'] ?? 'aktif',
        ];
        $this->pertanyaanModel->update($id, $data);
        log_activity('Master Pertanyaan', 'update', "Mengubah pertanyaan: $teks", $old, $data);

        $_SESSION['success'] = 'Pertanyaan berhasil diperbarui.';
        $this->redirect('adminPertanyaan');
    }

    public function hapus($id)
    {
        $old = $this->pertanyaanModel->find($id);
        if ($old) {
            $this->pertanyaanModel->delete($id);
            log_activity('Master Pertanyaan', 'delete', "Menghapus pertanyaan: {$old['pertanyaan']}", $old, null);
        }
        $_SESSION['success'] = 'Pertanyaan berhasil dihapus.';
        $this->redirect('adminPertanyaan');
    }

    /** Toggle aktif/nonaktif cepat via AJAX */
    public function toggleStatus($id)
    {
        $p = $this->pertanyaanModel->find($id);
        if ($p) {
            $newStatus = $p['status'] === 'aktif' ? 'nonaktif' : 'aktif';
            $this->pertanyaanModel->update($id, ['status' => $newStatus]);
            $this->json(['success' => true, 'status' => $newStatus]);
            return;
        }
        $this->json(['success' => false], 404);
    }
}
