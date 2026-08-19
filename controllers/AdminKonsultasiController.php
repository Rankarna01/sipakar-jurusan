<?php
/**
 * AdminKonsultasiController - Riwayat seluruh konsultasi siswa
 */
class AdminKonsultasiController extends Controller
{
    private $db;

    public function __construct()
    {
        if (!is_admin_login()) { $this->redirect('auth/adminLogin'); }
        $this->db = Database::getInstance();
    }

    public function index()
    {
        $data = $this->db->query(
            "SELECT h.*, COALESCE(s.nama, h.nama_tamu, 'Tamu') as nama_pengguna, j.nama_jurusan
             FROM hasil h
             LEFT JOIN siswa s ON s.id_siswa = h.id_siswa
             LEFT JOIN jurusan j ON j.id_jurusan = h.id_jurusan_terbaik
             WHERE h.status = 'selesai'
             ORDER BY h.created_at DESC"
        )->fetchAll();

        $this->view('admin/konsultasi/index', [
            'title' => 'Master Konsultasi - Admin', 'pageTitle' => 'Master Konsultasi',
            'activeMenu' => 'konsultasi', 'konsultasi' => $data,
        ]);
    }

    public function hapus($id)
    {
        $stmt = $this->db->prepare("DELETE FROM hasil WHERE id_hasil = :id");
        $stmt->execute(['id' => $id]);
        log_activity('Master Konsultasi', 'delete', "Menghapus data konsultasi #$id");
        $_SESSION['success'] = 'Data konsultasi berhasil dihapus.';
        $this->redirect('adminKonsultasi');
    }
}
