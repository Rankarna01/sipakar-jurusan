<?php
/**
 * AdminAdminController - Kelola akun admin (hanya superadmin yang boleh CRUD)
 */
class AdminAdminController extends Controller
{
    private $adminModel;

    public function __construct()
    {
        if (!is_admin_login()) { $this->redirect('auth/adminLogin'); }
        $this->adminModel = $this->model('Admin');
    }

    public function index()
    {
        $this->view('admin/admin/index', [
            'title' => 'Master Admin - Admin', 'pageTitle' => 'Master Admin',
            'activeMenu' => 'admin', 'admins' => $this->adminModel->all('created_at', 'DESC'),
        ]);
    }

    public function tambah()
    {
        $this->guardSuperadmin();
        $this->view('admin/admin/form', [
            'title' => 'Tambah Admin - Admin', 'pageTitle' => 'Tambah Admin',
            'activeMenu' => 'admin', 'adminData' => null,
        ]);
    }

    public function simpan()
    {
        $this->onlyPost();
        $this->guardSuperadmin();
        if (!verify_csrf($_POST[CSRF_TOKEN_NAME] ?? '')) { die('Token tidak valid'); }

        $nama = clean($_POST['nama']);
        $data = [
            'nama' => $nama,
            'username' => clean($_POST['username']),
            'email' => clean($_POST['email']),
            'password' => password_hash($_POST['password'], PASSWORD_BCRYPT),
            'role' => $_POST['role'] ?? 'admin',
        ];
        $this->adminModel->insert($data);
        log_activity('Master Admin', 'create', "Menambahkan admin: $nama");

        $_SESSION['success'] = 'Admin berhasil ditambahkan.';
        $this->redirect('adminAdmin');
    }

    public function edit($id)
    {
        $this->guardSuperadmin();
        $adminData = $this->adminModel->find($id);
        if (!$adminData) { $this->redirect('adminAdmin'); return; }
        $this->view('admin/admin/form', [
            'title' => 'Edit Admin - Admin', 'pageTitle' => 'Edit Admin',
            'activeMenu' => 'admin', 'adminData' => $adminData,
        ]);
    }

    public function update($id)
    {
        $this->onlyPost();
        $this->guardSuperadmin();
        if (!verify_csrf($_POST[CSRF_TOKEN_NAME] ?? '')) { die('Token tidak valid'); }

        $data = [
            'nama' => clean($_POST['nama']),
            'username' => clean($_POST['username']),
            'email' => clean($_POST['email']),
            'role' => $_POST['role'] ?? 'admin',
            'status' => $_POST['status'] ?? 'aktif',
        ];
        if (!empty($_POST['password'])) {
            $data['password'] = password_hash($_POST['password'], PASSWORD_BCRYPT);
        }
        $this->adminModel->update($id, $data);
        log_activity('Master Admin', 'update', "Mengubah admin #$id");

        $_SESSION['success'] = 'Admin berhasil diperbarui.';
        $this->redirect('adminAdmin');
    }

    public function hapus($id)
    {
        $this->guardSuperadmin();
        if ((int) $id === (int) $_SESSION['admin_id']) {
            $_SESSION['error'] = 'Anda tidak dapat menghapus akun Anda sendiri.';
            $this->redirect('adminAdmin');
            return;
        }
        $old = $this->adminModel->find($id);
        if ($old) {
            $this->adminModel->delete($id);
            log_activity('Master Admin', 'delete', "Menghapus admin: {$old['nama']}");
        }
        $_SESSION['success'] = 'Admin berhasil dihapus.';
        $this->redirect('adminAdmin');
    }

    private function guardSuperadmin(): void
    {
        if (($_SESSION['admin_role'] ?? '') !== 'superadmin') {
            $_SESSION['error'] = 'Hanya superadmin yang dapat mengelola akun admin.';
            $this->redirect('adminAdmin');
            exit;
        }
    }
}
