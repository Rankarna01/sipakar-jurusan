<?php
/**
 * AuthController
 * Mengelola login/register siswa dan login admin, termasuk keamanan
 * (password hash, CSRF, rate limit sederhana via log_login).
 */
class AuthController extends Controller
{
    private $siswaModel;
    private $adminModel;

    public function __construct()
    {
        $this->siswaModel = $this->model('Siswa');
        $this->adminModel = $this->model('Admin');
    }

    /** Form login siswa */
    public function login()
    {
        if (is_siswa_login()) {
            $this->redirect('siswa/dashboard');
            return;
        }
        $this->view('auth/login', ['title' => 'Login Siswa - ' . APP_NAME]);
    }

    public function loginProses()
    {
        $this->onlyPost();
        if (!verify_csrf($_POST[CSRF_TOKEN_NAME] ?? '')) {
            $_SESSION['error'] = 'Token keamanan tidak valid.';
            $this->redirect('auth/login');
            return;
        }

        $nisn = clean($_POST['nisn'] ?? '');
        $password = $_POST['password'] ?? '';

        $siswa = $this->siswaModel->findByNisn($nisn);

        if (!$siswa || !password_verify($password, $siswa['password'])) {
            log_login('siswa', $siswa['id_siswa'] ?? null, $nisn, 'gagal', 'NIS atau password salah');
            $_SESSION['error'] = 'NIS atau password salah.';
            $this->redirect('auth/login');
            return;
        }

        if ($siswa['status'] !== 'aktif') {
            $_SESSION['error'] = 'Akun Anda tidak aktif. Hubungi administrator.';
            $this->redirect('auth/login');
            return;
        }

        session_regenerate_id(true);
        $_SESSION['siswa_id'] = $siswa['id_siswa'];
        $_SESSION['siswa_nama'] = $siswa['nama'];
        $_SESSION['siswa_kelas'] = $siswa['kelas'];

        $this->siswaModel->update($siswa['id_siswa'], ['last_login' => date('Y-m-d H:i:s')]);
        log_login('siswa', $siswa['id_siswa'], $nisn, 'berhasil');

        $redirect = $_SESSION['redirect_after_login'] ?? 'siswa/dashboard';
        unset($_SESSION['redirect_after_login']);
        $this->redirect($redirect);
    }

    /** Form registrasi siswa */
    public function register()
    {
        if (is_siswa_login()) {
            $this->redirect('siswa/dashboard');
            return;
        }
        $this->view('auth/register', ['title' => 'Daftar Akun Siswa - ' . APP_NAME]);
    }

    public function registerProses()
    {
        $this->onlyPost();
        if (!verify_csrf($_POST[CSRF_TOKEN_NAME] ?? '')) {
            $_SESSION['error'] = 'Token keamanan tidak valid.';
            $this->redirect('auth/register');
            return;
        }

        $nama = clean($_POST['nama'] ?? '');
        $nisn = clean($_POST['nisn'] ?? '');
        $kelas = clean($_POST['kelas'] ?? '');
        $email = clean($_POST['email'] ?? '');
        $noWa = clean($_POST['no_wa'] ?? '');
        $password = $_POST['password'] ?? '';
        $konfirmasi = $_POST['konfirmasi_password'] ?? '';

        $errors = [];
        if (strlen($nama) < 3) $errors[] = 'Nama minimal 3 karakter.';
        if (!preg_match('/^[0-9]{10}$/', $nisn)) $errors[] = 'NISN harus 10 digit angka.';
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Format email tidak valid.';
        if (strlen($password) < 6) $errors[] = 'Password minimal 6 karakter.';
        if ($password !== $konfirmasi) $errors[] = 'Konfirmasi password tidak cocok.';
        if ($this->siswaModel->findByEmail($email)) $errors[] = 'Email sudah terdaftar.';
        if ($this->siswaModel->findByNisn($nisn)) $errors[] = 'NISN sudah terdaftar.';

        if (!empty($errors)) {
            $_SESSION['error'] = implode(' ', $errors);
            $this->redirect('auth/register');
            return;
        }

        $idSiswa = $this->siswaModel->insert([
            'nama' => $nama,
            'nisn' => $nisn,
            'kelas' => $kelas,
            'email' => $email,
            'no_wa' => $noWa,
            'jenis_kelamin' => in_array($_POST['jenis_kelamin'] ?? '', ['L', 'P'], true) ? $_POST['jenis_kelamin'] : null,
            'password' => password_hash($password, PASSWORD_BCRYPT),
        ]);

        session_regenerate_id(true);
        $_SESSION['siswa_id'] = $idSiswa;
        $_SESSION['siswa_nama'] = $nama;
        $_SESSION['siswa_kelas'] = $kelas;

        // Kirim email selamat datang (best-effort, tidak menghalangi proses jika gagal)
        require_once ROOT_PATH . '/helpers/Mailer.php';
        (new Mailer())->kirimSelamatDatang($email, $nama);

        $this->redirect('siswa/dashboard');
    }

    public function logout()
    {
        unset($_SESSION['siswa_id'], $_SESSION['siswa_nama'], $_SESSION['siswa_kelas']);
        session_regenerate_id(true);
        $this->redirect('auth/login');
    }

    /** ===== ADMIN AUTH ===== */

    public function adminLogin()
    {
        if (is_admin_login()) {
            $this->redirect('admin/dashboard');
            return;
        }
        $this->view('auth/admin_login', ['title' => 'Login Admin - ' . APP_NAME]);
    }

    public function adminLoginProses()
    {
        $this->onlyPost();
        if (!verify_csrf($_POST[CSRF_TOKEN_NAME] ?? '')) {
            $_SESSION['error'] = 'Token keamanan tidak valid.';
            $this->redirect('auth/adminLogin');
            return;
        }

        $username = clean($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';

        $admin = $this->adminModel->findByUsername($username);

        if (!$admin || !password_verify($password, $admin['password'])) {
            log_login('admin', $admin['id_admin'] ?? null, $username, 'gagal', 'Username atau password salah');
            $_SESSION['error'] = 'Username atau password salah.';
            $this->redirect('auth/adminLogin');
            return;
        }

        if ($admin['status'] !== 'aktif') {
            $_SESSION['error'] = 'Akun admin tidak aktif.';
            $this->redirect('auth/adminLogin');
            return;
        }

        session_regenerate_id(true);
        $_SESSION['admin_id'] = $admin['id_admin'];
        $_SESSION['admin_nama'] = $admin['nama'];
        $_SESSION['admin_role'] = $admin['role'];

        $this->adminModel->update($admin['id_admin'], ['last_login' => date('Y-m-d H:i:s')]);
        log_login('admin', $admin['id_admin'], $username, 'berhasil');
        log_activity('Autentikasi', 'login', "Admin {$admin['nama']} login ke sistem");

        $this->redirect('admin/dashboard');
    }

    public function adminLogout()
    {
        if (is_admin_login()) {
            log_activity('Autentikasi', 'logout', "Admin {$_SESSION['admin_nama']} logout dari sistem");
        }
        unset($_SESSION['admin_id'], $_SESSION['admin_nama'], $_SESSION['admin_role']);
        session_regenerate_id(true);
        $this->redirect('auth/adminLogin');
    }
}
