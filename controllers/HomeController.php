<?php
/**
 * HomeController
 */
class HomeController extends Controller
{
    public function index()
    {
        $fakultasModel = $this->model('Fakultas');
        $jurusanModel = $this->model('Jurusan');
        $hasilModel = $this->model('Hasil');

        $db = Database::getInstance();

        $fakultas = $fakultasModel->allWithJumlahJurusan();
        $totalJurusan = $jurusanModel->count("status = 'aktif'");
        $totalKonsultasi = $hasilModel->count("status = 'selesai'");
        $totalFakultas = count($fakultas);

        $slider = $db->query("SELECT * FROM slider WHERE status='aktif' ORDER BY urutan ASC")->fetchAll();
        $testimoni = $db->query("SELECT * FROM testimoni WHERE status='tampil' ORDER BY created_at DESC LIMIT 6")->fetchAll();
        $artikel = $db->query("SELECT * FROM artikel WHERE status='publish' ORDER BY published_at DESC LIMIT 3")->fetchAll();

        $this->view('home/index', [
            'title' => APP_NAME,
            'fakultas' => $fakultas,
            'totalJurusan' => $totalJurusan,
            'totalKonsultasi' => $totalKonsultasi,
            'totalFakultas' => $totalFakultas,
            'slider' => $slider,
            'testimoni' => $testimoni,
            'artikel' => $artikel,
        ]);
    }

    public function tentang()
    {
        $this->view('home/tentang', ['title' => 'Tentang Sistem - ' . APP_NAME]);
    }

    public function faq()
    {
        $this->view('home/faq', ['title' => 'FAQ - ' . APP_NAME]);
    }

    public function kontak()
    {
        $pengembangModel = $this->model('Pengembang');
        try {
            $daftarPengembang = $pengembangModel->allAktif();
        } catch (\Throwable $e) {
            // Tabel 'pengembang' mungkin belum ada jika database belum di-import ulang
            // dengan skema terbaru. Jangan crash, tampilkan halaman tanpa data pengembang.
            error_log('Kontak: tabel pengembang bermasalah - ' . $e->getMessage());
            $daftarPengembang = [];
        }
        $this->view('home/kontak', [
            'title' => 'Kontak - ' . APP_NAME,
            'daftarPengembang' => $daftarPengembang,
        ]);
    }
}
