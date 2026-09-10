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

    public function importExcel()
    {
        $this->onlyPost();
        
        if (!isset($_FILES['file_excel']) || $_FILES['file_excel']['error'] !== UPLOAD_ERR_OK) {
            $_SESSION['error'] = 'Gagal mengupload file CSV.';
            $this->redirect('adminSiswa');
            return;
        }

        $fileTmpPath = $_FILES['file_excel']['tmp_name'];
        $fileName = $_FILES['file_excel']['name'];
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        if ($fileExtension !== 'csv') {
            $_SESSION['error'] = 'Format file harus CSV.';
            $this->redirect('adminSiswa');
            return;
        }

        $berhasil = 0;
        $gagal = 0;

        if (($handle = fopen($fileTmpPath, 'r')) !== false) {
            // Skip the header row
            fgetcsv($handle, 1000, ',');
            
            while (($row = fgetcsv($handle, 1000, ',')) !== false) {
                // Format Wajib (CSV): Nama, NIS, Tempat Lahir, Tanggal Lahir, Kelas, NPSN Sekolah.
                $nama = clean($row[0] ?? '');
                $nisn = clean($row[1] ?? '');
                $tempat_lahir = clean($row[2] ?? '');
                $tanggal_lahir = clean($row[3] ?? '');
                $kelas = clean($row[4] ?? '');
                $npsn = clean($row[5] ?? get_setting('npsn_sekolah', '10214151'));

                if (empty($nama) || empty($nisn)) {
                    $gagal++;
                    continue;
                }

                // Cek duplikat
                if ($this->siswaModel->findByNisn($nisn)) {
                    $gagal++;
                    continue;
                }

                // Buat email dummy unik karena email required unique di tabel
                $email = strtolower(str_replace(' ', '', $nisn)) . '@siswa.local';

                try {
                    $this->siswaModel->insert([
                        'nama' => $nama,
                        'nisn' => $nisn,
                        'kelas' => $kelas,
                        'email' => $email,
                        'password' => password_hash($npsn, PASSWORD_BCRYPT),
                        'status' => 'aktif'
                    ]);
                    $berhasil++;
                } catch (Exception $e) {
                    $gagal++;
                }
            }
            fclose($handle);
        } else {
            $_SESSION['error'] = 'Gagal membaca file CSV.';
            $this->redirect('adminSiswa');
            return;
        }

        log_activity('Master Pengguna', 'create', "Import CSV Siswa. Berhasil: $berhasil, Gagal: $gagal");
        
        $_SESSION['success'] = "Import selesai! Berhasil: $berhasil, Gagal (duplikat/error): $gagal";
        $this->redirect('adminSiswa');
    }
}
