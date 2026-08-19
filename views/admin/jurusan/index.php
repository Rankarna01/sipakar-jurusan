<?php require VIEW_PATH . 'layout/admin_header.php'; ?>

<?php if (!empty($_SESSION['success'])): ?>
<div class="alert alert-success alert-auto-dismiss"><?= clean($_SESSION['success']); unset($_SESSION['success']); ?></div>
<?php endif; ?>

<div class="card-modern p-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h6 class="fw-bold mb-0">Daftar Jurusan (<?= count($jurusan) ?>)</h6>
        <a href="<?= BASE_URL ?>adminJurusan/tambah" class="btn btn-gradient rounded-pill px-4"><i class="bi bi-plus-lg me-1"></i> Tambah Jurusan</a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle datatable">
            <thead class="table-light"><tr><th>Kode</th><th>Nama Jurusan</th><th>Fakultas</th><th>Status</th><th>Aksi</th></tr></thead>
            <tbody>
            <?php foreach ($jurusan as $j): ?>
                <tr>
                    <td><span class="badge bg-light text-dark border"><?= clean($j['kode_jurusan']) ?></span></td>
                    <td><?= clean($j['nama_jurusan']) ?></td>
                    <td class="text-muted small"><?= clean($j['nama_fakultas']) ?></td>
                    <td><span class="badge bg-<?= $j['status'] === 'aktif' ? 'success' : 'secondary' ?>"><?= ucfirst($j['status']) ?></span></td>
                    <td>
                        <a href="<?= BASE_URL ?>adminJurusan/edit/<?= $j['id_jurusan'] ?>" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                        <a href="<?= BASE_URL ?>adminAturan/jurusan/<?= $j['id_jurusan'] ?>" class="btn btn-sm btn-outline-info" title="Lihat Aturan"><i class="bi bi-diagram-3"></i></a>
                        <button onclick="confirmDelete('<?= BASE_URL ?>adminJurusan/hapus/<?= $j['id_jurusan'] ?>', '<?= clean($j['nama_jurusan']) ?>')" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require VIEW_PATH . 'layout/admin_footer.php'; ?>
