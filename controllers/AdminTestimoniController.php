<?php
/**
 * AdminTestimoniController - Moderasi testimoni siswa
 */
class AdminTestimoniController extends Controller
{
    private $db;

    public function __construct()
    {
        if (!is_admin_login()) { $this->redirect('auth/adminLogin'); }
        $this->db = Database::getInstance();
    }

    public function index()
    {
        $testimoni = $this->db->query("SELECT * FROM testimoni ORDER BY created_at DESC")->fetchAll();
        $this->view('admin/testimoni/index', [
            'title' => 'Testimoni - Admin', 'pageTitle' => 'Moderasi Testimoni',
            'activeMenu' => 'testimoni', 'testimoni' => $testimoni,
        ]);
    }

    public function ubahStatus($id, $status)
    {
        if (!in_array($status, ['tampil', 'sembunyi', 'pending'])) { $status = 'pending'; }
        $stmt = $this->db->prepare("UPDATE testimoni SET status = :s WHERE id_testimoni = :id");
        $stmt->execute(['s' => $status, 'id' => $id]);
        log_activity('Testimoni', 'update', "Mengubah status testimoni #$id menjadi $status");
        $_SESSION['success'] = 'Status testimoni berhasil diperbarui.';
        $this->redirect('adminTestimoni');
    }

    public function hapus($id)
    {
        $stmt = $this->db->prepare("DELETE FROM testimoni WHERE id_testimoni = :id");
        $stmt->execute(['id' => $id]);
        log_activity('Testimoni', 'delete', "Menghapus testimoni #$id");
        $_SESSION['success'] = 'Testimoni berhasil dihapus.';
        $this->redirect('adminTestimoni');
    }
}
