<?php require VIEW_PATH . 'layout/admin_header.php'; ?>
<?php if (!empty($_SESSION['success'])): ?>
<div class="alert alert-success alert-auto-dismiss"><?= clean($_SESSION['success']); unset($_SESSION['success']); ?></div>
<?php endif; ?>
<div class="card-modern p-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h6 class="fw-bold mb-0">Daftar Artikel (<?= count($artikel) ?>)</h6>
        <a href="<?= BASE_URL ?>adminArtikel/tambah" class="btn btn-gradient rounded-pill px-4"><i class="bi bi-plus-lg me-1"></i> Tulis Artikel</a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle datatable">
            <thead class="table-light"><tr><th>Judul</th><th>Kategori</th><th>Views</th><th>Status</th><th>Tanggal</th><th>Aksi</th></tr></thead>
            <tbody>
            <?php foreach ($artikel as $a): ?>
                <tr>
                    <td><?= clean($a['judul']) ?></td>
                    <td><?= clean($a['kategori'] ?? '-') ?></td>
                    <td><?= (int) $a['views'] ?></td>
                    <td><span class="badge bg-<?= $a['status']==='publish'?'success':'warning' ?>"><?= ucfirst($a['status']) ?></span></td>
                    <td class="text-muted small"><?= format_tanggal($a['created_at']) ?></td>
                    <td>
                        <a href="<?= BASE_URL ?>adminArtikel/edit/<?= $a['id_artikel'] ?>" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                        <button onclick="confirmDelete('<?= BASE_URL ?>adminArtikel/hapus/<?= $a['id_artikel'] ?>', '<?= clean($a['judul']) ?>')" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($artikel)): ?>
                <!-- DataTables will handle empty state automatically -->
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php require VIEW_PATH . 'layout/admin_footer.php'; ?>
