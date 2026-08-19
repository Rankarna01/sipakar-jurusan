<?php
/**
 * AdminArtikelController - CRUD Artikel/Berita
 */
class AdminArtikelController extends Controller
{
    private $db;

    public function __construct()
    {
        if (!is_admin_login()) { $this->redirect('auth/adminLogin'); }
        $this->db = Database::getInstance();
    }

    public function index()
    {
        $artikel = $this->db->query("SELECT * FROM artikel ORDER BY created_at DESC")->fetchAll();
        $this->view('admin/artikel/index', [
            'title' => 'Artikel - Admin', 'pageTitle' => 'Master Artikel',
            'activeMenu' => 'artikel', 'artikel' => $artikel,
        ]);
    }

    public function tambah()
    {
        $this->view('admin/artikel/form', [
            'title' => 'Tambah Artikel - Admin', 'pageTitle' => 'Tambah Artikel',
            'activeMenu' => 'artikel', 'artikel' => null,
        ]);
    }

    public function simpan()
    {
        $this->onlyPost();
        if (!verify_csrf($_POST[CSRF_TOKEN_NAME] ?? '')) { die('Token tidak valid'); }

        $judul = clean($_POST['judul']);
        $thumbnail = !empty($_FILES['thumbnail']['name']) ? upload_image($_FILES['thumbnail'], 'artikel') : null;
        $status = $_POST['status'] ?? 'draft';

        $stmt = $this->db->prepare(
            "INSERT INTO artikel (id_admin, judul, slug, thumbnail, kategori, konten, ringkasan, status, published_at)
             VALUES (:a, :j, :s, :t, :k, :konten, :r, :st, :pub)"
        );
        $stmt->execute([
            'a' => $_SESSION['admin_id'], 'j' => $judul, 's' => generate_slug($judul) . '-' . uniqid(),
            't' => $thumbnail, 'k' => clean($_POST['kategori'] ?? ''),
            'konten' => $_POST['konten'] ?? '', // Catatan: konten dari CKEditor, sanitasi lebih lanjut disarankan (HTML Purifier)
            'r' => clean($_POST['ringkasan'] ?? ''), 'st' => $status,
            'pub' => $status === 'publish' ? date('Y-m-d H:i:s') : null,
        ]);

        log_activity('Artikel', 'create', "Menambahkan artikel: $judul");
        $_SESSION['success'] = 'Artikel berhasil ditambahkan.';
        $this->redirect('adminArtikel');
    }

    public function edit($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM artikel WHERE id_artikel = :id");
        $stmt->execute(['id' => $id]);
        $artikel = $stmt->fetch();
        if (!$artikel) { $this->redirect('adminArtikel'); return; }

        $this->view('admin/artikel/form', [
            'title' => 'Edit Artikel - Admin', 'pageTitle' => 'Edit Artikel',
            'activeMenu' => 'artikel', 'artikel' => $artikel,
        ]);
    }

    public function update($id)
    {
        $this->onlyPost();
        if (!verify_csrf($_POST[CSRF_TOKEN_NAME] ?? '')) { die('Token tidak valid'); }

        $judul = clean($_POST['judul']);
        $status = $_POST['status'] ?? 'draft';

        $sql = "UPDATE artikel SET judul=:j, kategori=:k, konten=:konten, ringkasan=:r, status=:st";
        $params = [
            'j' => $judul, 'k' => clean($_POST['kategori'] ?? ''),
            'konten' => $_POST['konten'] ?? '', 'r' => clean($_POST['ringkasan'] ?? ''),
            'st' => $status, 'id' => $id,
        ];

        if (!empty($_FILES['thumbnail']['name'])) {
            $sql .= ", thumbnail=:t";
            $params['t'] = upload_image($_FILES['thumbnail'], 'artikel');
        }
        $sql .= " WHERE id_artikel=:id";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        log_activity('Artikel', 'update', "Mengubah artikel: $judul");
        $_SESSION['success'] = 'Artikel berhasil diperbarui.';
        $this->redirect('adminArtikel');
    }

    public function hapus($id)
    {
        $stmt = $this->db->prepare("DELETE FROM artikel WHERE id_artikel = :id");
        $stmt->execute(['id' => $id]);
        log_activity('Artikel', 'delete', "Menghapus artikel #$id");
        $_SESSION['success'] = 'Artikel berhasil dihapus.';
        $this->redirect('adminArtikel');
    }
}
