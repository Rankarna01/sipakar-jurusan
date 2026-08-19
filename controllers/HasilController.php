<?php
/**
 * HasilController
 * Menampilkan hasil konsultasi lengkap dengan visualisasi langkah
 * perhitungan Dempster-Shafer, ranking jurusan, dan opsi export.
 */
class HasilController extends Controller
{
    private $hasilModel;

    public function __construct()
    {
        $this->hasilModel = $this->model('Hasil');
    }

    public function detail($kode = '')
    {
        if (empty($kode)) {
            $this->redirect('/');
            return;
        }

        $hasil = $this->hasilModel->findByKode($kode);
        if (!$hasil) {
            http_response_code(404);
            echo 'Hasil konsultasi tidak ditemukan.';
            return;
        }

        $detailRanking = $this->hasilModel->getDetailHasil($hasil['id_hasil']);
        $langkahPerhitungan = $this->hasilModel->getLangkahPerhitungan($hasil['id_hasil']);
        $jawaban = $this->hasilModel->getJawaban($hasil['id_hasil']);

        // Kelompokkan langkah perhitungan per urutan evidence untuk tampilan step-by-step
        $langkahGrouped = [];
        foreach ($langkahPerhitungan as $l) {
            $langkahGrouped[$l['urutan_evidence']]['nama_evidence'] = $l['nama_evidence'];
            $langkahGrouped[$l['urutan_evidence']]['detail'][] = $l;
        }

        $jurusanModel = $this->model('Jurusan');
        $universitas = $hasil['id_jurusan_terbaik'] ? $jurusanModel->getUniversitas($hasil['id_jurusan_terbaik']) : [];

        // Jurusan-jurusan di dalam fakultas yang direkomendasikan (breakdown pilihan spesifik)
        $jurusanDalamFakultas = [];
        if (!empty($hasil['id_fakultas_terbaik'])) {
            $jurusanDalamFakultas = $this->hasilModel->getJurusanDalamFakultas($hasil['id_hasil'], $hasil['id_fakultas_terbaik']);
            if (empty($jurusanDalamFakultas)) {
                // Fallback: belum ada yang masuk top 5 individual, tampilkan daftar polos jurusan di fakultas ini
                $jurusanDalamFakultas = $jurusanModel->byFakultas($hasil['id_fakultas_terbaik']);
            }
        }

        $this->view('hasil/detail', [
            'title' => 'Hasil Konsultasi - ' . APP_NAME,
            'hasil' => $hasil,
            'detailRanking' => $detailRanking,
            'langkahGrouped' => $langkahGrouped,
            'jawaban' => $jawaban,
            'universitas' => $universitas,
            'jurusanDalamFakultas' => $jurusanDalamFakultas,
        ]);
    }

    /** Export hasil konsultasi ke PDF */
    public function pdf($kode = '')
    {
        $hasil = $this->hasilModel->findByKode($kode);
        if (!$hasil) {
            die('Hasil tidak ditemukan.');
        }
        $detailRanking = $this->hasilModel->getDetailHasil($hasil['id_hasil']);

        $jurusanModel = $this->model('Jurusan');
        $universitas = $hasil['id_jurusan_terbaik'] ? $jurusanModel->getUniversitas($hasil['id_jurusan_terbaik']) : [];

        $jurusanDalamFakultas = [];
        if (!empty($hasil['id_fakultas_terbaik'])) {
            $jurusanDalamFakultas = $this->hasilModel->getJurusanDalamFakultas($hasil['id_hasil'], $hasil['id_fakultas_terbaik']);
            if (empty($jurusanDalamFakultas)) {
                $jurusanDalamFakultas = $jurusanModel->byFakultas($hasil['id_fakultas_terbaik']);
            }
        }

        require_once ROOT_PATH . '/helpers/PdfExporter.php';
        $exporter = new PdfExporter();
        $exporter->exportHasilKonsultasi($hasil, $detailRanking, $jurusanDalamFakultas, $universitas);
    }
}
