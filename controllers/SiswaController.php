<?php
/**
 * SiswaController
 * Dashboard area siswa: riwayat konsultasi dan profil.
 */
class SiswaController extends Controller
{
    private $hasilModel;
    private $siswaModel;

    public function __construct()
    {
        if (!is_siswa_login()) {
            $this->redirect('auth/login');
        }
        $this->hasilModel = $this->model('Hasil');
        $this->siswaModel = $this->model('Siswa');
    }

    public function dashboard()
    {
        $riwayat = $this->hasilModel->riwayatBySiswa($_SESSION['siswa_id']);
        $siswa = $this->siswaModel->find($_SESSION['siswa_id']);

        $this->view('siswa/dashboard', [
            'title' => 'Dashboard Siswa - ' . APP_NAME,
            'siswa' => $siswa,
            'riwayat' => $riwayat,
        ]);
    }

    public function profil()
    {
        $siswa = $this->siswaModel->find($_SESSION['siswa_id']);
        $this->view('siswa/profil', [
            'title' => 'Profil Saya - ' . APP_NAME,
            'siswa' => $siswa,
        ]);
    }

    public function updateProfil()
    {
        $this->onlyPost();
        if (!verify_csrf($_POST[CSRF_TOKEN_NAME] ?? '')) {
            $_SESSION['error'] = 'Token keamanan tidak valid.';
            $this->redirect('siswa/profil');
            return;
        }

        $data = [
            'nama' => clean($_POST['nama']),
            'kelas' => clean($_POST['kelas']),
            'no_wa' => clean($_POST['no_wa'] ?? ''),
        ];

        if (!empty($_POST['password'])) {
            if (strlen($_POST['password']) < 6) {
                $_SESSION['error'] = 'Password minimal 6 karakter.';
                $this->redirect('siswa/profil');
                return;
            }
            $data['password'] = password_hash($_POST['password'], PASSWORD_BCRYPT);
        }

        if (!empty($_FILES['foto']['name'])) {
            $foto = upload_image($_FILES['foto'], 'siswa');
            if ($foto) $data['foto'] = $foto;
        }

        $this->siswaModel->update($_SESSION['siswa_id'], $data);
        $_SESSION['siswa_nama'] = $data['nama'];
        $_SESSION['siswa_kelas'] = $data['kelas'];

        $_SESSION['success'] = 'Profil berhasil diperbarui.';
        $this->redirect('siswa/profil');
    }
}
