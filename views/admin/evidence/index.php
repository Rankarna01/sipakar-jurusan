<?php require VIEW_PATH . 'layout/admin_header.php'; ?>
<?php if (!empty($_SESSION['success'])): ?>
<div class="alert alert-success alert-auto-dismiss"><?= clean($_SESSION['success']); unset($_SESSION['success']); ?></div>
<?php endif; ?>
<div class="card-modern p-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h6 class="fw-bold mb-0">Daftar Evidence (<?= count($evidence) ?>)</h6>
        <a href="<?= BASE_URL ?>adminEvidence/tambah" class="btn btn-gradient rounded-pill px-4"><i class="bi bi-plus-lg me-1"></i> Tambah Evidence</a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle datatable">
            <thead class="table-light"><tr><th>Kode</th><th>Nama Evidence</th><th>Kategori</th><th>Status</th><th>Aksi</th></tr></thead>
            <tbody>
            <?php foreach ($evidence as $e): ?>
                <tr>
                    <td><span class="badge bg-light text-dark border"><?= clean($e['kode_evidence']) ?></span></td>
                    <td><?= clean($e['nama_evidence']) ?></td>
                    <td><span class="badge bg-info text-dark text-capitalize"><?= str_replace('_',' ',$e['kategori']) ?></span></td>
                    <td><span class="badge bg-<?= $e['status']==='aktif'?'success':'secondary' ?>"><?= ucfirst($e['status']) ?></span></td>
                    <td>
                        <a href="<?= BASE_URL ?>adminEvidence/edit/<?= $e['id_evidence'] ?>" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                        <button onclick="confirmDelete('<?= BASE_URL ?>adminEvidence/hapus/<?= $e['id_evidence'] ?>', '<?= clean($e['nama_evidence']) ?>')" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php require VIEW_PATH . 'layout/admin_footer.php'; ?>
