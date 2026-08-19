<?php
/**
 * AdminAturanController - CRUD Basis Pengetahuan (Aturan)
 * Mengelola relasi many-to-many evidence <-> jurusan beserta nilai
 * belief & plausibility yang menjadi input utama Metode Dempster-Shafer.
 */
class AdminAturanController extends Controller
{
    private $aturanModel;
    private $evidenceModel;
    private $jurusanModel;

    public function __construct()
    {
        if (!is_admin_login()) { $this->redirect('auth/adminLogin'); }
        $this->aturanModel = $this->model('Aturan');
        $this->evidenceModel = $this->model('Evidence');
        $this->jurusanModel = $this->model('Jurusan');
    }

    public function index()
    {
        $this->view('admin/aturan/index', [
            'title' => 'Basis Pengetahuan - Admin', 'pageTitle' => 'Basis Pengetahuan (Aturan)',
            'activeMenu' => 'aturan', 'aturan' => $this->aturanModel->allWithRelasi(),
        ]);
    }

    /** Lihat & kelola seluruh aturan untuk 1 jurusan spesifik (lebih praktis bagi admin) */
    public function jurusan($idJurusan)
    {
        $jurusan = $this->jurusanModel->find($idJurusan);
        if (!$jurusan) { $this->redirect('adminJurusan'); return; }

        $aturanJurusan = $this->aturanModel->byJurusan($idJurusan);
        $idEvidenceTerpakai = array_column($aturanJurusan, 'id_evidence');

        $evidenceBelumDipakai = array_filter($this->evidenceModel->allAktif(), fn($e) => !in_array($e['id_evidence'], $idEvidenceTerpakai));

        $this->view('admin/aturan/jurusan', [
            'title' => 'Aturan Jurusan: ' . $jurusan['nama_jurusan'], 'pageTitle' => 'Basis Pengetahuan Jurusan',
            'activeMenu' => 'aturan', 'jurusan' => $jurusan,
            'aturanJurusan' => $aturanJurusan,
            'evidenceBelumDipakai' => array_values($evidenceBelumDipakai),
        ]);
    }

    public function tambah($idJurusan)
    {
        $this->onlyPost();
        if (!verify_csrf($_POST[CSRF_TOKEN_NAME] ?? '')) { die('Token tidak valid'); }

        $idEvidence = (int) $_POST['id_evidence'];
        $belief = (float) $_POST['nilai_belief'];
        $plausibility = (float) ($_POST['nilai_plausibility'] ?? 1.0);

        if ($belief < 0 || $belief > 1) {
            $_SESSION['error'] = 'Nilai belief harus di antara 0 dan 1.';
            $this->redirect('adminAturan/jurusan/' . $idJurusan);
            return;
        }

        if ($this->aturanModel->existsRule($idEvidence, $idJurusan)) {
            $_SESSION['error'] = 'Aturan untuk evidence dan jurusan ini sudah ada.';
            $this->redirect('adminAturan/jurusan/' . $idJurusan);
            return;
        }

        $data = [
            'id_evidence' => $idEvidence,
            'id_jurusan' => (int) $idJurusan,
            'nilai_belief' => $belief,
            'nilai_plausibility' => $plausibility,
            'keterangan' => clean($_POST['keterangan'] ?? ''),
        ];
        $this->aturanModel->insert($data);
        log_activity('Basis Pengetahuan', 'create', "Menambahkan aturan evidence #$idEvidence untuk jurusan #$idJurusan", null, $data);

        $_SESSION['success'] = 'Aturan berhasil ditambahkan.';
        $this->redirect('adminAturan/jurusan/' . $idJurusan);
    }

    public function updateNilai($idAturan)
    {
        $this->onlyPost();
        if (!verify_csrf($_POST[CSRF_TOKEN_NAME] ?? '')) {
            $this->json(['success' => false, 'message' => 'Token tidak valid'], 403);
            return;
        }

        $belief = (float) $_POST['nilai_belief'];
        $plausibility = (float) ($_POST['nilai_plausibility'] ?? 1.0);

        if ($belief < 0 || $belief > 1 || $plausibility < 0 || $plausibility > 1) {
            $this->json(['success' => false, 'message' => 'Nilai harus antara 0 - 1'], 400);
            return;
        }

        // Validasi konsistensi: Plausibility TIDAK BOLEH lebih kecil dari Belief
        // (sesuai teori Dempster-Shafer, Plausibility adalah batas atas kepercayaan)
        if ($plausibility < $belief) {
            $this->json(['success' => false, 'message' => "Plausibility ({$plausibility}) tidak boleh lebih kecil dari Belief ({$belief}). Plausibility harus >= Belief."], 400);
            return;
        }

        $old = $this->aturanModel->find($idAturan);
        $this->aturanModel->update($idAturan, [
            'nilai_belief' => $belief,
            'nilai_plausibility' => $plausibility,
        ]);
        log_activity('Basis Pengetahuan', 'update', "Mengubah nilai aturan #$idAturan", $old, ['belief' => $belief, 'plausibility' => $plausibility]);

        $this->json(['success' => true, 'message' => 'Nilai berhasil diperbarui']);
    }

    public function hapus($idAturan)
    {
        $old = $this->aturanModel->find($idAturan);
        $idJurusan = $old['id_jurusan'] ?? null;
        if ($old) {
            $this->aturanModel->delete($idAturan);
            log_activity('Basis Pengetahuan', 'delete', "Menghapus aturan #$idAturan", $old, null);
        }
        $_SESSION['success'] = 'Aturan berhasil dihapus.';
        $this->redirect($idJurusan ? 'adminAturan/jurusan/' . $idJurusan : 'adminAturan');
    }
}
