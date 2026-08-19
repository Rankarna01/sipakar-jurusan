<?php
/**
 * AdminController
 * Dashboard utama admin dengan statistik ringkas dan grafik tren konsultasi.
 * Middleware otentikasi dicek di views/layout/admin_header.php (guard sederhana).
 */
class AdminController extends Controller
{
    public function __construct()
    {
        if (!is_admin_login()) {
            $this->redirect('auth/adminLogin');
        }
    }

    public function dashboard()
    {
        $db = Database::getInstance();

        $totalSiswa = $db->query("SELECT COUNT(*) c FROM siswa")->fetch()['c'];
        $totalJurusan = $db->query("SELECT COUNT(*) c FROM jurusan WHERE status='aktif'")->fetch()['c'];
        $totalFakultas = $db->query("SELECT COUNT(*) c FROM fakultas WHERE status='aktif'")->fetch()['c'];
        $totalKonsultasi = $db->query("SELECT COUNT(*) c FROM hasil WHERE status='selesai'")->fetch()['c'];

        // Tren konsultasi 7 hari terakhir
        $trendStmt = $db->query(
            "SELECT DATE(created_at) as tgl, COUNT(*) as jumlah
             FROM hasil WHERE status='selesai' AND created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)
             GROUP BY DATE(created_at) ORDER BY tgl ASC"
        );
        $trend = $trendStmt->fetchAll();

        // Jurusan terpopuler
        $hasilModel = $this->model('Hasil');
        $jurusanPopuler = $hasilModel->statistikJurusanTerpopuler(5);

        // Konsultasi terbaru
        $konsultasiTerbaru = $db->query(
            "SELECT h.kode_konsultasi, h.created_at, h.persentase_akhir,
                    COALESCE(s.nama, h.nama_tamu, 'Tamu') as nama_pengguna, j.nama_jurusan
             FROM hasil h
             LEFT JOIN siswa s ON s.id_siswa = h.id_siswa
             LEFT JOIN jurusan j ON j.id_jurusan = h.id_jurusan_terbaik
             WHERE h.status = 'selesai'
             ORDER BY h.created_at DESC LIMIT 8"
        )->fetchAll();

        $this->view('admin/dashboard', [
            'title' => 'Dashboard Admin - ' . APP_NAME,
            'pageTitle' => 'Dashboard',
            'activeMenu' => 'dashboard',
            'totalSiswa' => $totalSiswa,
            'totalJurusan' => $totalJurusan,
            'totalFakultas' => $totalFakultas,
            'totalKonsultasi' => $totalKonsultasi,
            'trend' => $trend,
            'jurusanPopuler' => $jurusanPopuler,
            'konsultasiTerbaru' => $konsultasiTerbaru,
        ]);
    }
}
