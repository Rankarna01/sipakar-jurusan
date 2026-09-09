<?php
/**
 * KonsultasiController
 * Mengelola alur konsultasi siswa: menampilkan pertanyaan, memproses
 * jawaban dengan metode Dempster-Shafer, dan menyimpan hasil.
 */
class KonsultasiController extends Controller
{
    /** Jumlah minimal pertanyaan yang wajib dijawab sebelum konsultasi dapat diselesaikan */
    const MIN_JAWABAN = 10;

    private $pertanyaanModel;
    private $aturanModel;
    private $hasilModel;
    private $jurusanModel;

    public function __construct()
    {
        $this->pertanyaanModel = $this->model('Pertanyaan');
        $this->aturanModel = $this->model('Aturan');
        $this->hasilModel = $this->model('Hasil');
        $this->jurusanModel = $this->model('Jurusan');
    }

    /** Halaman mulai konsultasi (cek pengaturan wajib login) */
    public function index()
    {
        $wajibLogin = true; // Dipaksa wajib login

        if (!is_siswa_login()) {
            $_SESSION['redirect_after_login'] = 'konsultasi/mulai';
            $this->redirect('auth/login');
            return;
        }

        $this->view('konsultasi/intro', [
            'title' => 'Mulai Konsultasi - ' . APP_NAME,
            'wajibLogin' => $wajibLogin,
        ]);
    }

    /** Halaman soal pertanyaan (form panjang, dijawab bertahap dengan JS) */
    public function mulai()
    {
        $wajibLogin = true; // Dipaksa wajib login
        if (!is_siswa_login()) {
            $this->redirect('auth/login');
            return;
        }

        $pertanyaan = $this->pertanyaanModel->allForKonsultasi();

        if (empty($pertanyaan)) {
            die('Belum ada pertanyaan tersedia. Silakan hubungi administrator.');
        }

        $_SESSION['waktu_mulai_konsultasi'] = date('Y-m-d H:i:s');

        $this->view('konsultasi/form', [
            'title' => 'Konsultasi Jurusan - ' . APP_NAME,
            'pertanyaan' => $pertanyaan,
        ]);
    }

    /**
     * Proses jawaban konsultasi (dipanggil via AJAX POST)
     * Menjalankan seluruh perhitungan Dempster-Shafer dan menyimpan hasil.
     */
    public function proses()
    {
        $this->onlyPost();

        if (!verify_csrf($_POST[CSRF_TOKEN_NAME] ?? '')) {
            $this->json(['success' => false, 'message' => 'Token keamanan tidak valid. Silakan muat ulang halaman.'], 403);
            return;
        }

        $jawaban = $_POST['jawaban'] ?? []; // format: ['id_pertanyaan' => '1'-'5' (skala Likert), ...]
        $namaTamu = clean($_POST['nama_tamu'] ?? '');
        $kelasTamu = clean($_POST['kelas_tamu'] ?? '');
        $jenisKelamin = in_array($_POST['jenis_kelamin'] ?? '', ['L', 'P'], true) ? $_POST['jenis_kelamin'] : null;

        // Skala Likert 5-poin -> bobot pengali terhadap nilai belief dasar aturan.
        // 1 = Sangat Tidak Setuju (tidak dianggap sebagai evidence sama sekali)
        // 5 = Sangat Setuju (bobot penuh)
        $bobotLikert = [
            '1' => 0.0,   // Sangat Tidak Setuju
            '2' => 0.35,  // Kurang Setuju
            '3' => 0.6,   // Cukup Setuju
            '4' => 0.8,   // Setuju
            '5' => 1.0,   // Sangat Setuju
        ];

        // Hitung jumlah pertanyaan yang benar-benar terjawab (skala 1-5 apapun dipilih)
        $jumlahTerjawab = 0;
        foreach ($jawaban as $jwb) {
            if (isset($bobotLikert[(string) $jwb])) $jumlahTerjawab++;
        }

        if ($jumlahTerjawab < self::MIN_JAWABAN) {
            $this->json(['success' => false, 'message' => 'Minimal ' . self::MIN_JAWABAN . ' pertanyaan harus dijawab sebelum menyelesaikan konsultasi.'], 400);
            return;
        }

        // Ambil pertanyaan dengan skala >= 2 (Kurang Setuju ke atas) sebagai evidence yang mendukung,
        // dengan bobot proporsional sesuai tingkat kesetujuan siswa
        $pertanyaanList = $this->pertanyaanModel->allForKonsultasi();
        $pertanyaanMap = [];
        foreach ($pertanyaanList as $p) {
            $pertanyaanMap[$p['id_pertanyaan']] = $p;
        }

        $evidenceTerpilih = [];
        foreach ($jawaban as $idPertanyaan => $jwb) {
            $idPertanyaan = (int) $idPertanyaan;
            $jwbKey = (string) $jwb;
            if (!isset($pertanyaanMap[$idPertanyaan]) || !isset($bobotLikert[$jwbKey])) continue;
            $bobot = $bobotLikert[$jwbKey];
            if ($bobot <= 0) continue; // "Sangat Tidak Setuju" tidak dianggap evidence
            $p = $pertanyaanMap[$idPertanyaan];
            $evidenceTerpilih[] = [
                'id_pertanyaan' => $idPertanyaan,
                'id_evidence' => (int) $p['id_evidence'],
                'nama_evidence' => $p['nama_evidence'],
                'bobot' => $bobot,
                'skala_jawaban' => $jwbKey,
            ];
        }

        if (empty($evidenceTerpilih)) {
            $this->json(['success' => false, 'message' => 'Anda harus menjawab minimal "Kurang Setuju" ke atas pada 1 pertanyaan agar sistem dapat memberi rekomendasi.'], 400);
            return;
        }

        // Kelompokkan evidence unik (siswa mungkin menjawab pada beberapa pertanyaan dengan evidence sama).
        // Jika ada duplikat, ambil bobot TERTINGGI di antara jawaban yang menyentuh evidence yang sama.
        $evidenceUnik = [];
        foreach ($evidenceTerpilih as $e) {
            if (!isset($evidenceUnik[$e['id_evidence']]) || $e['bobot'] > $evidenceUnik[$e['id_evidence']]['bobot']) {
                $evidenceUnik[$e['id_evidence']] = $e;
            }
        }

        // ==== JALANKAN ENGINE DEMPSTER-SHAFER ====
        $ds = new DempsterShafer();
        $urutan = 1;
        foreach ($evidenceUnik as $idEvidence => $evInfo) {
            $rules = $this->aturanModel->byEvidence($idEvidence);
            if (empty($rules)) continue;

            // Nilai belief dasar dari aturan DISKALAKAN dengan bobot tingkat kesetujuan siswa
            // (Likert), sehingga jawaban "Sangat Setuju" memberi evidence penuh, sementara
            // "Cukup Setuju" hanya memberi evidence sebagian -- lebih presisi dibanding Ya/Tidak biner.
            $ruleJurusan = array_map(fn($r) => [
                'id_jurusan' => (int) $r['id_jurusan'],
                'nama_jurusan' => $r['nama_jurusan'],
                'belief' => (float) $r['nilai_belief'] * $evInfo['bobot'],
            ], $rules);

            $ds->tambahEvidence($urutan, [
                'id_evidence' => $idEvidence,
                'nama_evidence' => $evInfo['nama_evidence'],
            ], $ruleJurusan);

            $urutan++;
        }

        $hasilAkhir = $ds->getHasilAkhir();

        if (empty($hasilAkhir)) {
            $this->json(['success' => false, 'message' => 'Tidak ditemukan jurusan yang cocok berdasarkan jawaban Anda. Coba jawab lebih banyak pertanyaan.'], 400);
            return;
        }

        $topRanking = array_slice($hasilAkhir, 0, DS_TOP_RANKING);
        $jurusanTerbaik = $topRanking[0];

        // ==== AGREGASI KE LEVEL FAKULTAS ====
        // Untuk mengurangi ambiguitas ranking antar jurusan yang serumpun
        // (misal Teknik Informatika vs Sistem Informasi vs Ilmu Komputer yang
        // sama-sama di bawah Fakultas Ilmu Komputer), belief SELURUH jurusan
        // (bukan cuma top 5) dijumlahkan per fakultas induknya. Fakultas dengan
        // agregat tertinggi menjadi REKOMENDASI UTAMA, dengan jurusan-jurusan
        // di dalamnya ditampilkan sebagai pilihan spesifik.
        $jurusanFakultasMap = [];
        foreach ($this->jurusanModel->all() as $j) {
            $jurusanFakultasMap[$j['id_jurusan']] = $j['id_fakultas'];
        }
        $agregatFakultas = [];
        foreach ($hasilAkhir as $h) {
            $idFak = $jurusanFakultasMap[$h['id_jurusan']] ?? null;
            if ($idFak === null) continue;
            $agregatFakultas[$idFak] = ($agregatFakultas[$idFak] ?? 0) + $h['belief'];
        }
        arsort($agregatFakultas);
        $idFakultasTerbaik = array_key_first($agregatFakultas);
        $totalAgregat = array_sum($agregatFakultas) ?: 1;
        $persentaseFakultasTerbaik = round(($agregatFakultas[$idFakultasTerbaik] / $totalAgregat) * 100, 2);

        // ==== SIMPAN HASIL KE DATABASE ====
        $waktuMulai = $_SESSION['waktu_mulai_konsultasi'] ?? date('Y-m-d H:i:s');
        $waktuSelesai = date('Y-m-d H:i:s');
        $durasi = strtotime($waktuSelesai) - strtotime($waktuMulai);

        // Tentukan jenis kelamin final: ambil dari data siswa jika login, atau dari input tamu
        if (is_siswa_login()) {
            $siswaModelGender = $this->model('Siswa');
            $siswaGenderData = $siswaModelGender->find($_SESSION['siswa_id']);
            $jenisKelaminFinal = $siswaGenderData['jenis_kelamin'] ?? null;
        } else {
            $jenisKelaminFinal = $jenisKelamin;
        }

        $idHasil = $this->hasilModel->insert([
            'kode_konsultasi' => generate_code('KONS'),
            'id_siswa' => is_siswa_login() ? $_SESSION['siswa_id'] : null,
            'nama_tamu' => is_siswa_login() ? null : $namaTamu,
            'kelas_tamu' => is_siswa_login() ? null : $kelasTamu,
            'id_fakultas_terbaik' => $idFakultasTerbaik,
            'persentase_fakultas_terbaik' => $persentaseFakultasTerbaik,
            'jenis_kelamin' => $jenisKelaminFinal,
            'id_jurusan_terbaik' => $jurusanTerbaik['id_jurusan'],
            'nilai_belief_akhir' => $jurusanTerbaik['belief'],
            'persentase_akhir' => $jurusanTerbaik['persentase'],
            'jumlah_evidence_dipilih' => count($evidenceUnik),
            'waktu_mulai' => $waktuMulai,
            'waktu_selesai' => $waktuSelesai,
            'durasi_detik' => max($durasi, 0),
            'ip_address' => $_SERVER['REMOTE_ADDR'] ?? null,
            'status' => 'selesai',
        ]);

        $this->hasilModel->simpanDetailHasil((int) $idHasil, $topRanking);
        $this->hasilModel->simpanLangkah((int) $idHasil, $ds->getSteps());

        foreach ($evidenceTerpilih as $e) {
            $this->hasilModel->simpanJawaban((int) $idHasil, $e['id_pertanyaan'], $e['id_evidence'], 'ya');
        }

        unset($_SESSION['waktu_mulai_konsultasi']);

        // ==== KIRIM EMAIL HASIL KONSULTASI (best-effort, tidak menghalangi response) ====
        $emailTujuan = null;
        $namaTujuan = null;
        if (is_siswa_login()) {
            $siswaModel = $this->model('Siswa');
            $siswaData = $siswaModel->find($_SESSION['siswa_id']);
            if ($siswaData) {
                $emailTujuan = $siswaData['email'];
                $namaTujuan = $siswaData['nama'];
            }
        } elseif (!empty($_POST['email_tamu']) && filter_var($_POST['email_tamu'], FILTER_VALIDATE_EMAIL)) {
            $emailTujuan = clean($_POST['email_tamu']);
            $namaTujuan = $namaTamu ?: 'Tamu';
        }

        if ($emailTujuan) {
            require_once ROOT_PATH . '/helpers/Mailer.php';
            $hasilTersimpan = $this->hasilModel->find($idHasil);
            $jurusanModel = $this->model('Jurusan');
            $jurusanTerbaikData = $jurusanModel->find($jurusanTerbaik['id_jurusan']);
            (new Mailer())->kirimHasilKonsultasi($emailTujuan, $namaTujuan, $hasilTersimpan, [
                'nama_jurusan' => $jurusanTerbaikData['nama_jurusan'] ?? '-',
                'persentase' => $jurusanTerbaik['persentase'],
            ]);
        }

        $kodeKonsultasi = $this->hasilModel->find($idHasil)['kode_konsultasi'];

        $this->json([
            'success' => true,
            'message' => 'Konsultasi berhasil diproses.',
            'redirect' => BASE_URL . 'hasil/detail/' . $kodeKonsultasi,
        ]);
    }
}
