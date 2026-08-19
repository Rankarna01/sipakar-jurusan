<?php require VIEW_PATH . 'layout/admin_header.php'; ?>

<?php if (!empty($_SESSION['success'])): ?>
<div class="alert alert-success alert-auto-dismiss"><?= clean($_SESSION['success']); unset($_SESSION['success']); ?></div>
<?php endif; ?>

<div class="card-modern p-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h6 class="fw-bold mb-0">Daftar Fakultas</h6>
        <a href="<?= BASE_URL ?>adminFakultas/tambah" class="btn btn-gradient rounded-pill px-4"><i class="bi bi-plus-lg me-1"></i> Tambah Fakultas</a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle datatable">
            <thead class="table-light"><tr><th>Kode</th><th>Nama Fakultas</th><th>Jumlah Jurusan</th><th>Status</th><th>Aksi</th></tr></thead>
            <tbody>
            <?php foreach ($fakultas as $f): ?>
                <tr>
                    <td><span class="badge bg-light text-dark border"><?= clean($f['kode_fakultas']) ?></span></td>
                    <td><i class="bi <?= clean($f['icon']) ?> me-2"></i><?= clean($f['nama_fakultas']) ?></td>
                    <td><?= (int) $f['jumlah_jurusan'] ?></td>
                    <td><span class="badge bg-<?= $f['status'] === 'aktif' ? 'success' : 'secondary' ?>"><?= ucfirst($f['status']) ?></span></td>
                    <td>
                        <a href="<?= BASE_URL ?>adminFakultas/edit/<?= $f['id_fakultas'] ?>" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                        <button onclick="confirmDelete('<?= BASE_URL ?>adminFakultas/hapus/<?= $f['id_fakultas'] ?>', '<?= clean($f['nama_fakultas']) ?>')" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require VIEW_PATH . 'layout/admin_footer.php'; ?>
