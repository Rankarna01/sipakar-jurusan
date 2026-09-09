<?php
/**
 * AdminSiswaController - Kelola akun siswa
 */
class AdminSiswaController extends Controller
{
    private $siswaModel;

    public function __construct()
    {
        if (!is_admin_login()) { $this->redirect('auth/adminLogin'); }
        $this->siswaModel = $this->model('Siswa');
    }

    public function index()
    {
        $this->view('admin/siswa/index', [
            'title' => 'Master Pengguna - Admin', 'pageTitle' => 'Master Pengguna (Siswa)',
            'activeMenu' => 'siswa', 'siswa' => $this->siswaModel->all('created_at', 'DESC'),
        ]);
    }

    public function toggleStatus($id)
    {
        $s = $this->siswaModel->find($id);
        if ($s) {
            $newStatus = $s['status'] === 'aktif' ? 'nonaktif' : 'aktif';
            $this->siswaModel->update($id, ['status' => $newStatus]);
            log_activity('Master Pengguna', 'update', "Mengubah status siswa {$s['nama']} menjadi $newStatus");
        }
        $_SESSION['success'] = 'Status siswa berhasil diperbarui.';
        $this->redirect('adminSiswa');
    }

    public function hapus($id)
    {
        $old = $this->siswaModel->find($id);
        if ($old) {
            $this->siswaModel->delete($id);
            log_activity('Master Pengguna', 'delete', "Menghapus siswa: {$old['nama']}", $old, null);
        }
        $_SESSION['success'] = 'Siswa berhasil dihapus.';
        $this->redirect('adminSiswa');
    }

    public function resetPassword($id)
    {
        $newPassword = get_setting('npsn_sekolah', '10214151'); // Default NPSN SMA Muhammadiyah 18
        $this->siswaModel->update($id, ['password' => password_hash($newPassword, PASSWORD_BCRYPT)]);
        log_activity('Master Pengguna', 'update', "Reset password siswa #$id ke NPSN");
        $_SESSION['success'] = "Password berhasil direset menjadi NPSN ($newPassword)";
        $this->redirect('adminSiswa');
    }
}
